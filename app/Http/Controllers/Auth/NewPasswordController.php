<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Auth\StatefulGuard;

class NewPasswordController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the new password view.
     */
    public function create(Request $request): Responsable
    {
        return app(\Laravel\Fortify\Contracts\ResetPasswordViewResponse::class);
    }

    /**
     * Reset the user's password.
     */
    public function store(Request $request): Responsable
    {
        $request->validate([
            'token' => 'required',
            'codigo' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        $status = $this->broker()->reset(
            $request->only('codigo', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                app(\Laravel\Fortify\Contracts\ResetsUserPasswords::class)->reset($user, ['password' => $password]);
                app(\Laravel\Fortify\Actions\CompletePasswordReset::class)($this->guard, $user);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? app(\Laravel\Fortify\Contracts\PasswordResetResponse::class, ['status' => $status])
            : app(\Laravel\Fortify\Contracts\FailedPasswordResetResponse::class, ['status' => $status]);
    }

    /**
     * Get the broker to be used during password reset.
     */
    protected function broker()
    {
        return Password::broker(config('fortify.passwords'));
    }
}
