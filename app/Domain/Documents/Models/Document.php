<?php

namespace App\Domain\Documents\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'user_id'
    ];
}
