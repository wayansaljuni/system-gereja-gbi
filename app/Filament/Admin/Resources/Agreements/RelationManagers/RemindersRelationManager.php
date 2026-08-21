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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RemindersRelationManager extends RelationManager
{
    protected static string $relationship = 'reminders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Reminder')
                    ->prefixIcon(Heroicon::OutlinedBookmark)
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                DatePicker::make('remind_at')
                    ->label('Tanggal Reminder')
                    ->prefixIcon(Heroicon::OutlinedCalendarDays)
                    ->native(false)
                    ->required(),

                Toggle::make('is_sent')
                    ->label('Sudah Terkirim')
                    ->onIcon(Heroicon::OutlinedCheckCircle)
                    ->offIcon(Heroicon::OutlinedClock)
                    ->onColor('success'),

                Textarea::make('message')
                    ->label('Pesan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->searchable(),

                TextColumn::make('remind_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->icon(Heroicon::OutlinedCalendar)
                    ->sortable(),

                IconColumn::make('is_sent')
                    ->label('Terkirim')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('warning'),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(40)
                    ->placeholder('—'),
            ])
            ->defaultSort('remind_at')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
