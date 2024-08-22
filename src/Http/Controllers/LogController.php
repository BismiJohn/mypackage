<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function getAlerts()
    {
        $logFile = storage_path('logs/laravel.log');
        $alerts = [];

        if (File::exists($logFile)) {
            $logContents = File::get($logFile);
            preg_match_all('/Alert message set: (.+)/', $logContents, $matches);

            if (isset($matches[1])) {
                $alerts = array_reverse($matches[1]); // Reverse to show latest first
            }
        }

        return response()->json($alerts);
    }
}
