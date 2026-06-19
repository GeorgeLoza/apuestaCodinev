<?php

namespace App\Http\Controllers\Auth;

use App\Concerns\PasswordValidationRules;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Responsable;

class PasswordResetLinkController extends Controller
{
    use PasswordValidationRules;

    /**
     * Show the reset password link request view.
     */
    public function create(Request $request): Responsable
    {
        return app(\Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse::class);
    }

    /**
     * Send a reset link to the given user.
     */
    public function store(Request $request): Responsable
    {
        $request->validate([
            'codigo' => ['required', 'string'],
        ]);

        if (config('fortify.lowercase_usernames') && $request->has('codigo')) {
            $request->merge([
                'codigo' => Str::lower($request->codigo),
            ]);
        }

        $resetLink = null;

        $status = $this->broker()->sendResetLink(
            $request->only('codigo'),
            function ($user, $token) use (&$resetLink) {
                $resetLink = url(route('password.reset', [
                    'token' => $token,
                    'email' => $user->getEmailForPasswordReset(),
                ], false));
            }
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with([
                'status' => __($status),
                'password_reset_link' => $resetLink,
            ]);
        }

        return back()->withErrors(['codigo' => __($status)]);
    }

    /**
     * Get the broker to be used during password reset.
     */
    protected function broker()
    {
        return Password::broker(config('fortify.passwords'));
    }
}
