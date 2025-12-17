<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingSlide;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::query()->orderBy('date')->orderBy('start_time');

        // Auto-adjust statuses relative to current time
        $nowDate = now()->toDateString();
        $nowTime = now()->format('H:i:s');

        // Mark ongoing when now is between start and end on the same date
        Meeting::whereDate('date', $nowDate)
            ->where('start_time', '<=', $nowTime)
            ->whereRaw('COALESCE(end_time, start_time) > ?', [$nowTime])
            ->where('status', '!=', 'ongoing')
            ->update(['status' => 'ongoing']);

        // Mark done when already finished (past date or end <= now)
        Meeting::where(function ($q) use ($nowDate, $nowTime) {
                $q->whereDate('date', '<', $nowDate)
                  ->orWhere(function ($q2) use ($nowDate, $nowTime) {
                      $q2->whereDate('date', $nowDate)
                         ->whereRaw('COALESCE(end_time, start_time) <= ?', [$nowTime]);
                  });
            })
            ->where('status', '!=', 'done')
            ->update(['status' => 'done']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('agenda', 'like', "%$search%")
                  ->orWhere('pic', 'like', "%$search%");
            });
        }
        if ($pic = $request->input('pic')) {
            $query->where('pic', 'like', "%$pic%");
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($from = $request->input('from')) {
            $query->where('date', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $query->where('date', '<=', $to);
        }

        $meetings = $query->paginate(15)->withQueryString();
        $hiddenMeetings = Meeting::onlyTrashed()->paginate(15, ['*'], 'hidden_page')->withQueryString();
        $slides = MeetingSlide::where('is_active', true)->orderBy('order')->get();

        return view('meetings.index', compact('meetings', 'hiddenMeetings', 'slides'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'agenda' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'status' => 'required|in:scheduled,ongoing,done',
            'notes' => 'nullable|string',
            'ruang_rapat' => 'nullable|in:Ibdis,LT1,LT2',
        ]);

        // Detect time overlap on the same date
        $end = $data['end_time'] ?? $data['start_time'];
        $conflict = Meeting::whereDate('date', $data['date'])
            ->where('start_time', '<', $end)
            ->whereRaw('COALESCE(end_time, start_time) > ?', [$data['start_time']])
            ->first();

        if ($conflict) {
            $startText = substr($conflict->start_time, 0, 5);
            $endText = $conflict->end_time ? substr($conflict->end_time, 0, 5) : $startText;
            return back()->withErrors([
                'start_time' => "Jadwal rapat bertabrakan: sudah ada rapat pada pukul {$startText} - {$endText}. Silakan pilih waktu lain.",
            ])->withInput();
        }

        Meeting::create($data);
        return redirect()->route('meetings.index')->with('success', 'Jadwal rapat berhasil ditambahkan');
    }

    public function edit(Meeting $meeting)
    {
        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting): RedirectResponse
    {
        $data = $request->validate([
            'agenda' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'notes' => 'nullable|string',
            'ruang_rapat' => 'nullable|in:Ibdis,LT1,LT2',
        ]);

        // Detect time overlap on the same date (exclude current meeting)
        $end = $data['end_time'] ?? $data['start_time'];
        $conflict = Meeting::whereDate('date', $data['date'])
            ->where('id', '!=', $meeting->id)
            ->where('start_time', '<', $end)
            ->whereRaw('COALESCE(end_time, start_time) > ?', [$data['start_time']])
            ->first();

        if ($conflict) {
            $startText = substr($conflict->start_time, 0, 5);
            $endText = $conflict->end_time ? substr($conflict->end_time, 0, 5) : $startText;
            return back()->withErrors([
                'start_time' => "Jadwal rapat bertabrakan: sudah ada rapat pada pukul {$startText} - {$endText}. Silakan pilih waktu lain.",
            ])->withInput();
        }

        $meeting->update($data);
        return redirect()->route('meetings.index')->with('success', 'Jadwal rapat diperbarui');
    }

    public function destroy(Meeting $meeting): RedirectResponse
    {
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'Jadwal rapat dihapus');
    }

    // Export Excel
    public function export(Request $request)
    {
        $query = Meeting::query()->orderBy('date')->orderBy('start_time');

        // Apply same filters as index
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('agenda', 'like', "%$search%")
                  ->orWhere('pic', 'like', "%$search%");
            });
        }
        if ($pic = $request->input('pic')) {
            $query->where('pic', 'like', "%$pic%");
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($from = $request->input('from')) {
            $query->where('date', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $query->where('date', '<=', $to);
        }

        $meetings = $query->get();

        // Generate custom title based on filters
        $title = 'Data Jadwal Rapat';
        $filters = [];
        
        if ($request->input('q')) $filters[] = 'Pencarian: ' . $request->input('q');
        if ($request->input('pic')) $filters[] = 'PIC: ' . $request->input('pic');
        if ($request->input('status')) {
            $statusLabel = match($request->input('status')) {
                'scheduled' => 'Terjadwal',
                'ongoing' => 'Berlangsung',
                'done' => 'Selesai',
                default => $request->input('status')
            };
            $filters[] = 'Status: ' . $statusLabel;
        }
        if ($request->input('from')) $filters[] = 'Dari: ' . $request->input('from');
        if ($request->input('to')) $filters[] = 'Sampai: ' . $request->input('to');
        
        if (!empty($filters)) {
            $title .= ' (' . implode(', ', $filters) . ')';
        }

        $export = new \App\Exports\MeetingsExport($meetings, $title);
        return \Excel::download($export, 'jadwal_rapat_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function restore($id): RedirectResponse
    {
        $meeting = Meeting::withTrashed()->findOrFail($id);
        $meeting->restore();
        return redirect()->route('meetings.index')->with('success', 'Jadwal dipulihkan');
    }

    public function storeSlide(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'caption' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0|unique:meeting_slides,order',
            'is_active' => 'nullable|boolean',
        ]);

        $path = $request->file('image')->store('meetings', 'public');

        MeetingSlide::create([
            'image_path' => $path,
            'caption' => $data['caption'] ?? null,
            'order' => $data['order'],
            'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true,
        ]);

        return redirect()->route('meetings.index')->with('success', 'Slide ditambahkan');
    }
}
