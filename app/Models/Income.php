<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Income extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'pocket_id',
        'amount',
        'notes',
    ];

    protected static function booted(): void
    {
        static::creating(fn ($model) =>
            $model->id ??= (string) Str::uuid()
        );
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pocket()
    {
        return $this->belongsTo(UserPocket::class, 'pocket_id');
    }
}