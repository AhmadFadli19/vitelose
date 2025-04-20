<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        $saldo_transaksi = Transaksi::where('user_id', $userId)->get();

        $TotalAkun = User::count();
        $SemuaAkun = User::with('saldo')->where('usertype', 'user')->get();
        $TotalAkunAdmin = User::where('usertype', 'admin')->count();
        $TotalAkunUser = User::where('usertype', 'user')->count();
        $TotalAkunBank = User::where('usertype', 'bank')->count();
        $TotalSaldo = Saldo::sum('saldo');

        $TotalTransaksi = Transaksi::count();
        $TransaksiSukses = Transaksi::where('confirmed', 'sukses')->count();
        $TransaksiPending = Transaksi::where('confirmed', 'pending')->count();
        $TransaksiTolak = Transaksi::where('confirmed', 'tolak')->count();

        $teman = User::where('id', '!=', $userId)
            ->where('usertype', 'user')
            ->get();

        $pendingTransaksi = Transaksi::where('confirmed', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $recentTransaksi = Transaksi::where('confirmed', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('bank.index', compact('TotalAkunAdmin', 'TotalAkunUser', 'TotalAkunBank', 'SemuaAkun', 'saldo_transaksi', 'user', 'teman', 'pendingTransaksi', 'recentTransaksi', 'SemuaAkun', 'TotalAkun', 'TotalSaldo', 'TransaksiTolak', 'TotalTransaksi', 'TransaksiSukses', 'TransaksiPending'));
    }

    public function masukkan_dana_bank(Request $request)
    {
        $userId = Auth::id();
        $saldo = Saldo::where('user_id', $userId)->first();

        if (!$saldo) {
            $saldo = new Saldo();
            $saldo->user_id = $userId;
            $saldo->saldo = 0;
            $saldo->save();
        }


        $transaksi = new Transaksi();
        $transaksi->type = 'top_up';
        $transaksi->amount = $request->top_up_form;
        $transaksi->user_id = $userId;
        $transaksi->confirmed = 'pending';
        $transaksi->save();

        return redirect()->route('bank-home')->with('success', 'Permintaan top up dana berhasil dibuat dan sedang menunggu konfirmasi');
    }

    public function keluarkan_dana_bank(Request $request)
    {
        $userId = Auth::id();

        $targetUser = User::where('name', $request->nama_user)->first();

        if (!$targetUser) {
            return redirect()->route('bank-home')->with('error', 'User tidak ditemukan');
        }

        
        $saldoTarget = Saldo::where('user_id', $targetUser->id)->first();

        if (!$saldoTarget || $saldoTarget->saldo < $request->jumlah_withdraw) {
            return redirect()->route('bank-home')->with('error', 'Saldo user tidak mencukupi untuk pencairan');
        }

        $transaksi = new Transaksi();
        $transaksi->type = 'withdraw';
        $transaksi->amount = $request->jumlah_withdraw;
        
        $adminName = Auth::user()->name;
        $transaksi->deskripsi = "Pencairan dana untuk " . $targetUser->name . " diminta oleh " . $adminName;
        $transaksi->user_id = $targetUser->id; 
        $transaksi->confirmed = 'pending';
        $transaksi->save();

        return redirect()->route('bank-home')->with('success', 'Permintaan pencairan dana berhasil dibuat dan sedang menunggu konfirmasi');
    }

    public function transfer_dana_bank(Request $request)
    {
        $userId = Auth::id();
        $userPengirim = User::find($userId);

        
        $userTujuan = User::where('name', $request->namateman)->first();

        if (!$userTujuan) {
            return redirect()->route('bank-home')->with('error', 'User tidak ditemukan');
        }

        
        $transaksi = new Transaksi();
        $transaksi->type = 'transfer';
        $transaksi->amount = $request->transfer;
        $transaksi->deskripsi = "Transfer untuk " . $userTujuan->name . ": " . $request->deskripsi;
        $transaksi->user_id = $userId; 
        $transaksi->confirmed = 'pending';
        $transaksi->save();

        return redirect()->route('bank-home')->with('success', 'Permintaan transfer dana berhasil dibuat dan sedang menunggu konfirmasi');
    }


    public function konfirmasi_transaksi(Request $request, $transaksiId)
    {
        $transaksi = Transaksi::findOrFail($transaksiId);
        $user = User::findOrFail($transaksi->user_id);

        $saldoPengirim = Saldo::firstOrCreate(['user_id' => $transaksi->user_id], ['saldo' => 0]);

        if ($request->status === 'sukses') {
            if ($transaksi->type === 'transfer') {
                $recipientName = null;

                
                if (preg_match('/Transfer untuk\s+([^:]+):/i', $transaksi->deskripsi, $matches)) {
                    $recipientName = trim($matches[1]);
                    $userTujuan = User::where('name', $recipientName)->first();
                }

                if (!$userTujuan) {
                    $transaksi->confirmed = 'tolak';
                    $transaksi->save();
                    return redirect()->back()->with('error', 'Transfer gagal, penerima tidak ditemukan');
                }

                
                if ($saldoPengirim->saldo < $transaksi->amount) {
                    $transaksi->confirmed = 'tolak';
                    $transaksi->save();
                    return redirect()->back()->with('error', 'Transfer gagal, saldo pengirim tidak mencukupi');
                }

                $saldoTujuan = Saldo::firstOrCreate(['user_id' => $userTujuan->id], ['saldo' => 0]);

                
                $saldoPengirim->decrement('saldo', $transaksi->amount);

                
                $saldoTujuan->increment('saldo', $transaksi->amount);

                
                Transaksi::create([
                    'user_id' => $userTujuan->id,
                    'type' => 'top_up',
                    'amount' => $transaksi->amount,
                    'deskripsi' => "Transfer dari " . $user->name,
                    'confirmed' => 'sukses'
                ]);
            } elseif ($transaksi->type === 'top_up') {
                $saldoPengirim->increment('saldo', $transaksi->amount);
            } elseif ($transaksi->type === 'withdraw') {
                if ($saldoPengirim->saldo < $transaksi->amount) {
                    $transaksi->confirmed = 'tolak';
                    $transaksi->save();
                    return redirect()->back()->with('error', 'Saldo tidak cukup untuk penarikan');
                }

                $saldoPengirim->decrement('saldo', $transaksi->amount);
            }

            $transaksi->confirmed = 'sukses';
            $transaksi->save();

            return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi');
        }

        $transaksi->confirmed = 'tolak';
        $transaksi->save();

        return redirect()->back()->with('info', 'Transaksi telah ditolak');
    }

    public function transferDashboard()
    {
        $SemuaAkun = User::with('saldo')->where('usertype', 'user')->get();

        $user = Auth::user();
        $userId = $user->id;

        $teman = User::where('id', '!=', $userId)
            ->where('usertype', 'user')
            ->get();
        return view('bank.transfer', compact('teman', 'user', 'SemuaAkun'));
    }

    public function kelolaakun()
    {
        $user = Auth::user();

        $SemuaAkun = User::where('usertype', 'user')->get();
        $TotalAkunAdmin = User::where('usertype', 'admin')->count();
        $TotalAkunUser = User::where('usertype', 'user')->count();
        $TotalAkunBank = User::where('usertype', 'bank')->count();

        return view('bank.KelolaAkun', compact('TotalAkunAdmin', 'TotalAkunUser', 'TotalAkunBank', 'SemuaAkun', 'user'));
    }

    public function bank_Search(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $saldo = Saldo::where('user_id', $userId)->get();
        $saldo_transaksi = Transaksi::where('user_id', $userId)->get();

        $teman = User::where('id', '!=', $userId)
            ->where('usertype', 'user')
            ->get();

        $pendingTransaksi = Transaksi::where('confirmed', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $search = $request->banksearch;
        $hasilusersearch = Transaksi::where('confirmed', 'like', "%$search%")
            ->orWhere('created_at', 'like', "%$search%")
            ->orWhere('type', 'like', "%$search%")
            ->orWhere('amount', 'like', "%$search%")
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->get();

        return view('bank.index', [
            'recentTransaksi' => $hasilusersearch
        ], compact('saldo_transaksi', 'saldo', 'user', 'teman', 'pendingTransaksi', 'hasilusersearch'));
    }
}
