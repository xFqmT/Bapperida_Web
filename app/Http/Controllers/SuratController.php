<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Exports\SuratsExport;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        // Get hidden surats (soft deleted) - optimized
        $hiddenSurats = Surat::onlyTrashed()
            ->select(['id', 'nomor_surat', 'judul', 'pengirim', 'tanggal_surat', 'deleted_at'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'hidden_page');

        // Get active surats with filters - optimized
        $activeQuery = Surat::query()
            ->select(['id', 'nomor_surat', 'judul', 'pengirim', 'tanggal_surat', 'status', 'disposisi', 
                     'tanggal_kasubbang', 'tanggal_sekretaris', 'tanggal_kepala', 'tanggal_selesai', 'tanggal_distribusi'])
            ->orderBy('tanggal_surat', 'desc');

        // Filter by search (judul, nomor_surat, pengirim)
        if ($request->has('q') && !empty($request->q)) {
            $activeQuery->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                  ->orWhere('nomor_surat', 'like', '%' . $request->q . '%')
                  ->orWhere('pengirim', 'like', '%' . $request->q . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $activeQuery->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from') && !empty($request->from)) {
            $activeQuery->where('tanggal_surat', '>=', $request->from);
        }

        if ($request->has('to') && !empty($request->to)) {
            $activeQuery->where('tanggal_surat', '<=', $request->to);
        }

        // Handle pagination parameters
        if ($request->has('active_page')) {
            $activeSurats = $activeQuery->paginate(15, ['*'], 'active_page', $request->get('active_page'));
        } else {
            $activeSurats = $activeQuery->paginate(15, ['*'], 'active_page');
        }

        if ($request->has('hidden_page')) {
            $hiddenSurats = Surat::onlyTrashed()
                ->select(['id', 'nomor_surat', 'judul', 'pengirim', 'tanggal_surat', 'deleted_at'])
                ->orderBy('deleted_at', 'desc')
                ->paginate(10, ['*'], 'hidden_page', $request->get('hidden_page'));
        }

        return view('surats.index', compact('activeSurats', 'hiddenSurats'));
    }

    public function create()
    {
        return view('surats.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat',
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
        ]);

        Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'judul' => $request->judul,
            'pengirim' => $request->pengirim,
            'tanggal_surat' => $request->tanggal_surat,
            'status' => 'kasubbang_umum',
            'tanggal_kasubbang' => now(),
        ]);

        return redirect()->route('surats.index')->with('success', 'Surat berhasil ditambahkan!');
    }

    public function edit(Surat $surat)
    {
        return view('surats.edit', compact('surat'));
    }

    public function update(Request $request, Surat $surat): RedirectResponse
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,' . $surat->id,
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'disposisi' => 'nullable|string',
        ]);

        if ($request->has('disposisi') && $surat->status !== 'distribusi') {
            return redirect()->route('surats.index')->with('error', 'Disposisi hanya dapat diupdate ketika status surat adalah distribusi!');
        }

        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'judul' => $request->judul,
            'pengirim' => $request->pengirim,
            'tanggal_surat' => $request->tanggal_surat,
            'disposisi' => $request->disposisi,
        ]);

        return redirect()->route('surats.index')->with('success', 'Surat berhasil diperbarui!');
    }

    public function destroy(Surat $surat): RedirectResponse
    {
        $surat->delete();
        return redirect()->route('surats.index')->with('success', 'Surat berhasil disembunyikan!');
    }

    public function restore($id): RedirectResponse
    {
        $surat = Surat::withTrashed()->findOrFail($id);
        $surat->restore();
        return redirect()->route('surats.index')->with('success', 'Surat berhasil ditampilkan kembali!');
    }

    // Move to next status
    public function moveStatus(Surat $surat): RedirectResponse
    {
        try {
            if ($surat->can_move_to_next) {
                $nextStatus = $surat->next_status;
                $dateField = 'tanggal_' . $nextStatus;
                
                $surat->update([
                    'status' => $nextStatus,
                    $dateField => now(),
                ]);
                
                // Clear all cache for this surat
                $statuses = array_keys(Surat::$statusList);
                foreach ($statuses as $status) {
                    cache()->forget("surat_workflow_{$surat->id}_{$status}");
                }
                
                return redirect()->route('surats.index')->with('success', 'Surat berhasil dipindahkan ke ' . Surat::$statusList[$nextStatus] . '!');
            }

            return redirect()->route('surats.index')->with('error', 'Surat sudah mencapai status akhir!');
        } catch (\Exception $e) {
            return redirect()->route('surats.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Export Excel
    public function export(Request $request)
    {
        $query = Surat::query()->orderBy('tanggal_surat', 'desc');

        // Apply same filters as index
        if ($request->has('q') && !empty($request->q)) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                  ->orWhere('nomor_surat', 'like', '%' . $request->q . '%')
                  ->orWhere('pengirim', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('from') && !empty($request->from)) {
            $query->where('tanggal_surat', '>=', $request->from);
        }

        if ($request->has('to') && !empty($request->to)) {
            $query->where('tanggal_surat', '<=', $request->to);
        }

        $surats = $query->get();

        // Generate custom title based on filters
        $title = 'Data Surat';
        $filters = [];
        
        if ($request->input('q')) $filters[] = 'Pencarian: ' . $request->input('q');
        if ($request->input('status')) {
            $statusLabel = Surat::$statusList[$request->input('status')] ?? $request->input('status');
            $filters[] = 'Status: ' . $statusLabel;
        }
        if ($request->input('from')) $filters[] = 'Dari: ' . $request->input('from');
        if ($request->input('to')) $filters[] = 'Sampai: ' . $request->input('to');
        
        if (!empty($filters)) {
            $title .= ' (' . implode(', ', $filters) . ')';
        }

        $export = new SuratsExport($surats, $title);
        return Excel::download($export, 'data_surat_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
