<?php
namespace App\Logging;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Handler\AbstractProcessingHandler;

class ActivityLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('activitylog');
        $logger->pushHandler(new class extends AbstractProcessingHandler {
            protected function write(LogRecord $record): void
            {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => $record->message,
                    'data' => json_encode($record->context),
                ]);
            }
        });

        return $logger;
    }
}

