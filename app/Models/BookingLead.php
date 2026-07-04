<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingLead extends Model
{
    use SoftDeletes;

    public const STATUSES = ['new', 'contacted', 'confirmed', 'cancelled', 'done'];

    protected $fillable = [
        'name', 'whatsapp_number', 'date', 'time', 'people_count',
        'purpose', 'brand_key', 'notes', 'source_page', 'status', 'internal_note',
    ];

    protected $casts = [
        'date' => 'date',
        'people_count' => 'integer',
    ];
}
