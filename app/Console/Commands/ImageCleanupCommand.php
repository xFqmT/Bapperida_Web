<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\DashboardSlide;
use App\Models\MeetingSlide;

class ImageCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned images from storage and database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image cleanup process...');
        
        // Get all images from database
        $dashboardImages = DashboardSlide::withTrashed()->pluck('image_path')->filter();
        $meetingImages = MeetingSlide::withTrashed()->pluck('image_path')->filter();
        
        $allDbImages = $dashboardImages->merge($meetingImages)->unique();
        
        // Get all physical files in storage
        $dashboardFiles = Storage::disk('public')->allFiles('dashboard');
        $meetingFiles = Storage::disk('public')->allFiles('meetings');
        $allStorageFiles = array_merge($dashboardFiles, $meetingFiles);
        
        $this->info('Database images: ' . $allDbImages->count());
        $this->info('Storage files: ' . count($allStorageFiles));
        
        // Find orphaned files (files in storage but not in database)
        $orphanedFiles = [];
        foreach ($allStorageFiles as $file) {
            if (!$allDbImages->contains($file)) {
                $orphanedFiles[] = $file;
            }
        }
        
        $this->info('Orphaned files found: ' . count($orphanedFiles));
        
        // Show orphaned files details
        if (!empty($orphanedFiles)) {
            $this->warn('Orphaned files to be deleted:');
            foreach ($orphanedFiles as $file) {
                $size = Storage::disk('public')->size($file);
                $this->line("  - {$file} ({$this->formatBytes($size)})");
            }
            
            // Calculate total size to be freed
            $totalSize = 0;
            foreach ($orphanedFiles as $file) {
                $totalSize += Storage::disk('public')->size($file);
            }
            
            $this->warn('Total space to be freed: ' . $this->formatBytes($totalSize));
            
            // Ask for confirmation
            if ($this->confirm('Do you want to delete these orphaned files?')) {
                foreach ($orphanedFiles as $file) {
                    Storage::disk('public')->delete($file);
                    $this->info("Deleted: {$file}");
                }
                
                $this->info('Cleanup completed successfully!');
            } else {
                $this->info('Cleanup cancelled.');
            }
        } else {
            $this->info('No orphaned files found. Storage is clean!');
        }
        
        // Find missing files (records in database but files don't exist)
        $missingFiles = [];
        foreach ($allDbImages as $image) {
            if (!Storage::disk('public')->exists($image)) {
                $missingFiles[] = $image;
            }
        }
        
        if (!empty($missingFiles)) {
            $this->warn('Database records with missing files:');
            foreach ($missingFiles as $file) {
                $this->line("  - {$file}");
            }
            
            if ($this->confirm('Do you want to delete database records for missing files?')) {
                // Clean dashboard slides
                DashboardSlide::withTrashed()->whereIn('image_path', $missingFiles)->delete();
                
                // Clean meeting slides  
                MeetingSlide::withTrashed()->whereIn('image_path', $missingFiles)->delete();
                
                $this->info('Database records cleaned up!');
            }
        }
        
        return 0;
    }
    
    private function formatBytes($bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
