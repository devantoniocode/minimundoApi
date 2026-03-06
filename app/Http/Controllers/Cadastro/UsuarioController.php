<?php

namespace App\Http\Controllers\Cadastro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    static function userVue($user)
    {
        $name = explode(" ", Str::title($user->name));
        $name = $name[0] . " " . @$name[count($name) - 1];

        return [
            "id" => Auth::id(),
            "name" => $name,
            "email" => $user->email,
            "username" => $user->username,
        ];
    }
}
