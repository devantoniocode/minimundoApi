<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\JWTHelper;
use App\Responses\Responses;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTHelper::gerarToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Usuário criado com sucesso',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => env('JWT_EXPIRATION', 60) * 60
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            Responses::alert("Credenciais inválidas");
        }

        $token = JWTHelper::gerarToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => env('JWT_EXPIRATION', 60) * 60
            ]
        ]);
    }

    public function logout(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    public function refresh(Request $request)
    {
        $token = JWTHelper::extrairToken($request);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token não fornecido'
            ], 401);
        }

        $payload = JWTHelper::validarToken($token);

        if (!$payload) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido'
            ], 401);
        }

        $user = User::find($payload['sub']);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ], 401);
        }

        $newToken = JWTHelper::gerarToken($user);

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $newToken,
                'token_type' => 'Bearer',
                'expires_in' => env('JWT_EXPIRATION', 60) * 60
            ]
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $request->auth_user
            ]
        ]);
    }
}
