<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generatePDFAll()
    {
        $user = Auth::user();
        $userId = $user->id;

        $saldo = Saldo::where('user_id', $userId)->first();
        $saldo_transaksi = Transaksi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $type = 'all'; 
        $pdf = Pdf::loadView('pdf', compact('saldo_transaksi', 'saldo', 'user', 'type'));
        return $pdf->download('semua-transaksi-' . date('Y-m-d') . '.pdf');
    }

    public function generatePDFSingle($id)
    {
        $user = Auth::user();
        $userId = $user->id;

        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $saldo = Saldo::where('user_id', $userId)->first();
        $saldo_transaksi = [$transaksi];
        $type = 'single';

        $pdf = Pdf::loadView('pdf', compact('saldo_transaksi', 'saldo', 'user', 'type', 'transaksi'));
        return $pdf->download('transaksi-' . $id . '-' . date('Y-m-d') . '.pdf');
    }
}
