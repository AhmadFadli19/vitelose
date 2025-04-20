<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

        $saldo = Saldo::where('user_id', $userId)->get();
        $saldo_transaksi = Transaksi::where('user_id', $userId)->get();
        $user = User::findOrFail($userId);

        $transaksi_dana = DB::table('transaksi_dana')
            ->where('user_id', $userId)
            ->where('confirmed', 'sukses')
            ->get();

        $saldo_user = Saldo::where('user_id', $userId)->first();

        $total_saldo = 0;
        if ($saldo->count() > 0) {
            $total_saldo = $saldo->first()->amount;
        }

        $pemasukan = 0;
        $pengeluaran = 0;

        foreach ($transaksi_dana as $transaksi) {
            if ($transaksi->type == 'top_up') {
                $pemasukan += $transaksi->amount;
            } elseif ($transaksi->type == 'withdraw') {
                $pengeluaran += $transaksi->amount;
            } elseif ($transaksi->type == 'transfer') {
                if ($transaksi->deskripsi && strpos($transaksi->deskripsi, 'received from') !== false) {
                    $pemasukan += $transaksi->amount;
                } else {
                    $pengeluaran += $transaksi->amount;
                }
            }
        }

        $percentage_change = 0;
        if ($pengeluaran > 0) {
            $percentage_change = round((($pemasukan - $pengeluaran) / $pengeluaran) * 100, 2);
        }

        $teman = User::where('id', '!=', $userId)
            ->where('usertype', 'user')
            ->get();

        return view('user.index', compact(
            'saldo_transaksi',
            'saldo',
            'user',
            'teman',
            'total_saldo',
            'pemasukan',
            'pengeluaran',
            'percentage_change',
            'saldo_user'
        ));
    }

    public function UserTransferDashboard()
    {
        $user = Auth::user();
        $userId = $user->id;
        $saldo_transaksi = Transaksi::where('user_id', $userId)->get();
        $user = User::findOrFail($userId);
        $transaksi_dana = DB::table('transaksi_dana')
            ->where('user_id', $userId)
            ->where('confirmed', 'sukses')
            ->get();

        $saldo_user = Saldo::where('user_id', $userId)->first();


        $saldo = Saldo::firstOrCreate(
            ['user_id' => $userId],
            ['amount' => 0] 
        );

        $total_saldo = $saldo->amount;
        $pemasukan = 0;
        $pengeluaran = 0;

        foreach ($transaksi_dana as $transaksi) {
            if ($transaksi->type == 'top_up') {
                $pemasukan += $transaksi->amount;
            } elseif ($transaksi->type == 'withdraw') {
                $pengeluaran += $transaksi->amount;
            } elseif ($transaksi->type == 'transfer') {
                if ($transaksi->deskripsi && strpos($transaksi->deskripsi, 'received from') !== false) {
                    $pemasukan += $transaksi->amount;
                } else {
                    $pengeluaran += $transaksi->amount;
                }
            }
        }

        $percentage_change = 0;
        if ($pengeluaran > 0) {
            $percentage_change = round((($pemasukan - $pengeluaran) / $pengeluaran) * 100, 2);
        }

        $teman = User::where('id', '!=', $userId)
            ->where('usertype', 'user')
            ->get();

        return view('user.transfer', compact(
            'saldo_transaksi',
            'saldo',
            'user',
            'teman',
            'total_saldo',
            'pemasukan',
            'pengeluaran',
            'percentage_change',
            'saldo_user'
        ));
    }

    public function masukkan_dana(Request $request)
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

        return redirect()->route('user-home')->with('success', 'Permintaan top up dana berhasil dibuat dan sedang menunggu konfirmasi');
    }

    public function keluarkan_dana(Request $request)
    {
        $userId = Auth::id();
        $saldo = Saldo::where('user_id', $userId)->first();

        if (!$saldo || $saldo->saldo < $request->withdraw) {
            return redirect()->route('user-home')->with('error', 'Saldo tidak mencukupi');
        }

        
        $transaksi = new Transaksi();
        $transaksi->user_id = $userId;
        $transaksi->type = 'withdraw';
        $transaksi->amount = $request->withdraw;
        $transaksi->confirmed = 'pending'; 
        $transaksi->save();

        return redirect()->route('user-home')->with('success', 'Permintaan penarikan berhasil dibuat dan sedang menunggu konfirmasi');
    }

    public function transfer_dana(Request $request)
    {
        $userId = Auth::id();
        $saldo = Saldo::where('user_id', $userId)->first();

        
        $transferAmount = $request->transfer;

        
        if ($saldo->saldo < $transferAmount) {
            return redirect()->route('user-home')->with('error', 'Saldo tidak cukup');
        }
        
        $userTujuan = User::where('name', $request->namateman)->first();

        if (!$userTujuan) {
            return redirect()->route('user-home')->with('error', 'User tidak ditemukan');
        }

        $transaksi = new Transaksi();
        $transaksi->type = 'transfer';
        $transaksi->amount = $transferAmount;
        $transaksi->deskripsi = "Transfer untuk " . $userTujuan->name . ": " . $request->deskripsi;
        $transaksi->user_id = $userId;
        $transaksi->confirmed = 'pending'; 
        $transaksi->save();

        return redirect()->route('user-home')->with('success', 'Permintaan transfer dana berhasil dibuat dan sedang menunggu konfirmasi');
    }

    
}

