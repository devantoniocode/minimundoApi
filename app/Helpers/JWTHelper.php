<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTHelper
{
    /**
     * Gerar token JWT para o usuário
     */
    public static function gerarToken($user)
    {
        $secretKey = env('JWT_SECRET');
        $expiration = env('JWT_EXPIRATION', 60);
        
        $payload = [
            'iss' => 'mini-mundo',            // Emissor
            'sub' => $user->id,          // Subject (ID do usuário)
            'iat' => time(),                 // Issued at (emitido em)
            'exp' => time() + ($expiration * 60), // Expiração
            'jti' => uniqid(),               // JWT ID único (para revogação)
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'nome' => $user->name
            ]
        ];
        
        return JWT::encode($payload, $secretKey, 'HS256');
    }
    
    /**
     * Validar e decodificar token
     */
    public static function validarToken($token)
    {
        try {
            $secretKey = env('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Extrair token do header Authorization
     */
    public static function extrairToken($request)
    {
        $header = $request->header('Authorization');
        
        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return null;
        }
        
        return substr($header, 7); // Remove "Bearer " do início
    }
}