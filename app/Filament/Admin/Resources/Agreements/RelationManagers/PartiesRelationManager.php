<?php

namespace App\Filament\Admin\Resources\Agreements\RelationManagers;

// use Filament\Actions\AssociateAction;
// use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
// use Filament\Actions\DissociateAction;
// use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartiesRelationManager extends RelationManager
{
    protected static string $relationship = 'parties';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('party_type')
                    ->label('Party Type')
                    ->options([
                        'internal' => 'Internal',
                        'external' => 'External',
                    ])
                    ->native(false)
                    ->prefixIcon(Heroicon::OutlinedBuildingOffice)
                    ->default('external')
                    ->required(),

                TextInput::make('name')
                    ->label('Party Name')
                    ->prefixIcon(Heroicon::OutlinedUser)
                    ->required()
                    ->maxLength(255),

                // TextInput::make('role')
                //     ->label('Peran')
                //     ->prefixIcon(Heroicon::OutlinedIdentification)
                //     ->maxLength(100)
                //     ->placeholder('cth: Vendor, Klien, Mitra'),

                TextInput::make('contact_person')
                    ->label('Contact Person')
                    ->prefixIcon(Heroicon::OutlinedUserCircle)
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->prefixIcon(Heroicon::OutlinedEnvelope)
                    ->email()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phoen Number')
                    ->prefixIcon(Heroicon::OutlinedPhone)
                    ->tel()
                    ->maxLength(50),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Party Name')
                    ->icon(Heroicon::OutlinedUser)
                    ->searchable(),

                TextColumn::make('party_type')
                    ->label('Party Type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'internal' ? 'info' : 'gray'),

                // TextColumn::make('role')
                //     ->label('Peran')
                //     ->placeholder('—'),

                TextColumn::make('contact_person')
                    ->label('Contact Person')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->icon(Heroicon::OutlinedPhone)
                    ->placeholder('—')
                    ->toggleable(),
            ])
            ->headerActions([
                CreateAction::make()
                ->label('New Party'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            // ->toolbarActions([
            //     DeleteBulkAction::make(),
            // ])
            ;
    }
}
