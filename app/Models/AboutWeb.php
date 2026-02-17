<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutWeb extends Model
{
    protected $fillable = [
        'title',
        'description',
        'vision',
        'mission',
    ];
}
