<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingLeadResource\Pages;
use App\Models\BookingLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingLeadResource extends Resource
{
    protected static ?string $model = BookingLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Leads & WhatsApp';

    protected static ?string $navigationLabel = 'Booking Leads';

    protected static ?string $modelLabel = 'Booking';

    protected static ?int $navigationSort = 1;

    protected static array $statusOptions = [
        'new' => 'Baru',
        'contacted' => 'Dihubungi',
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
        'done' => 'Selesai',
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
            Forms\Components\Section::make('Data Booking')->columns(2)->schema([
                Forms\Components\TextInput::make('name')->label('Nama')->required(),
                Forms\Components\TextInput::make('whatsapp_number')->label('Nomor WhatsApp')->required(),
                Forms\Components\DatePicker::make('date')->label('Tanggal'),
                Forms\Components\TextInput::make('time')->label('Jam'),
                Forms\Components\TextInput::make('people_count')->label('Jumlah orang')->numeric(),
                Forms\Components\TextInput::make('purpose')->label('Keperluan'),
                Forms\Components\Select::make('brand_key')->label('Brand')->options([
                    'pondok-tince' => 'Pondok Tince', 'pempek-tince' => 'Pempek Tince',
                ]),
                Forms\Components\TextInput::make('source_page')->label('Halaman asal')->disabled(),
                Forms\Components\Textarea::make('notes')->label('Catatan customer')->rows(2)->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Follow up (internal)')->columns(2)->schema([
                Forms\Components\Select::make('status')->label('Status')->options(static::$statusOptions)->default('new')->required(),
                Forms\Components\Textarea::make('internal_note')->label('Catatan internal')->rows(2)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('whatsapp_number')->label('WhatsApp')->searchable(),
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('time')->label('Jam'),
                Tables\Columns\TextColumn::make('people_count')->label('Org'),
                Tables\Columns\TextColumn::make('purpose')->label('Keperluan')->toggleable(),
                Tables\Columns\SelectColumn::make('status')->label('Status')->options(static::$statusOptions),
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(static::$statusOptions),
                Tables\Filters\SelectFilter::make('brand_key')->label('Brand')->options([
                    'pondok-tince' => 'Pondok Tince', 'pempek-tince' => 'Pempek Tince',
                ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')
                    ->label('Chat')
                    ->icon('heroicon-o-chat-bubble-oval-left-ellipsis')
                    ->color('success')
                    ->url(fn (BookingLead $r) => 'https://wa.me/'.preg_replace('/\D/', '', (string) $r->whatsapp_number))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingLeads::route('/'),
            'edit' => Pages\EditBookingLead::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
