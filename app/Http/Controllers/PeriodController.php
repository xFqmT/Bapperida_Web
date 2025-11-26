<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeriodsExport;

class PeriodController extends Controller
{
    // Tampilkan daftar periode
    public function index(Request $request)
    {
        $query = Period::orderBy('tanggal_akhir', 'asc');

        // Filter by name
        if ($request->has('q') && !empty($request->q)) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        // Filter by date range
        if ($request->has('from') && !empty($request->from)) {
            $query->where('tanggal_awal', '>=', $request->from);
        }

        if ($request->has('to') && !empty($request->to)) {
            $query->where('tanggal_akhir', '<=', $request->to);
        }

        // Get all periods (not soft deleted)
        $periods = $query->get();
        
        // Separate active and completed periods
        $activePeriods = $periods->filter(function($period) {
            return $period->status_period !== 'selesai';
        });
        
        $completedPeriods = $periods->filter(function($period) {
            return $period->status_period === 'selesai';
        });
        
        return view('dashboard', compact('periods', 'activePeriods', 'completedPeriods'));
    }

    // Tampilkan form tambah periode
    public function create()
    {
        return view('periods.create');
    }

    // Simpan periode baru
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_awal' => 'required|date',
        ]);

        Period::create([
            'nama' => $request->nama,
            'tanggal_awal' => $request->tanggal_awal,
        ]);

        return redirect()->route('periods.index')->with('success', 'Periode berhasil ditambahkan!');
    }

    // Tampilkan form edit periode
    public function edit(Period $period)
    {
        return view('periods.edit', compact('period'));
    }

    // Update periode
    public function update(Request $request, Period $period): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_awal' => 'required|date',
        ]);

        $period->update([
            'nama' => $request->nama,
            'tanggal_awal' => $request->tanggal_awal,
        ]);

        return redirect()->route('periods.index')->with('success', 'Periode berhasil diperbarui!');
    }

    // Hapus periode (soft delete)
    public function destroy(Period $period): RedirectResponse
    {
        $period->delete(); // Soft delete
        return redirect()->route('periods.index')->with('success', 'Periode berhasil disembunyikan!');
    }
    
    // Sembunyikan periode (alias untuk destroy)
    public function hide(Period $period): RedirectResponse
    {
        return $this->destroy($period);
    }

    // Tampilkan form import Excel
    public function showImportForm()
    {
        return view('periods.import');
    }

    // Import Excel
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new PeriodsImport, $request->file('file'));
            return redirect()->route('periods.index')->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // Export Excel
    public function export(Request $request)
    {
        $query = Period::orderBy('tanggal_akhir', 'asc');

        // Apply same filters as index
        if ($request->has('q') && !empty($request->q)) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        if ($request->has('from') && !empty($request->from)) {
            $query->where('tanggal_awal', '>=', $request->from);
        }

        if ($request->has('to') && !empty($request->to)) {
            $query->where('tanggal_akhir', '<=', $request->to);
        }

        $periods = $query->get();

        return Excel::download(new PeriodsExport($periods), 'periode_gaji_berkala_' . date('Y-m-d') . '.xlsx');
    }

    // 🔥 Ini adalah fungsi yang kamu buat
    public function complete(Period $period): RedirectResponse
    {
        // Pastikan hanya periode 'active' yang bisa diselesaikan
        if ($period->status !== 'active') {
            return back()->with('error', 'Periode ini sudah selesai.');
        }

        // Tandai periode lama sebagai completed
        $period->update(['status' => 'completed']);

        // Buat periode baru berdasarkan hari ini
        Period::create([
            'nama' => $period->nama,
            'tanggal_awal' => now()->format('Y-m-d'),
            // tanggal_akhir otomatis dihitung oleh mutator di model
        ]);

        return redirect()->back()->with('success', 'Periode diperbarui!');
    }
}