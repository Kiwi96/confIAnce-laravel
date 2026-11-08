<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    // Paso 1: el usuario pide el enlace
    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        Password::sendResetLink($request->only('email'));

        // Siempre la misma respuesta, exista o no el correo (por seguridad)
        return response()->json([
            'mensaje' => 'Si el correo existe, te enviamos un enlace de recuperación.',
        ]);
    }

    // Paso 2: el usuario manda la nueva contraseña
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
        ]);

        $estado = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Cierra las sesiones abiertas con la contraseña vieja
                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($estado !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => ['El enlace es inválido o ya venció. Pide uno nuevo.'],
            ]);
        }

        return response()->json(['mensaje' => 'Contraseña actualizada correctamente.']);
    }
}