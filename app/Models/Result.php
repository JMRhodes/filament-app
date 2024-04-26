<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'tournament_id',
        'player_id',
        'points',
        'position',
    ];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(
            Player::class,
            'results',
            'id',
            'player_id');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
