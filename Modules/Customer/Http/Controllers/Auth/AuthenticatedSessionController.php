<?php

namespace Modules\Customer\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Customer\Http\Requests\Auth\LoginRequest;
use Nwidart\Modules\Facades\Module;

class AuthenticatedSessionController extends Controller {
    /**
     * Display the login view.
     */
    public function create(): View {
        return view('customer::public.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse {
        $oldSession = session()->getId();
        $request->authenticate();

        if (Module::has('Cart') && Module::isEnabled('Cart')) {
            \Modules\Cart\Http\Controllers\CartController::storeOrUpdate(oldSession: $oldSession);
        }

        $request->session()->regenerate();

        return redirect()->intended($request->has('url_return') ?: RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse {
        auth('web')->logout();

        $request->session()->regenerate();
        // $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME);
    }
}
