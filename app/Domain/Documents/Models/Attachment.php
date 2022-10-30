<?php

namespace App\Domain\Documents\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Plank\Mediable\Media;

class Attachment extends Media
{
    protected $appends = [
        'version'
    ];

    protected function version() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->order ?? optional($this->pivot)->order
        );
    }
}
