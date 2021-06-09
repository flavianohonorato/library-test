<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(title="Library", version="0.1")
 */
class HealthCheckController extends Controller
{
    public function __invoke()
    {
        $database = $this->checkDatabase();

        return response([
            'app_name' => config('app.name'),
            'database' => $database,
        ]);
    }

    private function checkDatabase()
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            $message = 'Could not connect to the database. Please check your configuration.';
            $debug = config('app.debug');

            if ($debug) {
                $message .= ' Error: ' . $e->getMessage();
            }

            $config = config()->get('database.connections' . config('database.default'));

            unset($config['password']);

            Log::error("{$message}:  {$e->getMessage()}", $config);

            return [
                "message" => $message,
                "config" => $debug ? $config : null,
            ];
        }
    }
}
