<?php

namespace App\Support;

use App\Models\DailyProgress;
use App\Models\Documentation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageDuplicateChecker
{
    /** Return true when the same image content is already saved for this user. */
    public static function exists(UploadedFile $file, ?string $excludeType = null, ?int $excludeId = null): bool
    {
        $hash = hash_file('sha256', $file->getRealPath());
        $disk = Storage::disk('public');

        $records = collect();
        Documentation::where('user_id', Auth::id())->get(['id', 'image_path'])->each(function ($row) use ($records) {
            $records->push(['type' => 'documentation', 'id' => $row->id, 'path' => $row->image_path]);
        });
        DailyProgress::where('user_id', Auth::id())->whereNotNull('screenshot_path')->get(['id', 'screenshot_path'])->each(function ($row) use ($records) {
            $records->push(['type' => 'daily', 'id' => $row->id, 'path' => $row->screenshot_path]);
        });

        foreach ($records as $record) {
            if ($excludeType === $record['type'] && $excludeId === (int) $record['id']) {
                continue;
            }
            if ($record['path'] && $disk->exists($record['path'])) {
                $existingPath = $disk->path($record['path']);
                if (is_file($existingPath) && hash_file('sha256', $existingPath) === $hash) {
                    return true;
                }
            }
        }
        return false;
    }
}
