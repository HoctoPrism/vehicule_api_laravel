<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Travel extends Model
{
    use HasFactory;
    protected $fillable = ['lieu'];
    protected $table = "travels";

    public function personnes(): BelongsToMany
    {
        return $this->belongstoMany(
            Personne::class,
            'travel_personne',
            'travel',
            'personne'
        );
    }

    public function vehicules(): BelongsToMany
    {
        return $this->belongstoMany(
            Vehicule::class,
            'travel_vehicule',
            'travel',
            'vehicule'
        );
    }
}
