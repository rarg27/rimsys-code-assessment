<?php

namespace App\Domain\Documents\Models;

use App\Domain\Users\Models\User;
use Database\Factories\DocumentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Document extends Model
{
    use HasFactory,
        Mediable;

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected static function newFactory()
    {
        return DocumentFactory::new();
    }

    public function attachments()
    {
        return $this->media()->wherePivot('tag', 'attachments');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, string $keyWord)
    {
        return $query->orWhere('name', 'like', "%$keyWord")
            ->orWhere('name', 'like', "$keyWord%")
            ->orWhere('name', 'like', "%$keyWord%");
    }
}
