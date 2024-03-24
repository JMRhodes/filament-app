<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model {
    use HasFactory;

    protected $table = 'players';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'salary',
        'photo',
    ];

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute(): string {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function teams(): BelongsToMany {
        return $this->belongsToMany(
            Team::class,
            'teams_players',
            'player_id',
            'team_id'
        );
    }

    public function results(): HasMany {
        return $this->hasMany(
            Result::class,
            'player_id',
            'id'
        );
    }
}
