<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\BookingLead;
use App\Models\ContactLead;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\WhatsappClickLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Halaman terbit', Page::where('is_published', true)->count())
                ->icon('heroicon-o-document-text')->color('primary'),
            Stat::make('Menu aktif', MenuItem::where('is_available', true)->count())
                ->icon('heroicon-o-cake')->color('success'),
            Stat::make('Booking leads', BookingLead::count())
                ->description(BookingLead::where('status', 'new')->count().' baru')
                ->icon('heroicon-o-calendar-days')->color('warning'),
            Stat::make('Contact leads', ContactLead::count())
                ->description(ContactLead::where('status', 'new')->count().' baru')
                ->icon('heroicon-o-inbox')->color('warning'),
            Stat::make('Klik WhatsApp', WhatsappClickLog::count())
                ->description('7 hari: '.WhatsappClickLog::where('created_at', '>=', now()->subDays(7))->count())
                ->icon('heroicon-o-cursor-arrow-ripple')->color('success'),
            Stat::make('Artikel terbit', Article::where('is_published', true)->count())
                ->icon('heroicon-o-newspaper')->color('primary'),
        ];
    }
}
