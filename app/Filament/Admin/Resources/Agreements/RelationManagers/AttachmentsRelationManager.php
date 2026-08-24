<?php

namespace App\Filament\Admin\Resources\Agreements\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    public function form(Schema $schema): Schema
    {
        return $schema
           ->components([
                FileUpload::make('file_path')
                    ->label('Select File')
                    ->directory('agreement-attachments')
                    ->openable()
                    ->downloadable()
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('file_name')
                    ->label('File Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('file_type')
                    ->label('File Type')
                    ->maxLength(50)
                    ->placeholder('cth: pdf, docx'),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_name')
            ->columns([
                TextColumn::make('file_name')
                    ->label('File Name')
                    ->icon(Heroicon::OutlinedDocument)
                    ->searchable(),

                TextColumn::make('file_type')
                    ->label('File Type')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                ->label('New Attach'),
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
