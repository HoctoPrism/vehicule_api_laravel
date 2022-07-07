<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Personne extends Model
{
    use HasFactory;
    protected $fillable = ['firstname', 'lastname'];

    public function TravelList(): BelongsToMany
    {
        return $this->belongstoMany(
            Travel::class,
            'travel_personne',
            'personne',
            'travel'
        );
    }
}
