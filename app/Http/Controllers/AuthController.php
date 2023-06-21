<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //////////////////////////////////////////////////////
    // General Functionality
    //////////////////////////////////////////////////////

    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->withJson([
                'message' => __('auth.invalid_credentials'),
                'status'  => 401,
            ]);
        }

        if (! $user->approved_at) {
            return response()->withJson([
                'message' => __('auth.pending'),
                'status'  => 400,
            ]);
        }

        return response()->withJson([
            'data' => [
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ],
        ]);
    }

    /**
     * Handle a user registration.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ]);

        User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->withJson([
            'message' => __('auth.pending'),
        ]);
    }
}
