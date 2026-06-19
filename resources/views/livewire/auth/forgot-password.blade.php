<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Forgot password')" :description="__('Enter your code to generate a password reset link')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        @if (session('password_reset_link'))
            <div class="rounded-lg border border-emerald-300 bg-emerald-50 p-4 text-sm text-emerald-900">
                <p class="font-semibold">{{ __('Your password reset link:') }}</p>
                <p class="break-all">{{ session('password_reset_link') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Code -->
            <flux:input
                name="codigo"
                :label="__('Code')"
                type="text"
                required
                autofocus
                placeholder="123456"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="codigo-password-reset-link-button">
                {{ __('codigo password reset link') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Or, return to') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
