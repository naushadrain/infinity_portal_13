<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword(): View|RedirectResponse
    {
        return view('pages.forgot-password');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withInput()
                ->withErrors(['email' => 'No account found with this email address.']);
        }

        $existing = PasswordReset::forEmail($request->email)->latest('created_at')->first();

        if ($existing && ! $existing->canResend()) {
            return back()->withInput()
                ->withErrors(['email' => 'Please wait a moment before requesting another OTP.']);
        }

        PasswordReset::forEmail($request->email)->delete();

        $otp   = (string) random_int(100000, 999999);
        $token = Str::random(64);

        PasswordReset::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'token'      => $token,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
        ]);

        session(['reset_token' => $token]);

        Mail::to($request->email)->send(new OtpMail($otp, $user->name));

        return redirect()->route('password.verifyOtp')
            ->with('success', 'OTP sent to ' . $request->email . '. Check your inbox.');
    }

    public function showVerifyOtp(): View|RedirectResponse
    {
        if (! session('reset_token')) {
            return redirect()->route('password.request');
        }

        $record = PasswordReset::where('token', session('reset_token'))->first();

        if (! $record) {
            return redirect()->route('password.request');
        }

        return view('pages.verify-otp', [
            'email'     => $record->email,
            'expiresAt' => $record->expires_at->toIso8601String(),
            'resendAt'  => $record->created_at->addMinute()->toIso8601String(),
        ]);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        if (! session('reset_token')) {
            return redirect()->route('password.request')
                ->withErrors(['otp' => 'Session expired. Please start again.']);
        }

        $record = PasswordReset::where('token', session('reset_token'))->first();

        if (! $record) {
            return redirect()->route('password.request')
                ->withErrors(['otp' => 'Invalid session. Please start again.']);
        }

        if ($record->isExpired()) {
            $record->delete();
            session()->forget('reset_token');

            return redirect()->route('password.request')
                ->withErrors(['email' => 'OTP has expired. Please request a new one.']);
        }

        if ($request->otp !== $record->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        $record->update(['is_verified' => true]);

        return redirect()->route('password.reset');
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        if (! session('reset_token')) {
            return redirect()->route('password.request');
        }

        $record = PasswordReset::where('token', session('reset_token'))->first();

        if (! $record) {
            return redirect()->route('password.request');
        }

        if (! $record->canResend()) {
            return back()->withErrors(['otp' => 'Please wait before requesting a new OTP.']);
        }

        $user = User::where('email', $record->email)->first();

        if (! $user) {
            return redirect()->route('password.request');
        }

        $otp   = (string) random_int(100000, 999999);
        $token = Str::random(64);

        PasswordReset::forEmail($record->email)->delete();

        PasswordReset::create([
            'email'      => $record->email,
            'otp'        => $otp,
            'token'      => $token,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
        ]);

        session(['reset_token' => $token]);

        Mail::to($record->email)->send(new OtpMail($otp, $user->name));

        return redirect()->route('password.verifyOtp')
            ->with('success', 'New OTP sent to your email.');
    }

    public function showResetPassword(): View|RedirectResponse
    {
        if (! session('reset_token')) {
            return redirect()->route('password.request');
        }

        $record = PasswordReset::where('token', session('reset_token'))
            ->where('is_verified', true)
            ->first();

        if (! $record) {
            return redirect()->route('password.request');
        }

        return view('pages.reset-password');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        if (! session('reset_token')) {
            return redirect()->route('password.request');
        }

        $record = PasswordReset::where('token', session('reset_token'))
            ->where('is_verified', true)
            ->first();

        if (! $record) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $record->email)->first();

        if (! $user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User not found.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        $record->delete();
        session()->forget('reset_token');

        return redirect()->route('login')
            ->with('success', 'Password updated successfully. Please sign in.');
    }
}
