<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;
    protected $table = 'players';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'salary',
        'photo',
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
}
