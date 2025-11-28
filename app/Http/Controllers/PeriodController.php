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

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $status = $request->status;
            
            if ($status === 'terlambat') {
                // Filter overdue periods
                $query->where('tanggal_akhir', '<', now());
            } elseif ($status === 'selesai') {
                // Filter completed periods
                $query->where('status', 'completed');
            } else {
                // Filter active periods by status logic
                $query->where('status', 'active')->where(function($q) use ($status) {
                    $now = now();
                    if ($status === 'deadline') {
                        // 0-2 months remaining
                        $q->where('tanggal_akhir', '>=', $now)
                          ->where('tanggal_akhir', '<=', $now->copy()->addMonths(2));
                    } elseif ($status === 'segera') {
                        // 2-4 months remaining  
                        $q->where('tanggal_akhir', '>', $now->copy()->addMonths(2))
                          ->where('tanggal_akhir', '<=', $now->copy()->addMonths(4));
                    } elseif ($status === 'proses') {
                        // More than 4 months remaining
                        $q->where('tanggal_akhir', '>', $now->copy()->addMonths(4));
                    }
                });
            }
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
        
        // Get hidden periods (soft deleted)
        $hiddenPeriods = Period::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        
        // Separate active and completed periods
        $activePeriods = $periods->filter(function($period) {
            return $period->status_period !== 'selesai';
        });
        
        $completedPeriods = $periods->filter(function($period) {
            return $period->status_period === 'selesai';
        });
        
        return view('dashboard', compact('periods', 'activePeriods', 'completedPeriods', 'hiddenPeriods'));
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

        return redirect()->route('dashboard')->with('success', 'Periode berhasil ditambahkan!');
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

        return redirect()->route('dashboard')->with('success', 'Periode berhasil diperbarui!');
    }

    // Hapus periode (soft delete)
    public function destroy(Period $period): RedirectResponse
    {
        $period->delete(); // Soft delete
        return redirect()->route('dashboard')->with('success', 'Periode berhasil disembunyikan!');
    }
    
    // Sembunyikan periode (alias untuk destroy)
    public function hide(Period $period): RedirectResponse
    {
        return $this->destroy($period);
    }

    // Tampilkan kembali periode yang disembunyikan
    public function restore($id): RedirectResponse
    {
        $period = Period::withTrashed()->findOrFail($id);
        $period->restore();
        return redirect()->route('dashboard')->with('success', 'Periode berhasil ditampilkan kembali!');
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

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $status = $request->status;
            
            if ($status === 'terlambat') {
                // Filter overdue periods
                $query->where('tanggal_akhir', '<', now());
            } elseif ($status === 'selesai') {
                // Filter completed periods
                $query->where('status', 'completed');
            } else {
                // Filter active periods by status logic
                $query->where('status', 'active')->where(function($q) use ($status) {
                    $now = now();
                    if ($status === 'deadline') {
                        // 0-2 months remaining
                        $q->where('tanggal_akhir', '>=', $now)
                          ->where('tanggal_akhir', '<=', $now->copy()->addMonths(2));
                    } elseif ($status === 'segera') {
                        // 2-4 months remaining  
                        $q->where('tanggal_akhir', '>', $now->copy()->addMonths(2))
                          ->where('tanggal_akhir', '<=', $now->copy()->addMonths(4));
                    } elseif ($status === 'proses') {
                        // More than 4 months remaining
                        $q->where('tanggal_akhir', '>', $now->copy()->addMonths(4));
                    }
                });
            }
        }

        if ($request->has('from') && !empty($request->from)) {
            $query->where('tanggal_awal', '>=', $request->from);
        }

        if ($request->has('to') && !empty($request->to)) {
            $query->where('tanggal_akhir', '<=', $request->to);
        }

        $periods = $query->get();

        // Sort periods by status priority
        $sortedPeriods = $periods->sortBy(function($period) {
            $now = \Carbon\Carbon::now();
            $endDate = \Carbon\Carbon::parse($period->tanggal_akhir);
            $daysLeft = $now->diffInDays($endDate, false);
            
            // Calculate months and days properly
            if ($daysLeft >= 0) {
                $monthsLeft = intdiv($daysLeft, 30);
                $remainingDays = $daysLeft % 30;
            } else {
                $monthsLeft = -intdiv(abs($daysLeft), 30);
                $remainingDays = -(abs($daysLeft) % 30);
            }

            // Determine status priority
            if ($period->status === 'completed') {
                return 5; // Selesai - last
            } elseif ($daysLeft < 0) {
                return 1; // Terlambat - first
            } elseif ($monthsLeft <= 2) {
                return 2; // Deadline - second
            } elseif ($monthsLeft <= 4) {
                return 3; // Segera - third
            } else {
                return 4; // Proses - fourth
            }
        })->values();

        // Get custom title or use default
        $customTitle = $request->input('export_title', 'Data Periode Gaji Berkala - ' . \Carbon\Carbon::now()->format('F Y'));
        
        // Clean filename (remove special characters)
        $filename = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $customTitle);
        $filename = str_replace(' ', '_', $filename) . '.xlsx';

        return Excel::download(new PeriodsExport($sortedPeriods, $customTitle), $filename);
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