<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Page
{
    protected static ?string $navigationLabel = null;
    protected static bool $shouldRegisterNavigation = false;
    protected string $view = 'filament.admin.pages.change-password';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->confirmed(),
                TextInput::make('password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        auth()->user()->update([
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
            'must_change_password' => false, // tandai sudah "verified" setelah ganti password
        ]);

        $this->redirect(route('filament.admin.pages.dashboard'));
    }
}