<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Pelanggan;
use App\Models\Pesanan;

class LaporanPdfController extends Controller
{
    /**
     * Generate PDF untuk satu laporan
     */
    public function single($id)
    {
        $transaksi = Transaksi::with(['pesanan.pelanggan', 'pesanan.menu'])
            ->findOrFail($id);
        
        $data = [
            'transaksi' => $transaksi,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i:s'),
            'title' => 'Laporan Transaksi #' . $transaksi->idtransaksi
        ];
        
        $pdf = Pdf::loadView('laporan.pdf.single', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-transaksi-' . $transaksi->idtransaksi . '.pdf');
    }
    
    /**
     * Generate PDF untuk semua laporan
     */
    public function all(Request $request)
    {
        $query = Transaksi::with(['pesanan.pelanggan', 'pesanan.menu']);
        
        // Filter berdasarkan tanggal jika ada
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        
        $data = [
            'transaksis' => $transaksis,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i:s'),
            'title' => 'Laporan Semua Transaksi',
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'total_transaksi' => $transaksis->count(),
            'total_pendapatan' => $transaksis->sum('total')
        ];
        
        $pdf = Pdf::loadView('laporan.pdf.all', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'laporan-semua-transaksi-' . Carbon::now()->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
    
    /**
     * Generate PDF yang menggabungkan semua transaksi/pesanan untuk satu pelanggan
     */
    public function byPelanggan(Request $request, $idpelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($idpelanggan);

        // Ambil SEMUA pesanan milik pelanggan (baik yang sudah punya transaksi maupun belum)
        $query = Pesanan::with(['menu', 'pelanggan', 'transaksi'])
            ->where('idpelanggan', $idpelanggan)
            ->orderBy('created_at', 'asc');

        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $items = $query->get();

        // Total pendapatan: gunakan total transaksi jika ada, kalau belum ada pakai total pesanan
        $totalPendapatan = $items->sum(function ($p) {
            return (int) ($p->transaksi->total ?? $p->harga);
        });

        $data = [
            'pelanggan' => $pelanggan,
            'items' => $items,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i:s'),
            'title' => 'Laporan Transaksi Pelanggan: ' . $pelanggan->namapelanggan,
            'total_transaksi' => $items->count(),
            'total_pendapatan' => $totalPendapatan,
        ];

        $pdf = Pdf::loadView('laporan.pdf.by_pelanggan', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'laporan-pelanggan-' . str_replace(' ', '-', strtolower($pelanggan->namapelanggan)) . '-' . Carbon::now()->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

}
