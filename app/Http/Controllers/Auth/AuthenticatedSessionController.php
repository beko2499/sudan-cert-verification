<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();
    $user = Auth::user();
    // إذا كان Admin → لوحة إدارة
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    // إذا كان مدير جامعة → لوحة الجامعة
    if ($user->hasRole('university_admin')) {
        return redirect()->route('university.dashboard');
    }

    // مستخدم عادي (لو وجد لاحقًا)
    return redirect('/');
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
