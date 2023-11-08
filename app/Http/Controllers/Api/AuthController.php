<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginAuthenticate(Request $request) 
    {
        $validateData = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        
        if (Auth::attempt($validateData)) {
            $user = User::firstWhere('username', $validateData['username']);
            return new ApiResource(true, 'Berhasil Login', $user);
        }
        return new ApiResource(false, 'Gagal Login', []);
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return new ApiResource(true, 'Berhasil Logout', []);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function registerStore(Request $request)
    {
        try{
            $validateData = $request->validate([
                'name' => ['required', 'max:255'],
                'username' => ['required', 'unique:users'],
                'password' => ['required', 'min:5', 'max:255'],
            ]);

            $validateData['password'] = Hash::make($validateData['password']);
            $user = User::create($validateData);

            return new ApiResource(true, 'Data Berhasil Disimpan', $user);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
