<?php

namespace WpPluginner\Illuminate\Session\Middleware;

use Closure;
use WpPluginner\Illuminate\Auth\AuthenticationException;
use WpPluginner\Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthenticateSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \WpPluginner\Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \WpPluginner\Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user() || ! $request->session()) {
            return $next($request);
        }

        if (! $request->session()->has('password_hash') && $this->auth->viaRemember()) {
            $this->logout($request);
        }

        if (! $request->session()->has('password_hash')) {
            $this->storePasswordHashInSession($request);
        }

        if ($request->session()->get('password_hash') !== $request->user()->getAuthPassword()) {
            $this->logout($request);
        }

        return wp_pluginner_tap($next($request), function () use ($request) {
            $this->storePasswordHashInSession($request);
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        if (! $request->user()) {
            return;
        }

        $request->session()->put([
            'password_hash' => $request->user()->getAuthPassword(),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \WpPluginner\Illuminate\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->auth->logout();

        $request->session()->flush();

        throw new AuthenticationException;
    }
}
