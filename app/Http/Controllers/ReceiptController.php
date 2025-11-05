<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate and download receipt for a single transaction
     */
    public function print($id)
    {
        $transaksi = Transaksi::with(['pesanan.menu', 'pesanan.pelanggan'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('receipt.single', compact('transaksi'));
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Struk_' . $transaksi->idtransaksi . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Generate and download receipt for multiple transactions
     */
    public function printMultiple(Request $request)
    {
        $request->validate([
            'transaksi_ids' => 'required|array|min:1',
            'transaksi_ids.*' => 'exists:transaksi,idtransaksi'
        ]);

        $transaksis = Transaksi::with(['pesanan.menu', 'pesanan.pelanggan'])
            ->whereIn('idtransaksi', $request->transaksi_ids)
            ->orderBy('tgl', 'desc')
            ->get();

        if ($transaksis->isEmpty()) {
            return back()->with('error', 'Tidak ada transaksi yang dipilih.');
        }

        $pdf = Pdf::loadView('receipt.multiple', compact('transaksis'));
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Struk_Multiple_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Generate and download receipt for today's transactions
     */
    public function printToday()
    {
        $transaksis = Transaksi::with(['pesanan.menu', 'pesanan.pelanggan'])
            ->whereDate('tgl', today())
            ->orderBy('tgl', 'desc')
            ->get();

        if ($transaksis->isEmpty()) {
            return back()->with('error', 'Tidak ada transaksi hari ini.');
        }

        $pdf = Pdf::loadView('receipt.multiple', compact('transaksis'));
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Struk_Hari_Ini_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Generate grouped receipt by pelanggan (gabung semua pesanan pelanggan)
     */
    public function printByPelanggan($idpelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($idpelanggan);

        $items = Pesanan::with(['menu', 'pelanggan', 'transaksi'])
            ->where('idpelanggan', $idpelanggan)
            ->orderBy('created_at', 'asc')
            ->get();

        $pdf = Pdf::loadView('receipt.by_pelanggan', [
            'pelanggan' => $pelanggan,
            'items' => $items,
        ]);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Struk_Pelanggan_' . str_replace(' ', '-', strtolower($pelanggan->namapelanggan)) . '_' . date('Y-m-d_H-i-s') . '.pdf';
        return $pdf->download($filename);
    }
}











