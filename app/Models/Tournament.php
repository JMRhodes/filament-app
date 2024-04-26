<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'tournaments';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'started_at',
        'ended_at',
        'photo',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(
            Result::class,
            'tournament_id',
            'id'
        );
    }
}
