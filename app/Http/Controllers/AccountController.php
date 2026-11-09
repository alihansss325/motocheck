<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return response()->view('account', [
            'diagnoses' => $user->diagnoses()->latest()->limit(20)->get(),
        ])->header('Cache-Control', 'private, no-store');
    }
}
