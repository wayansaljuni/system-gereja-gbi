<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\RelationManagers;

use App\Models\KategoriKeuangan;
use App\Models\Perpuluhan;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\DB;

class PemasukanRelationManager extends RelationManager
{
    protected static string $relationship = 'transaksiKeuangan';
    protected static ?string $title = 'Pemasukan';

public function form(Schema $schema): Schema
{
    return $schema
        ->components([
            Section::make('Informasi Pemasukan')
                ->schema([

                    TextInput::make('tanggal')
                        ->label('Tanggal Transaksi')
                        ->default(fn () => $this->getOwnerRecord()->tanggal)
                        ->formatStateUsing(
                            fn () => $this->getOwnerRecord()->tanggal
                        )
                        ->disabled()
                        ->dehydrated(),

                    Select::make('kategori_keuangan_id')
                        ->label('Kategori Pemasukan')
                        ->relationship(
                            name: 'kategoriKeuangan',
                            titleAttribute: 'nama',
                            modifyQueryUsing: fn (Builder $query) =>
                                $query->where('tipe', 'pemasukan')
                        )
                        ->searchable()
                        ->preload()
                        ->live()
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set) {
                        // Reset repeater ketika kategori berubah
                        $set('detail_jemaat', []);
                        // Reset pemasukan umum
                        $set('akun_id', null);
                        $set('metode_pembayaran', 'tunai');
                        $set('jumlah', null);
                        $set('keterangan', null);
                    })
                    ,

                ])
                ->columns(3)
                ->columnSpanFull(),

            /*
             |--------------------------------------------------------------------------
             | DETAIL JEMAAT
             |--------------------------------------------------------------------------
             */

            Section::make('')
                ->schema([
                    Repeater::make('detail_jemaat')
                        ->label('Detail Persembahan Jemaat')
                        ->schema([
                            Select::make('perpuluhan_id')
                                ->label('No. Kantong')
                                ->options(
                                    Perpuluhan::query()
                                        ->orderBy('no_kantong')
                                        ->pluck('no_kantong', 'id')
                                        ->toArray()
                                )
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('akun_id')
                                ->label('Akun')
                                ->relationship(
                                    name: 'akun',
                                    titleAttribute: 'nama'
                                )
                                ->getOptionLabelFromRecordUsing(
                                    fn ($record) => "{$record->kode} - {$record->nama}"
                                )
                                ->searchable()
                                ->preload()
                                ->required()
                                ->default(function (callable $get) {
                                    $kategoriId = $get('../../kategori_keuangan_id');
                                    if (! $kategoriId) {
                                        return null;
                                    }
                                    return KategoriKeuangan::find(
                                        $kategoriId
                                    )?->akun_default_id;
                                }),

                            Select::make('metode_pembayaran')
                                ->label('Metode Pembayaran')
                                ->options([
                                    'tunai' => 'Tunai',
                                    'transfer' => 'Transfer',
                                ])
                                ->default('tunai')
                                ->required(),

                            TextInput::make('jumlah')
                                ->label('Jumlah')
                                ->numeric()
                                ->prefix('Rp')
                                ->mask(RawJs::make('$money($input, \'.\', \',\', 2)'))
                                ->stripCharacters(',')
                                ->required(),

                            // Textarea::make('keterangan')
                            //     ->label('Keterangan')
                            //     ->rows(1),

                        ])

                        /*
                        * TAMPIL SEPERTI TABLE
                        */
                        ->table([
                            TableColumn::make('No. Kantong')
                                ->width('150px'),

                            TableColumn::make('Akun')
                                ->width('220px'),

                            TableColumn::make('Metode Pembayaran')
                                ->width('180px'),

                            TableColumn::make('Jumlah')
                                ->width('180px'),

                            // TableColumn::make('Keterangan')
                            //     ->width('250px'),
                        ])

                        ->addActionLabel('Tambah No. Kantong')
                        ->reorderable(false)
                        ->defaultItems(1)
                        ->columnSpanFull()                        
                        ->visible(function (callable $get) {
                            $kategoriId = $get('kategori_keuangan_id');
                            if (! $kategoriId) {
                                return false;
                            }

                    return KategoriKeuangan::whereKey($kategoriId)
                        ->where('tipe', 'pemasukan')
                        ->where('bisa_detail_jemaat', true)
                        ->exists();
                }),

                ])
                ->visible(function (callable $get) {
                    $kategoriId =
                        $get('kategori_keuangan_id');

                    if (! $kategoriId) {
                        return false;
                    }
                    return KategoriKeuangan::whereKey($kategoriId)
                        ->where('tipe', 'pemasukan')
                        ->where(
                            'bisa_detail_jemaat',
                            true
                        )
                        ->exists();
                })
                ->columns(3)
                ->columnSpanFull()
                ,

            /*
             |--------------------------------------------------------------------------
             | PEMASUKAN UMUM
             |--------------------------------------------------------------------------
             */

            Section::make('Pemasukan Umum')
                ->schema([
                    Select::make('akun_id')
                        ->label('Akun')
                        ->relationship(
                            name: 'akun',
                            titleAttribute: 'nama'
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) =>
                                "{$record->kode} - {$record->nama}"
                        )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->default(function (callable $get) {
                            $kategoriId =
                                $get('kategori_keuangan_id');
                            if (! $kategoriId) {
                                return null;
                            }
                            return KategoriKeuangan::find(
                                $kategoriId
                            )?->akun_default_id;
                        }),

                    Select::make('metode_pembayaran')
                        ->label('Metode Pembayaran')
                        ->options([
                            'tunai' => 'Tunai',
                            'transfer' => 'Transfer',
                        ])
                        ->default('tunai')
                        ->required(),

                    TextInput::make('jumlah')
                        ->label('Jumlah')
                        ->numeric()
                        ->prefix('Rp')
                        ->mask(RawJs::make('$money($input, \'.\', \',\', 2)'))
                        ->stripCharacters(',')
                        ->required(),

                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(2)
                        ->columnSpanFull(),

                ])
                // ->columns(4)
                ->visible(function (callable $get) {
                    $kategoriId =
                        $get('kategori_keuangan_id');
                    if (! $kategoriId) {
                        return false;
                    }

                    return KategoriKeuangan::whereKey($kategoriId)
                        ->where('tipe', 'pemasukan')
                        ->where(
                            'bisa_detail_jemaat',
                            false
                        )
                        ->exists();
                }),

        ]);
}

