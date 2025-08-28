<?php

namespace App\Http\Controllers;

use App\Models\Skck;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Convert to Carbon instances for proper date handling
        $startDate = $request->start_date 
            ? Carbon::parse($request->start_date)->startOfDay() 
            : now()->startOfMonth();
        
        $endDate = $request->end_date 
            ? Carbon::parse($request->end_date)->endOfDay() 
            : now()->endOfDay();

        $skckIssueFee = Setting::getValue('skck_issue_fee', 50000);
        $skckLegalizeFee = Setting::GetValue('skck_legalize_fee', 25000);

        // Debug: Check data
        $totalDataInSystem = Skck::count();
        $dataInRange = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])->count();

        // Hitung total per jenis pembayaran
        $totalSkck = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])->count();
        $tunaiCount = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])->where('jenis_pembayaran', 'tunai')->count();
        $onlineCount = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])->where('jenis_pembayaran', 'online')->count();
        $onlineSudahBayarCount = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])->where('jenis_pembayaran', 'online_sudah_bayar')->count();

        // Hitung pendapatan per jenis dengan pemisahan SKCK dan Legalisir
        $pendapatanTunai = $this->hitungPendapatan('tunai', $startDate, $endDate, $skckIssueFee, $skckLegalizeFee);
        $pendapatanOnline = $this->hitungPendapatan('online', $startDate, $endDate, $skckIssueFee, $skckLegalizeFee);
        $pendapatanOnlineSudahBayar = $this->hitungPendapatan('online_sudah_bayar', $startDate, $endDate, $skckIssueFee, $skckLegalizeFee);

        // Pisah pendapatan SKCK dan Legalisir
        $pendapatanSkckTunai = $tunaiCount * $skckIssueFee;
        $pendapatanLegalisirTunai = $tunaiCount * $skckLegalizeFee;
        
        $pendapatanSkckOnline = $onlineCount * $skckIssueFee;
        $pendapatanLegalisirOnline = $onlineCount * $skckLegalizeFee;
        
        $pendapatanSkckOnlineSudahBayar = 0; // Online sudah bayar tidak bayar SKCK lagi
        $pendapatanLegalisirOnlineSudahBayar = $onlineSudahBayarCount * $skckLegalizeFee;

        // Total per kategori
        $totalPendapatanSkck = $pendapatanSkckTunai + $pendapatanSkckOnline + $pendapatanSkckOnlineSudahBayar;
        $totalPendapatanLegalisir = $pendapatanLegalisirTunai + $pendapatanLegalisirOnline + $pendapatanLegalisirOnlineSudahBayar;
        $totalPendapatan = $totalPendapatanSkck + $totalPendapatanLegalisir;

        // Data untuk chart
        $chartData = $this->getChartData($startDate, $endDate, $skckIssueFee, $skckLegalizeFee);

        // Data harian dengan pemisahan SKCK dan Legalisir
        $dailyData = $this->getDailyData($startDate, $endDate, $skckIssueFee, $skckLegalizeFee);

        return view('reports.index', compact(
            'totalSkck',
            'tunaiCount',
            'onlineCount',
            'onlineSudahBayarCount',
            'pendapatanTunai',
            'pendapatanOnline',
            'pendapatanOnlineSudahBayar',
            'pendapatanSkckTunai',
            'pendapatanLegalisirTunai',
            'pendapatanSkckOnline',
            'pendapatanLegalisirOnline',
            'pendapatanSkckOnlineSudahBayar',
            'pendapatanLegalisirOnlineSudahBayar',
            'totalPendapatanSkck',
            'totalPendapatanLegalisir',
            'totalPendapatan',
            'skckIssueFee',
            'skckLegalizeFee',
            'chartData',
            'dailyData',
            'startDate',
            'endDate',
            'totalDataInSystem',
            'dataInRange'
        ));
    }

    private function hitungPendapatan($jenis, $startDate, $endDate, $issueFee, $legalizeFee)
    {
        $count = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])
            ->where('jenis_pembayaran', $jenis)
            ->count();

        if ($jenis === 'online_sudah_bayar') {
            // Hanya bayar legalisir saja
            return $count * $legalizeFee;
        }

        // Bayar full (SKCK + Legalisir)
        return $count * ($issueFee + $legalizeFee);
    }

    private function getChartData($startDate, $endDate, $issueFee, $legalizeFee)
    {
        $data = Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])
            ->select([
                DB::raw('DATE(tanggal_dibuat) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "tunai" THEN 1 ELSE 0 END) as tunai_count'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online" THEN 1 ELSE 0 END) as online_count'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online_sudah_bayar" THEN 1 ELSE 0 END) as online_sudah_bayar_count'),
                // Pendapatan per kategori
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "tunai" THEN ' . ($issueFee + $legalizeFee) . ' 
                         WHEN jenis_pembayaran = "online" THEN ' . ($issueFee + $legalizeFee) . ' 
                         WHEN jenis_pembayaran = "online_sudah_bayar" THEN ' . $legalizeFee . ' 
                         ELSE 0 END) as total_income'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran != "online_sudah_bayar" THEN ' . $issueFee . ' ELSE 0 END) as skck_income'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "tunai" THEN ' . $legalizeFee . ' 
                         WHEN jenis_pembayaran = "online" THEN ' . $legalizeFee . ' 
                         WHEN jenis_pembayaran = "online_sudah_bayar" THEN ' . $legalizeFee . ' 
                         ELSE 0 END) as legalize_income')
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
            'counts' => $data->pluck('count'),
            'tunai' => $data->pluck('tunai_count'),
            'online' => $data->pluck('online_count'),
            'online_sudah_bayar' => $data->pluck('online_sudah_bayar_count'),
            'incomes' => $data->pluck('total_income'),
            'skck_incomes' => $data->pluck('skck_income'),
            'legalize_incomes' => $data->pluck('legalize_income')
        ];
    }

    private function getDailyData($startDate, $endDate, $issueFee, $legalizeFee)
    {
        return Skck::whereBetween('tanggal_dibuat', [$startDate, $endDate])
            ->select([
                DB::raw('DATE(tanggal_dibuat) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "tunai" THEN 1 ELSE 0 END) as tunai'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online" THEN 1 ELSE 0 END) as online'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online_sudah_bayar" THEN 1 ELSE 0 END) as online_sudah_bayar'),
                // Hitung pendapatan per kategori
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "tunai" THEN ' . $issueFee . ' ELSE 0 END) as skck_tunai'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "tunai" THEN ' . $legalizeFee . ' ELSE 0 END) as legalize_tunai'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online" THEN ' . $issueFee . ' ELSE 0 END) as skck_online'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online" THEN ' . $legalizeFee . ' ELSE 0 END) as legalize_online'),
                DB::raw('SUM(CASE WHEN jenis_pembayaran = "online_sudah_bayar" THEN ' . $legalizeFee . ' ELSE 0 END) as legalize_online_sb')
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                // Total per kategori
                $item->total_skck = $item->skck_tunai + $item->skck_online;
                $item->total_legalize = $item->legalize_tunai + $item->legalize_online + $item->legalize_online_sb;
                $item->total_pendapatan = $item->total_skck + $item->total_legalize;
                
                // Pendapatan per jenis pembayaran
                $item->pendapatan_tunai = $item->skck_tunai + $item->legalize_tunai;
                $item->pendapatan_online = $item->skck_online + $item->legalize_online;
                $item->pendapatan_online_sudah_bayar = $item->legalize_online_sb;
                
                return $item;
            });
    }
}