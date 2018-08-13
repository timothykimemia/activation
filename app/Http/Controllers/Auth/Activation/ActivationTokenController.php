<?php

namespace App\Http\Controllers\Auth\Activation;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Activation\ActivationToken;
use App\Events\Activation\RequestActivationToken;

class ActivationTokenController extends Controller
{
    /**
     * @param ActivationToken $token
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function activate(ActivationToken $token)
    {
        $token->user()->update([ 'active' => true ]);

        $this->guard()->login($token->user);

        $token->delete();

        return redirect()->route('user.index')->with('success', "Email verified. Thank you.");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        $user = User::byEmail($request->email);

        if ($user->active):
            return redirect()->route('login')->with('info', "Already verified.");
        endif;

        event(new RequestActivationToken($user));

        return redirect()->route('login')->with('info', "Verification email resent. (Please Check spam!!).");
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