public function table(Table $table): Table
{
    $kategoriMetodeGroup = Group::make('kategori_keuangan_id')
        ->label('Kategori + Metode')

        ->getKeyFromRecordUsing(
            fn ($record): string =>
                $record->kategori_keuangan_id . '|' .
                strtolower(trim($record->metode_pembayaran ?? ''))
        )

        ->getTitleFromRecordUsing(
            fn ($record): string =>
                ($record->kategoriKeuangan?->nama ?? '-') .
                ' — ' .
                ucfirst($record->metode_pembayaran ?? '-')
        )

        ->scopeQueryByKeyUsing(
            function (Builder $query, string $key): Builder {
                [$kategoriId, $metode] = explode('|', $key, 2);

                return $query
                    ->where('kategori_keuangan_id', $kategoriId)
                    ->whereRaw(
                        'LOWER(TRIM(metode_pembayaran)) = ?',
                        [$metode]
                    );
            }
        )

        ->orderQueryUsing(
            fn (Builder $query, string $direction): Builder =>
                $query
                    ->orderBy('kategori_keuangan_id', $direction)
                    ->orderByRaw("LOWER(TRIM(metode_pembayaran)) {$direction}")
        )

        ->titlePrefixedWithLabel(false)
        ->collapsible();

        return $table
            ->modifyQueryUsing(
                fn (Builder $query) =>
                    $query->whereHas(
                        'kategoriKeuangan',
                        fn (Builder $q) => $q->where('tipe', 'pemasukan')
                    )
            )
            ->groups([
                $kategoriMetodeGroup,
            ])
            ->defaultGroup($kategoriMetodeGroup)
        // ->groups([
        //     Group::make('kategori_keuangan_id')
        //         ->label('Kategori + Metode')

        //         ->getKeyFromRecordUsing(
        //             fn ($record): string =>
        //                 $record->kategori_keuangan_id . '|' . strtolower($record->metode_pembayaran)
        //         )

        //         ->getTitleFromRecordUsing(
        //             fn ($record): string =>
        //                 ($record->kategoriKeuangan?->nama ?? '-') .
        //                 ' — ' .
        //                 ucfirst($record->metode_pembayaran ?? '-')
        //         )

        //         ->scopeQueryByKeyUsing(
        //             function (Builder $query, string $key): Builder {
        //                 [$kategoriId, $metode] = explode('|', $key, 2);

        //                 return $query
        //                     ->where('kategori_keuangan_id', $kategoriId)
        //                     ->whereRaw('LOWER(metode_pembayaran) = ?', [$metode]);
        //             }
        //         )

        //         // Urutkan agar grup dengan key sama selalu berdekatan
        //         ->orderQueryUsing(
        //             fn (Builder $query, string $direction): Builder =>
        //                 $query
        //                     ->orderBy('kategori_keuangan_id', $direction)
        //                     ->orderBy('metode_pembayaran', $direction)
        //         )

        //         ->titlePrefixedWithLabel(false)
        //         ->collapsible(),
        // ])

        ->columns([
            TextColumn::make('tanggal')
                ->label('Tanggal')
                ->date('d/m/Y')
                ->icon(Heroicon::OutlinedCalendarDays)
                ->extraCellAttributes([
                    'style' => 'padding-inline-start: 3rem; border-inline-start: 3px solid rgba(34, 197, 94, 0.5);',
                ])
                ->sortable(),

            TextColumn::make('kategoriKeuangan.nama')
                ->label('Kategori')
                ->icon(Heroicon::OutlinedTag)
                ->searchable(isIndividual: true),

            TextColumn::make('perpuluhan.no_kantong')
                ->label('No. Kantong')
                ->searchable(isIndividual: true)
                ->sortable()
                ->icon(Heroicon::OutlinedArchiveBoxXMark),

            TextColumn::make('akun.nama')
                ->label('Akun')
                ->icon(Heroicon::OutlinedWallet)
                ->searchable(isIndividual: true)
                ->sortable(),

            TextColumn::make('metode_pembayaran')
                ->label('Metode')
                ->badge()
                ->icon(fn (string $state): Heroicon => match (strtolower($state)) {
                    'tunai', 'cash'               => Heroicon::OutlinedBanknotes,
                    'transfer'                    => Heroicon::OutlinedBuildingLibrary,
                    'kartu', 'debit', 'kredit'    => Heroicon::OutlinedCreditCard,
                    'qris', 'e-wallet', 'ewallet' => Heroicon::OutlinedQrCode,
                    default                       => Heroicon::OutlinedCurrencyDollar,
                })
                ->searchable(isIndividual: true),

            TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR', locale: 'id')
                ->icon(Heroicon::OutlinedArrowTrendingUp)
                ->iconColor('success')
                ->sortable()
                ->summarize(
                    Sum::make()
                        ->money('IDR', locale: 'id')
                        ->label('Total')
                ),

            TextColumn::make('keterangan')
                ->label('Keterangan')
                ->icon(Heroicon::OutlinedDocumentText)
                ->searchable(isIndividual: true)
                ->limit(40),
        ])
        ->headerActions([
            CreateAction::make()
                ->label('Tambah Pemasukan')
                ->using(function (array $data): Model {
                    $header = $this->getOwnerRecord();
                    $kategori = KategoriKeuangan::findOrFail(
                        $data['kategori_keuangan_id']
                    );
                    // Jika kategori menggunakan detail jemaat / repeater
                    if ($kategori->bisa_detail_jemaat) {
                        $transaksiPertama = null;
                        foreach ($data['detail_jemaat'] ?? [] as $item) {
                            $perpuluhan = Perpuluhan::findOrFail(
                                $item['perpuluhan_id']
                            );
                            $transaksi = $header->transaksiKeuangan()->create([
                                'tanggal' => $header->tanggal,
                                'ibadah_id' => $header->ibadah_id,
                                'kategori_keuangan_id' => $kategori->id,
                                'akun_id' => $item['akun_id'],
                                'metode_pembayaran' =>
                                    $item['metode_pembayaran'],
                                'perpuluhan_id' => $perpuluhan->id,
                                'jemaat_id' => $perpuluhan->jemaat_id,
                                'jumlah' => $item['jumlah'],
                                'keterangan' => $item['keterangan'] ?? null,
                            ]);
                            $transaksiPertama ??= $transaksi;
                        }
                        if (! $transaksiPertama) {
                            throw new \Exception(
                                'Minimal harus ada satu detail persembahan jemaat.'
                            );
                        }
                        return $transaksiPertama;
                    }
                    // Jika kategori tidak menggunakan repeater
                    return $header->transaksiKeuangan()->create([
                        'tanggal' => $header->tanggal,
                        'ibadah_id' => $header->ibadah_id,
                        'kategori_keuangan_id' => $kategori->id,
                        'akun_id' => $data['akun_id'],
                        'metode_pembayaran' =>
                            $data['metode_pembayaran'],
                        'jumlah' => $data['jumlah'],
                        'keterangan' => $data['keterangan'] ?? null,
                    ]);
                }),
            ])
        ->recordActions([
            EditAction::make()
                ->label('Edit')
                // Mengisi data record ke dalam Repeater
                ->mutateRecordDataUsing(function (array $data, Model $record): array {
                    $data['detail_jemaat'] = [];
                    $kategori = KategoriKeuangan::find(
                        $record->kategori_keuangan_id
                    );
                    if ($kategori?->bisa_detail_jemaat) {
                        $data['detail_jemaat'] = [[
                            'perpuluhan_id' => $record->perpuluhan_id,
                            'akun_id' => $record->akun_id,
                            'metode_pembayaran' => $record->metode_pembayaran,
                            'jumlah' => $record->jumlah,
                            'keterangan' => $record->keterangan,
                        ]];

                    }
                    return $data;
                })
                // Menyimpan hasil edit
                ->using(function (Model $record, array $data): Model {
                    return DB::transaction(function () use ($record, $data) {
                        $kategori = KategoriKeuangan::findOrFail(
                            $data['kategori_keuangan_id']
                        );
                        // Jika menggunakan Repeater
                        if ($kategori->bisa_detail_jemaat) {
                            $details = $data['detail_jemaat'] ?? [];
                            if (empty($details)) {
                                throw new \Exception(
                                    'Minimal harus ada satu detail persembahan jemaat.'
                                );
                            }
                            $firstRecord = null;
                            foreach ($details as $index => $item) {
                                $perpuluhan = Perpuluhan::findOrFail(
                                    $item['perpuluhan_id']
                                );
                                $attributes = [
                                    'tanggal' => $record->header->tanggal,
                                    'ibadah_id' => $record->header->ibadah_id,
                                    'kategori_keuangan_id' => $kategori->id,
                                    'akun_id' => $item['akun_id'],
                                    'metode_pembayaran' => $item['metode_pembayaran'],
                                    'perpuluhan_id' => $perpuluhan->id,
                                    'jemaat_id' => $perpuluhan->jemaat_id,
                                    'jumlah' => $item['jumlah'],
                                    'keterangan' => $item['keterangan'] ?? null,
                                ];

                                if ($index === 0) {
                                    // Update record yang sedang diedit
                                    $record->update($attributes);

                                    $firstRecord = $record;
                                } else {
                                    // Tambahkan record baru jika ada baris tambahan
                                    $record->header->transaksiKeuangan()->create(
                                        $attributes
                                    );
                                }
                            }
                            return $firstRecord;
                        }
                        // Jika tidak menggunakan Repeater
                        $record->update([
                            'tanggal' => $record->header->tanggal,
                            'ibadah_id' => $record->header->ibadah_id,
                            'kategori_keuangan_id' => $kategori->id,
                            'akun_id' => $data['akun_id'],
                            'metode_pembayaran' => $data['metode_pembayaran'],
                            'perpuluhan_id' => null,
                            'jemaat_id' => null,
                            'jumlah' => $data['jumlah'],
                            'keterangan' => $data['keterangan'] ?? null,
                        ]);
                        return $record;
                    });
                }),

            DeleteAction::make()
                ->icon(Heroicon::OutlinedTrash),
        ]);
    }
}
