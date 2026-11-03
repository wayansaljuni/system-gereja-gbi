<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengeluaranRelationManager extends RelationManager
{
    protected static string $relationship = 'transaksiKeuangan';
    protected static ?string $title = 'Pengeluaran';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal')
                    ->label('Tanggal Transaksi')
                    ->prefixIcon(Heroicon::OutlinedCalendarDays)
                    ->default(fn () => $this->getOwnerRecord()->tanggal)
                    ->required(),

                Select::make('kategori_keuangan_id')
                    ->label('Kategori Pengeluaran')
                    ->prefixIcon(Heroicon::OutlinedTag)
                    ->relationship(
                        name: 'kategoriKeuangan',
                        titleAttribute: 'nama',
                        modifyQueryUsing: fn (Builder $query) =>
                            $query->where('tipe', 'pengeluaran')
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $kategori = \App\Models\KategoriKeuangan::find($state);
                        $set('akun_id', $kategori?->akun_default_id);
                    }),

                Select::make('akun_id')
                    ->label('Kode Akun / Nama Akun')
                    ->prefixIcon(Heroicon::OutlinedBookOpen)
                    ->relationship(
                        name: 'akun',
                        titleAttribute: 'nama',
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => $record->kode . ' - ' . $record->nama
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->prefixIcon(Heroicon::OutlinedCreditCard)
                    ->options([
                        'tunai'    => 'Tunai',
                        'transfer' => 'Transfer',
                    ])
                    ->default('tunai')
                    ->required(),

                TextInput::make('jumlah')
                    ->label('Jumlah Pengeluaran')
                    ->prefixIcon(Heroicon::OutlinedBanknotes)
                    ->prefix('Rp')
                    ->numeric()
                    ->mask(RawJs::make('$money($input, \'.\', \',\', 2)'))
                    ->stripCharacters(',')
                    ->required(),

                TextInput::make('no_referensi')
                    ->label('No. Referensi')
                    ->prefixIcon(Heroicon::OutlinedHashtag)
                    ->maxLength(100),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->hintIcon(Heroicon::OutlinedDocumentText)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn (Builder $query) =>
                    $query->whereHas(
                        'kategoriKeuangan',
                        fn (Builder $q) => $q->where('tipe', 'pengeluaran')
                    )
            )
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->sortable(),

                TextColumn::make('kategoriKeuangan.nama')
                    ->label('Kategori')
                    ->icon(Heroicon::OutlinedTag)
                    ->searchable(isIndividual: true),

                TextColumn::make('akun.nama')
                    ->label('Akun')
                    ->icon(Heroicon::OutlinedWallet),

                TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->icon(fn (string $state): Heroicon => match (strtolower($state)) {
                        'tunai', 'cash'              => Heroicon::OutlinedBanknotes,
                        'transfer'                   => Heroicon::OutlinedBuildingLibrary,
                        'kartu', 'debit', 'kredit'   => Heroicon::OutlinedCreditCard,
                        'qris', 'e-wallet', 'ewallet' => Heroicon::OutlinedQrCode,
                        default                      => Heroicon::OutlinedCurrencyDollar,
                    })
                    ->searchable(isIndividual: true),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->icon(Heroicon::OutlinedArrowTrendingDown)
                    ->iconColor('danger')
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->searchable(isIndividual: true)
                    ->limit(40),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pengeluaran')
                    ->icon(Heroicon::OutlinedPlus),
            ])
            ->recordActions([
                EditAction::make()
                    ->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()
                    ->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
