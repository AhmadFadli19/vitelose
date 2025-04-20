<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $TotalAkun = User::count();
        $SemuaAkun = User::all();
        $TotalSaldo = Saldo::sum('saldo');

        $TotalTransaksi = Transaksi::count();
        $TransaksiSukses = Transaksi::where('confirmed', 'sukses')->count();
        $TransaksiPending = Transaksi::where('confirmed', 'pending')->count();
        $TransaksiTolak = Transaksi::where('confirmed', 'tolak')->count();

        return view('admin.index', compact('SemuaAkun', 'TotalAkun', 'TotalSaldo', 'TransaksiTolak', 'TotalTransaksi', 'TransaksiSukses', 'TransaksiPending'));
    }

    function search(Request $request)
    {
        $SemuaAkun = User::all();
        $TotalAkunAdmin = User::where('usertype', 'admin')->count();
        $TotalAkunUser = User::where('usertype', 'user')->count();
        $TotalAkunBank = User::where('usertype', 'bank')->count();

        $search = $request->search;
        $data_user = User::where('name', 'like', "%$search%")
            ->get();

        return view('admin.KelolaAkun', [
            'SemuaAkun' => $data_user
        ], compact('data_user', 'TotalAkunAdmin', 'TotalAkunUser', 'TotalAkunBank', 'SemuaAkun'));
    }

    public function kelolaakun()
    {
        $SemuaAkun = User::all();
        $TotalAkunAdmin = User::where('usertype', 'admin')->count();
        $TotalAkunUser = User::where('usertype', 'user')->count();
        $TotalAkunBank = User::where('usertype', 'bank')->count();

        return view('admin.KelolaAkun', compact('TotalAkunAdmin', 'TotalAkunUser', 'TotalAkunBank', 'SemuaAkun'));
    }

    public function transaksi()
    {

        $saldo = Saldo::get();
        $saldo_transaksi = Transaksi::get();

        $TotalSaldo = Saldo::sum('saldo');

        $TotalTransaksi = Transaksi::count();
        $TransaksiSukses = Transaksi::where('confirmed', 'sukses')->count();
        $TransaksiPending = Transaksi::where('confirmed', 'pending')->count();
        $TransaksiTolak = Transaksi::where('confirmed', 'tolak')->count();

        return view('admin.transaksi', compact('saldo','saldo_transaksi', 'TotalSaldo', 'TransaksiTolak', 'TotalTransaksi', 'TransaksiSukses', 'TransaksiPending'));
    }

    public function registar_proses(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'usertype' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('admin-kelolaakun');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->usertype = $request->usertype;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin-kelolaakun');
    }

    public function akun_delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin-kelolaakun');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/')->alert('success', 'Kamu berhasil logout');
    }

    public function registar()
    {
        return view('auth.registar');
    }
}
