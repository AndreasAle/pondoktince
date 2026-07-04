<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Pengaturan Website';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make()->tabs([

                    Forms\Components\Tabs\Tab::make('Identitas')->schema([
                        Forms\Components\TextInput::make('site_name')->label('Nama website')->required(),
                        Forms\Components\TextInput::make('tagline')->label('Tagline'),
                        Forms\Components\FileUpload::make('logo_path')->label('Logo')->image()->directory('site')->maxSize(2048),
                        Forms\Components\TextInput::make('logo_height')
                            ->label('Tinggi logo (header)')
                            ->numeric()
                            ->minValue(24)->maxValue(160)->step(2)
                            ->default(48)
                            ->suffix('px')
                            ->helperText('Atur tinggi logo di header. Lebar menyesuaikan otomatis. Umumnya 40–80px.'),
                        Forms\Components\FileUpload::make('favicon_path')->label('Favicon')->image()->directory('site')->maxSize(1024),
                        Forms\Components\FileUpload::make('default_og_image_path')->label('Default OG image')->image()->directory('site')->maxSize(4096),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\ColorPicker::make('primary_color')->label('Warna utama'),
                            Forms\Components\ColorPicker::make('accent_color')->label('Warna aksen'),
                        ]),
                    ]),

                    Forms\Components\Tabs\Tab::make('Kontak & Lokasi')->schema([
                        Forms\Components\Textarea::make('address')->label('Alamat')->rows(2),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('email')->label('Email')->email(),
                            Forms\Components\TextInput::make('whatsapp_number')->label('WhatsApp Pondok Tince')
                                ->helperText('Format 628xxxx tanpa +'),
                            Forms\Components\TextInput::make('whatsapp_number_pempek')->label('WhatsApp Pempek Tince'),
                        ]),
                        Forms\Components\Textarea::make('maps_embed')->label('Google Maps embed (iframe src)')->rows(2)
                            ->helperText('Tempel URL "src" dari embed Google Maps.'),
                        Forms\Components\TextInput::make('maps_link')->label('Link Google Maps'),
                        Forms\Components\Repeater::make('opening_hours')->label('Jam buka')
                            ->schema([
                                Forms\Components\TextInput::make('day')->label('Hari')->placeholder('Senin - Minggu'),
                                Forms\Components\TextInput::make('hours')->label('Jam')->placeholder('10.00 - 22.00'),
                            ])
                            ->columns(2)->defaultItems(0)->addActionLabel('Tambah baris jam'),
                    ]),

                    Forms\Components\Tabs\Tab::make('Sosial Media')->schema([
                        Forms\Components\TextInput::make('instagram_pondok')->label('Instagram Pondok Tince')->url(),
                        Forms\Components\TextInput::make('instagram_pempek')->label('Instagram Pempek Tince')->url(),
                    ]),

                    Forms\Components\Tabs\Tab::make('SEO & Script')->schema([
                        Forms\Components\TextInput::make('default_seo_title')->label('Default SEO title'),
                        Forms\Components\Textarea::make('default_seo_description')->label('Default SEO description')->rows(2),
                        Forms\Components\TextInput::make('google_site_verification')->label('Google Search Console verification'),
                        Forms\Components\Textarea::make('head_scripts')->label('Script tambahan (head)')->rows(3)
                            ->helperText('mis. Google Analytics / Pixel. Hati-hati, disisipkan mentah ke <head>.'),
                    ]),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        SiteSetting::current()->update($data);
        SiteSetting::flushCache();

        Notification::make()->title('Pengaturan disimpan')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')->label('Simpan')->submit('save'),
        ];
    }
}
