<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserPocket extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'name',
        'balance',
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

    public function incomes()
    {
        return $this->hasMany(Income::class, 'pocket_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'pocket_id');
    }
}