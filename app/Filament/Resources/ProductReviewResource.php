<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductReviewResource\Pages;
use App\Models\ProductReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductReviewResource extends Resource
{
    protected static ?string $model = ProductReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Media & Sosial Proof';

    protected static ?string $navigationLabel = 'Ulasan Produk';

    protected static ?string $modelLabel = 'Ulasan Produk';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('is_approved', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nama')->required(),
            Forms\Components\Select::make('rating')->label('Rating')->options([5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1])->required(),
            Forms\Components\Textarea::make('comment')->label('Komentar')->rows(3)->columnSpanFull(),
            Forms\Components\Toggle::make('is_approved')->label('Disetujui (tampil di website)'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('reviewable.name')->label('Produk')->limit(30)->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('rating')->label('Rating')->badge()
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state)),
                Tables\Columns\TextColumn::make('comment')->label('Komentar')->limit(50)->wrap(),
                Tables\Columns\IconColumn::make('is_approved')->label('Tampil')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')->label('Status')
                    ->trueLabel('Sudah tampil')->falseLabel('Menunggu review'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')->icon('heroicon-o-check')->color('success')
                    ->visible(fn (ProductReview $r) => ! $r->is_approved)
                    ->action(fn (ProductReview $r) => $r->update(['is_approved' => true])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('approveAll')
                    ->label('Setujui terpilih')->icon('heroicon-o-check')->color('success')
                    ->action(fn ($records) => $records->each->update(['is_approved' => true]))
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductReviews::route('/'),
            'edit' => Pages\EditProductReview::route('/{record}/edit'),
        ];
    }
}
