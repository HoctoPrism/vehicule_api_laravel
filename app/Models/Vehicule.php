<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicule extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'image'];

    public function types(): BelongsTo
    {
        return $this->BelongsTo(Type::class, 'type');
    }

    public function TravelList(): BelongsToMany
    {
        return $this->belongstoMany(
            Travel::class,
            'travel_personne',
            'vehicule',
            'travel'
        );
    }
}
