<?php

use App\Enums\UserRole;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

        $user = Auth::user();

        switch ($user->role) {
            case UserRole::Administrator:
                $this->redirect(route('admin.dashboard'), navigate: true);
                break;
            case UserRole::Controller:
                $this->redirect(route('controller.dashboard'), navigate: true);
                break;
            case UserRole::Technician:
                $this->redirect(route('technician.dashboard'), navigate: true);
                break;
            case UserRole::ReportingUser:
                $this->redirect(route('reporting-user.dashboard'), navigate: true);
                break;
            default:
                $this->redirect(route('user.dashboard'), navigate: true);
                break;
        }
    }
}; ?>

<div class="text-white">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full text-white bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full text-white bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded bg-gray-800 border-gray-600 text-indigo-500 shadow-sm focus:ring-indigo-400" name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-700 text-white">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
