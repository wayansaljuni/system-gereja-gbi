<x-filament-panels::page>
    <div class="flex items-center justify-center py-8">
        <div class="w-full max-w-lg">
            <x-filament::section icon="heroicon-o-lock-closed">
                <x-slot name="heading">
                    Change Your Password
                </x-slot>

                <x-slot name="description">
                    For security reasons, you need to set a new password before continuing.
                </x-slot>

                <form wire:submit="submit" class="space-y-6">
                    {{ $this->form }}

                    <div class="flex justify-end">
                        <x-filament::button
                            type="submit"
                            icon="heroicon-o-check-circle"
                            size="lg"
                        >
                            Update Password
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>