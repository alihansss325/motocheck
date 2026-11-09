<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AccountSettingsController extends Controller
{
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validateWithBag('profile', [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }

        $user->fill($validated)->save();

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('password', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:10', 'confirmed'],
        ]);

        $request->user()->update(['password' => $validated['password']]);
        $request->session()->regenerate();

        return back()->with('status', 'Kata sandi berhasil diganti.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('deleteAccount', [
            'current_password' => ['required', 'current_password'],
            'confirm_delete' => ['accepted'],
        ]);

        $user = $request->user();
        $userId = $user->getKey();

        DB::transaction(function () use ($user, $userId): void {
            $user->diagnoses()->delete();
            DB::table('users')->where('id', $userId)->delete();
        });

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Akun dan riwayat diagnosa Anda telah dihapus.');
    }
}
