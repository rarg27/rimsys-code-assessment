<?php

namespace App\Domain\Users\Models;

use App\Domain\Documents\Models\Document;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function documents() : HasMany
    {
        return $this->hasMany(Document::class);
    }
}
