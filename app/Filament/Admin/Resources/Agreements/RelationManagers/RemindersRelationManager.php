<?php

namespace App\Filament\Admin\Resources\Agreements\RelationManagers;

// use Filament\Actions\AssociateAction;
// use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Set;
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
                    ->label('Reminder Title')
                    ->prefixIcon(Heroicon::OutlinedBookmark)
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                DatePicker::make('remind_at')
                    ->label('Reminder Date')
                    ->prefixIcon(Heroicon::OutlinedCalendarDays)
                    ->native(false)
                    ->required(),

                // Toggle::make('is_sent')
                //     ->label('Already Sent')
                //     ->onIcon(Heroicon::OutlinedCheckCircle)
                //     ->offIcon(Heroicon::OutlinedClock)
                //     ->onColor('success'),

                Textarea::make('message')
                    ->label('Message')
                    ->rows(3)
                    ->columnSpanFull(),

                Repeater::make('recipients')
                    ->relationship()
                    ->label('Reminder Recipients')
                    ->table([
                        TableColumn::make('User')
                            ->width('180px'),
                        TableColumn::make('Name')
                            ->width('150px'),
                        TableColumn::make('Email')
                            ->width('300px'),
                        TableColumn::make('Type')
                            ->width('150px'),
                        // TableColumn::make('Active')
                        //     ->width('80px')
                        //     ->alignCenter(),
                        // TableColumn::make('Sent')
                        //     ->width('80px')
                        //     ->alignCenter(),
                        TableColumn::make('Sent At')
                            ->width('150px'),
                    ])
                    ->schema([
                        Select::make('user_id')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function (?int $state, Set $set) {
                                if (! $state) {
                                    return;
                                }

                                $user = \App\Models\User::find($state);

                                if ($user) {
                                    $set('name', $user->name);
                                    $set('email', $user->email);
                                }
                            })
                            ->relationship('user', 'name'),

                        TextInput::make('name')
                            ->maxLength(150),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Select::make('recipient_type')
                            ->options([
                                'to' => 'To',
                                'cc' => 'Cc',
                                'bcc' => 'Bcc',
                            ])
                            ->default('to')
                            ->native(false)
                            ->required(),

                        // Toggle::make('is_active')
                        //     ->default(true),

                        // Toggle::make('is_notified')
                        //     ->onIcon(Heroicon::OutlinedCheckCircle)
                        //     ->offIcon(Heroicon::OutlinedClock)
                        //     ->onColor('success')
                        //     ->disabled()
                        //     ->dehydrated(false),

                        DateTimePicker::make('notified_at')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->itemLabel(fn (array $state): ?string => $state['email'] ?? $state['name'] ?? 'New Recipient')
                    ->addActionLabel('Add Recipient')
                    ->defaultItems(0)
                    ->columnSpanFull(),
            ]);
        
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Reminder Title')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->searchable(),

                TextColumn::make('remind_at')
                    ->label('Reminder Date')
                    ->date('d M Y')
                    ->icon(Heroicon::OutlinedCalendar)
                    ->sortable(),

                IconColumn::make('is_sent')
                    ->label('Already Sent')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('warning'),

                TextColumn::make('recipients_count')
                    ->label('Recipients')
                    ->counts('recipients')
                    ->badge()
                    ->color('info'),

                TextColumn::make('message')
                    ->label('Message')
                    ->limit(40)
                    ->placeholder('—'),
            ])
            ->defaultSort('remind_at')
            ->headerActions([
                CreateAction::make()
                    ->label('New Reminder'),
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