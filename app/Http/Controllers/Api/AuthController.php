<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mendaftarkan pengguna baru (Customer atau Admin).
     */
    public function register(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'sometimes|in:admin,customer' // Role bersifat opsional, defaultnya 'customer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer', // Jika role tidak ada, set sebagai 'customer'
        ]);

        // Membuat token JWT untuk user yang baru terdaftar menggunakan guard 'api'
        $token = auth('api')->login($user);

        // Mengembalikan response dengan token
        return $this->respondWithToken($token);
    }

    /**
     * Melakukan login untuk pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mencoba untuk mengautentikasi dan membuat token menggunakan guard 'api'
        $credentials = $request->only('email', 'password');
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Mendapatkan data pengguna yang sedang terautentikasi.
     */
    public function me()
    {
        // Menggunakan guard 'api' untuk mendapatkan user
        return response()->json(auth('api')->user());
    }

    /**
     * Melakukan logout (invalidate token).
     */
    public function logout()
    {
        // Menggunakan guard 'api' untuk logout
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Helper function untuk format response token.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // Menggunakan guard 'api' untuk mendapatkan TTL
            'expires_in' => auth('api')->factory()->getTTL() * 60, // 60 menit * 60 = 3600 detik ( JWT Expired )
            'user' => auth('api')->user()
        ]);
    }
}
