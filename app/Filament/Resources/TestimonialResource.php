<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Media & Sosial Proof';

    protected static ?string $navigationLabel = 'Testimoni';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nama')->required(),
            Forms\Components\TextInput::make('source')->label('Sumber')->placeholder('Google, Instagram, dll.'),
            Forms\Components\Select::make('rating')->label('Rating')->options([5 => '5', 4 => '4', 3 => '3', 2 => '2', 1 => '1']),
            Forms\Components\Select::make('brand_id')->label('Brand')->relationship('brand', 'name')->preload(),
            Forms\Components\Textarea::make('message')->label('Pesan')->rows(3)->required()->columnSpanFull(),
            Forms\Components\FileUpload::make('image_path')->label('Foto (opsional)')->image()->directory('testimonials')->maxSize(2048),
            Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('rating')->label('Rating')->badge(),
                Tables\Columns\TextColumn::make('message')->label('Pesan')->limit(50),
                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name')])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
