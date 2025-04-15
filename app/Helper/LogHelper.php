<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('log_activity')) {
    function log_activity(string $activity, array $data = []): void
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id() ?? null,
                'activity' => $activity,
                'data' => json_encode($data),
            ]);
        } catch (\Exception $e) {
            // Untuk jaga-jaga, log ke laravel.log kalau error
            logger()->error('Gagal log aktivitas: ' . $e->getMessage());
        }
    }
}
