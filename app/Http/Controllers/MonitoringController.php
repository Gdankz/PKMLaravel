<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class MonitoringController extends Controller
{
    protected $database;

    public function __construct()
    {
        $firebaseCredentialsPath = storage_path('storage/app/sipair-pkm2024-default-rtdb-export.json');

        if (!file_exists($firebaseCredentialsPath)) {
            Log::error('Firebase credentials file not found.');
        } else {
            Log::info('Firebase credentials file found.');
            $firebase = (new Factory)->withServiceAccount($firebaseCredentialsPath);
            $this->database = $firebase->createDatabase();
        }
    }

    public function index()
    {
        $data = $this->database->getReference('Realtime/135035')->getValue();
        return view('monitoring', ['data' => $data]);
    }
}
