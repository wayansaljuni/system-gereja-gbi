<div class="space-y-5">
    {{-- Header ringkasan PR --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-linear-to-br from-primary-50 to-white dark:border-gray-700 dark:from-white/5 dark:to-transparent">
        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary-600/10 text-primary-600 dark:bg-primary-400/10 dark:text-primary-400">
                    <x-heroicon-o-document-text class="h-3.5 w-3.5" />
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">No. Nota</p>
                    <p class="text-lg font-semibold text-gray-950 dark:text-white">{{ $record->nota }}</p>
                </div>
            </div>

            @php
                $statusLabel = match ($record->approve) {
                    'Y' => 'Disetujui L1',
                    'T' => 'Ditolak L1',
                    default => 'Menunggu L1',
                };
                $statusColor = match ($record->approve) {
                    'Y' => 'bg-success-50 text-success-700 ring-success-600/20 dark:bg-success-400/10 dark:text-success-400 dark:ring-success-400/20',
                    'T' => 'bg-danger-50 text-danger-700 ring-danger-600/20 dark:bg-danger-400/10 dark:text-danger-400 dark:ring-danger-400/20',
                    default => 'bg-warning-50 text-warning-700 ring-warning-600/20 dark:bg-warning-400/10 dark:text-warning-400 dark:ring-warning-400/20',
                };
            @endphp
            <span class="inline-flex shrink-0 items-center rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset {{ $statusColor }}">
                {{ $statusLabel }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-x-4 gap-y-4 px-5 py-4 text-sm sm:grid-cols-3">
            <div class="flex items-start gap-2">
                <x-heroicon-o-calendar-days class="mt-0.5 h-3 w-3 shrink-0 text-gray-400" />
                <div>
                    <p class="font-medium text-gray-500 dark:text-gray-400">Tanggal</p>
                    <p class="text-gray-950 dark:text-white">{{ optional($record->tgl)->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-2">
                <x-heroicon-o-hashtag class="mt-0.5 h-3 w-3 shrink-0 text-gray-400" />
                <div>
                    <p class="font-medium text-gray-500 dark:text-gray-400">No. PO / NOP</p>
                    <p class="text-gray-950 dark:text-white">{{ $record->nop ?: '-' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-2">
                <x-heroicon-o-user class="mt-0.5 h-3 w-3 shrink-0 text-gray-400" />
                <div>
                    <p class="font-medium text-gray-500 dark:text-gray-400">Diinput oleh</p>
                    <p class="text-gray-950 dark:text-white">{{ $record->user ?: '-' }}</p>
                </div>
            </div>

            <div class="col-span-2 flex items-start gap-2 sm:col-span-3">
                <x-heroicon-o-briefcase class="mt-0.5 h-3 w-3 shrink-0 text-gray-400" />
                <div>
                    <p class="font-medium text-gray-500 dark:text-gray-400">Nama Project</p>
                    <p class="text-gray-950 dark:text-white">{{ $record->nmproject ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail item produk --}}
    <div>
        <div class="mb-2 flex items-center gap-2">
            <x-heroicon-o-shopping-bag class="h-3 w-3 text-gray-400" />
            <p class="text-sm font-semibold text-gray-950 dark:text-white">Detail Barang</p>
            <span class="text-xs text-gray-400">({{ $record->dprItems->count() }} item)</span>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-3 py-2.5 text-left font-medium text-gray-500 dark:text-gray-400">Kode</th>
                            <th class="px-3 py-2.5 text-left font-medium text-gray-500 dark:text-gray-400">Nama Barang</th>
                            <th class="px-3 py-2.5 text-right font-medium text-gray-500 dark:text-gray-400">Qty</th>
                            <th class="px-3 py-2.5 text-left font-medium text-gray-500 dark:text-gray-400">Satuan</th>
                            <th class="px-3 py-2.5 text-right font-medium text-gray-500 dark:text-gray-400">Harga</th>
                            <th class="px-3 py-2.5 text-right font-medium text-gray-500 dark:text-gray-400">Subtotal</th>
                            <th class="px-3 py-2.5 text-left font-medium text-gray-500 dark:text-gray-400">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($record->dprItems as $item)
                            <tr class="odd:bg-white even:bg-gray-50/60 hover:bg-primary-50/50 dark:odd:bg-transparent dark:even:bg-white/2 dark:hover:bg-primary-400/5">
                                <td class="px-3 py-2.5 font-mono text-xs text-gray-600 dark:text-gray-300">{{ $item->kd_brg }}</td>
                                <td class="px-3 py-2.5 font-medium text-gray-950 dark:text-white">{{ $item->nama }}</td>
                                <td class="px-3 py-2.5 text-right tabular-nums text-gray-950 dark:text-white">{{ $item->qty }}</td>
                                <td class="px-3 py-2.5 text-gray-600 dark:text-gray-300">{{ $item->sat }}</td>
                                <td class="px-3 py-2.5 text-right tabular-nums text-gray-950 dark:text-white">{{ number_format($item->harga, 2) }}</td>
                                <td class="px-3 py-2.5 text-right tabular-nums font-medium text-gray-950 dark:text-white">
                                    {{ number_format($item->qty * $item->harga, 2) }}
                                </td>
                                <td class="px-3 py-2.5 text-gray-600 dark:text-gray-300">
                                    {{ trim(collect([$item->ket, $item->ket1, $item->ket2])->filter()->implode(' ')) ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-8 text-center">
                                    <div class="flex flex-col items-center gap-2 text-gray-400">
                                        <x-heroicon-o-inbox class="h-6 w-6" />
                                        <span class="text-sm">Tidak ada detail barang untuk PR ini.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($record->dprItems->isNotEmpty())
                        <tfoot class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <td colspan="5" class="px-3 py-2.5 text-right text-sm font-semibold text-gray-500 dark:text-gray-400">
                                    Total
                                </td>
                                <td class="px-3 py-2.5 text-right text-sm font-semibold tabular-nums text-gray-950 dark:text-white">
                                    {{ number_format($record->dprItems->sum(fn ($item) => $item->qty * $item->harga), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>