<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactLeadResource\Pages;
use App\Models\ContactLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactLeadResource extends Resource
{
    protected static ?string $model = ContactLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Leads & WhatsApp';

    protected static ?string $navigationLabel = 'Contact Leads';

    protected static ?string $modelLabel = 'Pesan Kontak';

    protected static ?int $navigationSort = 2;

    protected static array $statusOptions = [
        'new' => 'Baru', 'contacted' => 'Dihubungi', 'done' => 'Selesai',
    ];

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nama')->required(),
            Forms\Components\TextInput::make('contact')->label('Kontak (WA/email)')->required(),
            Forms\Components\Textarea::make('message')->label('Pesan')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('source_page')->label('Halaman asal')->disabled(),
            Forms\Components\Select::make('status')->label('Status')->options(static::$statusOptions)->default('new'),
            Forms\Components\Textarea::make('internal_note')->label('Catatan internal')->rows(2)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('contact')->label('Kontak')->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Pesan')->limit(50),
                Tables\Columns\SelectColumn::make('status')->label('Status')->options(static::$statusOptions),
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(static::$statusOptions),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactLeads::route('/'),
            'edit' => Pages\EditContactLead::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
