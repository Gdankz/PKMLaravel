<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $firebaseBaseUrl = 'https://dummytes-sipair-default-rtdb.asia-southeast1.firebasedatabase.app';

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'noRekamMedis' => 'required|string|unique:users',
        ]);

        $userData = [
            'nama' => $request->nama,
            'noRekamMedis' => $request->noRekamMedis,
        ];

        $response = Http::put("{$this->firebaseBaseUrl}/No_RM/{$request->noRekamMedis}.json", $userData);

        if ($response->successful()) {
            // Create a new user instance for Laravel Auth
            $user = new \App\Models\User();
            $user->nama = $request->nama;
            $user->noRekamMedis = $request->noRekamMedis;
            $user->save();

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'Error registering user.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'noRekamMedis' => 'required|string',
        ]);

        $response = Http::get("{$this->firebaseBaseUrl}/No_RM/{$request->noRekamMedis}.json");

        if ($response->successful() && $response->json()) {
            $userData = $response->json();

            // Check if the user already exists in the local database
            $user = \App\Models\User::where('noRekamMedis', $request->noRekamMedis)->first();

            if (!$user) {
                // If not, create a new user instance for Laravel Auth
                $user = new \App\Models\User();
                $user->nama = $userData['nama'];
                $user->noRekamMedis = $userData['noRekamMedis'];
                $user->save();
            }

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'No Rekam Medis tidak ditemukan.');
        }
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('dashboard', ['nama' => $user->nama, 'noRekamMedis' => $user->noRekamMedis]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
