<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactLead extends Model
{
    use SoftDeletes;

    public const STATUSES = ['new', 'contacted', 'done'];

    protected $fillable = [
        'name', 'contact', 'message', 'source_page', 'status', 'internal_note',
    ];
}
