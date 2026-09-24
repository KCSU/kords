<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $checks = [
            'database' => function () {
                DB::table('rooms')->exists();

                return true;
            },
        ];

        $result = [];
        foreach ($checks as $name => $check) {
            try {
                $ok = $check();
            } catch (Throwable $e) {
                Log::warning("Health check {$name} failed: {$e->getMessage()}");
                $ok = false;
            }
            $result[$name] = $ok ? 'ok' : 'error';
        }

        $healthy = ! in_array('error', $result, true);

        return response()->json(['status' => $healthy ? 'ok' : 'error'] + $result, $healthy ? 200 : 503);
    }
}
