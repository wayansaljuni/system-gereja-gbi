@php
    $properties = $getState();

    if ($properties instanceof \Spatie\Activitylog\Models\Activity) {
        $properties = $properties->properties;
    }

    if ($properties instanceof \Illuminate\Support\Collection) {
        $properties = $properties->toArray();
    }

    $attributes = $properties['attributes'] ?? [];
    $old = $properties['old'] ?? [];

    $labels = [
        'agreement_number' => 'Nomor Agreement',
        'title' => 'Judul',
        'description' => 'Deskripsi',
        'status' => 'Status',
        'start_date' => 'Tanggal Mulai',
        'end_date' => 'Tanggal Berakhir',
        'created_at' => 'Dibuat',
        'updated_at' => 'Diubah',
    ];

    $formatValue = function ($value, $field = null) {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_bool($value)) {
            return $value ? 'Ya' : 'Tidak';
        }

        if (is_array($value)) {
            return json_encode(
                $value,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
        }

        return $value;
    };
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">

    @if(count($attributes) > 0)

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>

                        <th class="px-4 py-3 text-left">
                            Field
                        </th>

                        <th class="px-4 py-3 text-left">
                            Sebelum
                        </th>

                        <th class="px-4 py-3 text-left">
                            Sesudah
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @foreach($attributes as $field => $newValue)

                        @php
                            $oldValue = $old[$field] ?? null;

                            $label = $labels[$field]
                                ?? \Illuminate\Support\Str::headline($field);
                        @endphp

                        <tr>

                            <td class="px-4 py-3 font-medium whitespace-nowrap">
                                {{ $label }}
                            </td>

                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                @if($oldValue !== $newValue)
                                    <span class="line-through">
                                        {{ $formatValue($oldValue, $field) }}
                                    </span>
                                @else
                                    {{ $formatValue($oldValue, $field) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $formatValue($newValue, $field) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="p-6 text-center text-sm text-gray-500">
            Tidak ada perubahan data.
        </div>

    @endif

</div>