<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\JWTHelper;
use App\Models\User;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Extrair token do header
        $token = JWTHelper::extrairToken($request);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token não fornecido'
            ], 401);
        }
        
        // Validar token
        $payload = JWTHelper::validarToken($token);
        
        if (!$payload) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido ou expirado'
            ], 401);
        }
        
        // Buscar usuário (opcional - você pode usar apenas os dados do payload)
        $user = User::query()->find($payload['sub']);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ], 401);
        }
        
        // Adicionar usuário à requisição
        $request->merge(['auth_user' => $user]);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        
        return $next($request);
    }
}