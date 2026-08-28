<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Aktivitas Terbaru
        </x-slot>

        <div class="space-y-4">
            @forelse ($this->getActivities() as $activity)

                <div class="flex items-start gap-3">

                    <div class="flex-1">
                        <div class="font-medium">
                            {{ $activity->causer?->name ?? 'System' }}
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $activity->description }}
                        </div>

                        <div class="text-xs text-gray-400">
                            {{ $activity->created_at?->diffForHumans() }}
                        </div>
                    </div>

                </div>

            @empty

                <div class="text-sm text-gray-500">
                    Belum ada aktivitas.
                </div>

            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>