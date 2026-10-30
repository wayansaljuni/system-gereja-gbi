<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Schemas;

use App\Models\Akun;
use App\Models\Jemaat;
use App\Models\KategoriKeuangan;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\RawJs;

class TransaksiKeuanganHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        $kategori = KategoriKeuangan::query()
            ->where('aktif', true)
            ->orderBy('nama')
            ->get();

        $akunOptions = Akun::query()
            ->where('aktif', true)
            ->orderBy('nama')
            ->pluck('nama', 'id')
            ->all();

        $jemaatOptions = Jemaat::query()
            ->orderBy('no_kantong')
            ->get()
            ->mapWithKeys(fn ($jemaat) => [
                $jemaat->id => trim(
                    ($jemaat->no_kantong ?? '-')
                ),
            ])
            ->all();
        // $jemaatOptions = Jemaat::query()
        //     ->orderBy('no_kantong')
        //     ->get()
        //     ->mapWithKeys(fn ($jemaat) => [
        //         $jemaat->id => trim(
        //             ($jemaat->no_kantong ?? '-') . ' - ' . $jemaat->nama
        //         ),
        //     ])
        //     ->all();

        $metodeOptions = [
            'tunai' => 'Tunai',
            'transfer' => 'Transfer',
        ];

        /*
        |--------------------------------------------------------------------------
        | Format Rupiah
        |--------------------------------------------------------------------------
        */
        $rupiah = function ($value): string {
            return 'Rp ' . number_format(
                (float) $value,
                0,
                ',',
                '.'
            );
        };

        /*
        |--------------------------------------------------------------------------
        | Hitung Total
        |--------------------------------------------------------------------------
        */
        $hitungRekap = function (Get $get) use ($kategori): array {

            $pemasukanTunai = 0;
            $pemasukanTransfer = 0;
            $pengeluaranTunai = 0;
            $pengeluaranTransfer = 0;

            foreach ($kategori as $item) {
                $id = $item->id;
                /*
                |--------------------------------------------------------------------------
                | PEMASUKAN DETAIL JEMAAT
                |--------------------------------------------------------------------------
                */
                if (
                    $item->tipe === 'pemasukan'
                    && (bool) $item->bisa_detail_jemaat
                ) {
                    $rows = $get("jemaat_{$id}") ?? [];
                    foreach ($rows as $row) {
                        // $jumlah = (float) ($row['jumlah'] ?? 0);
                        $jumlah = (float) str_replace(
                            ',',
                            '',
                            (string) ($row['jumlah'] ?? 0)
                        );

                        $metode = $row['metode_pembayaran'] ?? 'tunai';
                        if ($metode === 'transfer') {
                            $pemasukanTransfer += $jumlah;
                        } else {
                            $pemasukanTunai += $jumlah;
                        }
                    }
                    continue;
                }
                /*
                |--------------------------------------------------------------------------
                | PEMASUKAN / PENGELUARAN UMUM
                |--------------------------------------------------------------------------
                */
                $jumlah = (float) str_replace(
                    ',',
                    '',
                    (string) ($get("jumlah_umum_{$id}") ?? 0)
                );
                // dd($jumlah);
                $metode = $get("metode_{$id}") ?? 'tunai';

                if ($item->tipe === 'pemasukan') {
                    if ($metode === 'transfer') {
                        $pemasukanTransfer += $jumlah;
                    } else {
                        $pemasukanTunai += $jumlah;
                    }
                } else {
                    if ($metode === 'transfer') {
                        $pengeluaranTransfer += $jumlah;
                    } else {
                        $pengeluaranTunai += $jumlah;
                    }
                }
            }
            $totalPemasukan =
                $pemasukanTunai +
                $pemasukanTransfer;

            $totalPengeluaran =
                $pengeluaranTunai +
                $pengeluaranTransfer;

            $saldoTunai =
                $pemasukanTunai -
                $pengeluaranTunai;
            $saldoTotal =
                $totalPemasukan -
                $totalPengeluaran;

            return [
                'pemasukan_tunai' => $pemasukanTunai,
                'pemasukan_transfer' => $pemasukanTransfer,
                'total_pemasukan' => $totalPemasukan,

                'pengeluaran_tunai' => $pengeluaranTunai,
                'pengeluaran_transfer' => $pengeluaranTransfer,
                'total_pengeluaran' => $totalPengeluaran,

                'saldo_tunai' => $saldoTunai,
                'saldo_total' => $saldoTotal,
            ];
        };

        /*
        |--------------------------------------------------------------------------
        | Input setiap kategori
        |--------------------------------------------------------------------------
        */
        $buatInputKategori = function (
            KategoriKeuangan $item,
            string $tipe
        ) use (
            $akunOptions,
            $jemaatOptions,
            $metodeOptions
        ) {

            $id = $item->id;

            $detailJemaat =
                $tipe === 'pemasukan'
                && (bool) $item->bisa_detail_jemaat;

            $fields = [

                Select::make("akun_id_{$id}")
                    ->label('Akun Kas / Bank')
                    ->options($akunOptions)
                    ->default(fn () => $item->akun_default_id)
                    ->placeholder('Pilih Akun')
                    ->searchable()
                    ->required()
                    ->live()->visible(! $detailJemaat),

                Select::make("metode_{$id}")
                    ->label('Tunai / Transfer')
                    ->options($metodeOptions)
                    ->default('tunai')
                    ->required()
                    ->live()->visible(! $detailJemaat),

                TextInput::make("jumlah_umum_{$id}")
                    ->label($detailJemaat ? 'Total Jumlah (Rp)' : 'Jumlah Umum (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->mask(
                        RawJs::make(<<<'JS'
                            $money($input, '.', ',', 2)
                        JS)
                    )
                    ->stripCharacters(',')
                    ->default(0)
                    ->minValue(0)
                    ->live()
                    ->disabled($detailJemaat)
                    ->dehydrated()
                    // ->visible(! $detailJemaat)
                    ,
            ];

            /*
            |--------------------------------------------------------------------------
            | DETAIL JEMAAT
            |--------------------------------------------------------------------------
            */
            if ($detailJemaat) {

            $fields[] = Repeater::make("jemaat_{$id}")
                    ->extraAttributes([
                        'style' => 'max-height: 250px; overflow: auto;',
                    ])                
                    ->label('Rincian')
                    ->schema([
                        Select::make('jemaat_id')
                            // ->label('Jemaat / No. Kantong')
                            ->options($jemaatOptions)
                            ->placeholder('...')
                            ->searchable()
                            // ->required()
                            ->live()
                            ->columnSpan(1)
                            ,

                        Select::make("akun_id_{$id}")
                            ->label('Akun Kas / Bank')
                            ->placeholder('...')
                            ->options($akunOptions)
                            ->default(fn () => $item->akun_default_id)
                            ->searchable()
                            ->required()
                            ->columnSpan(1)
                            ->live(),

                        Select::make('metode_pembayaran')
                            ->label('Tunai / Transfer')
                            ->options($metodeOptions)
                            ->default('tunai')
                            ->required()
                            ->live()
                            ->columnSpan(1),

                        TextInput::make('jumlah')
                            ->label('Jumlah (Rp)')
                            ->numeric()
                            // ->prefix('Rp')
                            ->mask(
                                RawJs::make(<<<'JS'
                                    $money($input, '.', ',', 2)
                                JS)
                            )
                            ->stripCharacters(',')                            
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live()
                            ->columnSpan(1)
                            ->afterStateUpdated(function (Get $get, Set $set) use ($id) {
                                // Ambil seluruh baris repeater
                                $rows = $get("../../jemaat_{$id}") ?? [];
                                $total = collect($rows)->sum(
                                    fn ($row) => (float) str_replace(
                                        ',',
                                        '',
                                        (string) ($row['jumlah'] ?? 0)
                                    )
                                );
                                // Perbarui field total kategori
                                $set("../../jumlah_umum_{$id}", $total);
                                // dd($total);
                            })   
                            ,

                    ])
                    ->columns(4)
                    ->table([
                        Repeater\TableColumn::make('No. Kantong')
                        ->width('20%'),
                        Repeater\TableColumn::make('Akun Kas / Bank')
                        ->width('40%'),
                        Repeater\TableColumn::make('Tunai / Transfer')
                        ->width('15%'),
                        Repeater\TableColumn::make('Jumlah (Rp)')
                        ->width('25%'),
                    ])
                    ->defaultItems(3)
                    ->addActionLabel('Tambah Kantong')
                    ->addActionAlignment(Alignment::Start)
                    ->addAction(
                        fn (Action $action) => $action
                            ->icon('heroicon-m-plus')
                            ->color('primary')
                    )
                    ->collapsible()
                    ->reorderable(false)
                    ->columnSpanFull();
            }

            return Section::make($item->nama)
                ->schema($fields)
                ->columns(3)
                ->collapsible();
        };

        /*
        |--------------------------------------------------------------------------
        | Kategori Pemasukan
        |--------------------------------------------------------------------------
        */
        $pemasukan = $kategori
            ->where('tipe', 'pemasukan')
            ->map(
                fn ($item) =>
                    $buatInputKategori($item, 'pemasukan')
            )
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Kategori Pengeluaran
        |--------------------------------------------------------------------------
        */
        $pengeluaran = $kategori
            ->where('tipe', 'pengeluaran')
            ->map(
                fn ($item) =>
                    $buatInputKategori($item, 'pengeluaran')
            )
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | FORM
        |--------------------------------------------------------------------------
        */
        return $schema->components([

            Grid::make(1)
                ->schema([
                    // KOLOM KIRI: INFORMASI TRANSAKSI
                    Section::make('Informasi Transaksi')
                        ->schema([
                            DateTimePicker::make('tanggal')
                                ->label('Tanggal Transaksi')
                                ->required()
                                ->default(now())
                                ->seconds(false),

                            Select::make('ibadah_id')
                                ->label('Ibadah')
                                ->relationship(
                                    name: 'ibadah',
                                    titleAttribute: 'nama',
                                    modifyQueryUsing: fn ($query) => $query
                                        ->where('aktif', true)
                                        ->orderBy('nama')
                                )
                                ->searchable()
                                ->preload()
                                ->required(),

                            Textarea::make('keterangan')
                                ->label('Keterangan')
                                ->rows(1),
                            TextEntry::make('pemasukan_tunai')
                                ->label('Pemasukan Tunai')
                                ->state(function (Get $get) use ($hitungRekap) {
                                    return $hitungRekap($get)['pemasukan_tunai'];
                                })
                                ->money('IDR', locale: 'id')
                                ->size('lg')
                                ->weight('bold')
                                ->color('success')
                                ,
                                
                           TextEntry::make('pengeluaran_tunai')
                                ->label('Pengeluaran Tunai')
                                ->state(function (Get $get) use ($hitungRekap) {
                                    return $hitungRekap($get)['pengeluaran_tunai'];
                                })
                                ->money('IDR', locale: 'id')
                                ->size('lg')
                                ->weight('bold')
                                ->color('danger')
                                ,
                            TextEntry::make('saldo_tunai')
                                ->label('Saldo Tunai')
                                ->state(function (Get $get) use ($hitungRekap) {
                                    return $hitungRekap($get)['saldo_tunai'];
                                })
                                ->money('IDR', locale: 'id')
                                ->size('lg')
                                ->weight('bold')
                                ->color(function (Get $get) use ($hitungRekap) {
                                    return $hitungRekap($get)['saldo_tunai'] < 0
                                        ? 'danger'
                                        : 'success';
                                }),

                            TextEntry::make('pemasukan_transfer')
                                ->label('Pemasukan Transfer')
                                ->state(function (Get $get) use ($hitungRekap) {
                                    return $hitungRekap($get)['pemasukan_transfer'];
                                })
                                ->money('IDR', locale: 'id')
                                ->size('lg')
                                ->weight('bold')
                                ->color('success'),

                             TextEntry::make('pengeluaran_transfer')
                                ->label('Pengeluaran Transfer')
                                ->state(function (Get $get) use ($hitungRekap) {
                                    return $hitungRekap($get)['pengeluaran_transfer'];
                                })
                                ->money('IDR', locale: 'id')
                                ->size('lg')
                                ->weight('bold')
                                ->color('danger')
                                ,

                        ])
                        ->columns(3)
                        ->columnSpan(1),
                    ])
                    ->columnSpanFull()
                    ,

            // PERTAHANKAN SECTION PEMASUKAN DAN PENGELUARAN DI BAWAH INI

            Section::make('Pemasukan')
                ->schema([
                    Grid::make(2)
                        ->schema($pemasukan)
                        ->columnSpanFull(),
                ])
                ->extraAttributes([
                    'style' => 'max-height: 60vh; overflow-y: auto; padding-right: .5rem;',
                ])                
                ->columnSpanFull(),

            Section::make('Pengeluaran')
                ->schema([
                    Grid::make(2)
                        ->schema($pengeluaran)
                        ->columnSpanFull(),
                ])
                ->extraAttributes([
                    'style' => 'max-height: 60vh; overflow-y: auto; padding-right: .5rem;',
                ])                
                ->columnSpanFull(),

        ]);

    }
}