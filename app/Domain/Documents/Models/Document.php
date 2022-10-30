<?php

namespace App\Domain\Documents\Models;

use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Document extends Model
{
    use Mediable;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function attachments()
    {
        return $this->media()->wherePivot('tag', 'attachments');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
