<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Configuracion de perfil') }}</flux:heading>

    <x-settings.layout :heading="__('Configuracion de perfil')" :subheading="__('Administra tu perfil y la información de tu cuenta')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Nombre o alias')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="codigo" :label="__('Codigo')" type="text" required autocomplete="codigo" disabled />
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">{{ __('Guardar') }}</flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
