<?php

namespace App\Http\Controllers;

use App\Models\MeetingSlide;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function manage(): View
    {
        $slides = MeetingSlide::withTrashed()->orderBy('order')->get();
        $deletedCount = MeetingSlide::onlyTrashed()->count();
        $nextOrder = $this->getNextAvailableOrder();
        return view('slides.manage', compact('slides', 'deletedCount', 'nextOrder'));
    }

    private function getNextAvailableOrder(): int
    {
        // Get all orders (including deleted)
        $allOrders = MeetingSlide::withTrashed()->pluck('order')->toArray();
        
        if (empty($allOrders)) {
            return 1;
        }
        
        // Find the first missing order number
        sort($allOrders);
        for ($i = 1; $i <= max($allOrders) + 1; $i++) {
            if (!in_array($i, $allOrders)) {
                return $i;
            }
        }
        
        return max($allOrders) + 1;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
            'cropped_image' => 'nullable|string',
        ]);

        // Handle cropped image or regular image
        if (!empty($data['cropped_image'])) {
            $data['image_path'] = $this->storeBase64Image($data['cropped_image']);
        } else {
            $data['image_path'] = $request->file('image')->store('meetings', 'public');
        }

        // Use provided order or get next available
        $order = $data['order'] ?? $this->getNextAvailableOrder();
        $data['order'] = $order;
        $data['is_active'] = true;

        // Auto-shift existing slides if order already exists
        MeetingSlide::where('order', '>=', $order)->increment('order');

        unset($data['image']);
        unset($data['cropped_image']);

        MeetingSlide::create($data);
        
        // Return JSON for AJAX requests, redirect for regular requests
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Slide ditambahkan'], 200);
        }
        
        return redirect()->route('slides.manage')->with('success', 'Slide ditambahkan');
    }

    private function storeBase64Image(string $dataUrl, ?string $oldImagePath = null): string
    {
        if (!str_starts_with($dataUrl, 'data:image/')) {
            throw new \InvalidArgumentException('Invalid image data');
        }
        [$meta, $content] = explode(',', $dataUrl, 2);
        $ext = 'png';
        if (str_contains($meta, 'image/jpeg') || str_contains($meta, 'image/jpg')) $ext = 'jpg';
        elseif (str_contains($meta, 'image/webp')) $ext = 'webp';
        $binary = base64_decode($content);
        
        // If old image exists, use same filename; otherwise create new
        if ($oldImagePath) {
            $filename = $oldImagePath;
            // Delete old file first
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        } else {
            $filename = 'meetings/'.uniqid('slide_', true).'.'.$ext;
        }
        
        Storage::disk('public')->put($filename, $binary);
        return $filename;
    }

    public function toggleActive(MeetingSlide $slide): RedirectResponse
    {
        $slide->update(['is_active' => !$slide->is_active]);
        return redirect()->route('slides.manage')->with('success', 'Status slide diperbarui');
    }

    public function update(Request $request, MeetingSlide $slide)
    {
        $data = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'caption' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'cropped_image' => 'nullable|string',
        ]);

        // Handle order change with auto-shift
        $newOrder = $data['order'];
        $oldOrder = $slide->order;

        if ($newOrder !== $oldOrder) {
            if ($newOrder > $oldOrder) {
                // Shifting down: decrement orders between old and new
                MeetingSlide::where('order', '>', $oldOrder)
                    ->where('order', '<=', $newOrder)
                    ->decrement('order');
            } else {
                // Shifting up: increment orders between new and old
                MeetingSlide::where('order', '>=', $newOrder)
                    ->where('order', '<', $oldOrder)
                    ->increment('order');
            }
        }

        // Handle cropped image first (takes priority)
        if (!empty($data['cropped_image'])) {
            $data['image_path'] = $this->storeBase64Image($data['cropped_image'], $slide->image_path);
        } 
        // Then handle regular file upload
        elseif ($request->hasFile('image')) {
            // Delete old image
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            // Store new image
            $data['image_path'] = $request->file('image')->store('meetings', 'public');
        }
        
        // Remove image fields from data array since they're handled separately
        unset($data['image']);
        unset($data['cropped_image']);

        $slide->update($data);
        
        // Return JSON for AJAX requests, redirect for regular requests
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Slide diperbarui'], 200);
        }
        
        return redirect()->route('slides.manage')->with('success', 'Slide diperbarui');
    }

    public function destroy(MeetingSlide $slide): RedirectResponse
    {
        $slide->delete();
        return redirect()->route('slides.manage')->with('success', 'Slide dihapus');
    }

    public function restore($id): RedirectResponse
    {
        $slide = MeetingSlide::withTrashed()->findOrFail($id);
        $restoredOrder = $slide->order;

        // Check if order already exists in active slides
        $existingSlide = MeetingSlide::where('order', $restoredOrder)->whereNull('deleted_at')->first();
        
        if ($existingSlide) {
            // Auto-shift existing slides to make room for the restored slide
            MeetingSlide::where('order', '>=', $restoredOrder)
                ->whereNull('deleted_at')
                ->increment('order');
        }

        $slide->restore();
        return redirect()->route('slides.manage')->with('success', 'Slide dipulihkan');
    }
}
