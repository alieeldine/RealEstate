<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

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

        $id = Auth::user()->id;
        $loginData = User::find($id);
        $username = $loginData->name;

        $request->session()->regenerate();

        $notification = array(
            'message' => 'User '.$username.' Login Successfully',
            'alert-type' => 'info'
        );

        $url='';
        if ($request->user()->role === 'admin') {
            $url = "admin/dashboard";
        } elseif ($request->user()->role === 'agent') {
            $url = "agent/dashboard";
        }  elseif ($request->user()->role === 'user') {
            $url = "/dashboard";
        }

        return redirect()->intended($url)->with($notification);
        //return redirect()->intended(RouteServiceProvider::HOME);
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