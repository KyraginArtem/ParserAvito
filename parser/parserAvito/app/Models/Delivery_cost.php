<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery_cost extends Model
{
    use HasFactory;

    protected $table = 'delivery_costs';
    protected $primaryKey = 'id';

    protected $fillable = ['departure_city_id', 'destination_city_id', 'price'];

    // Один ко многим
    public function cityDeparture(): HasMany
    {
        return $this->hasMany(City::class);
    }

    // Один к одному
    public function cityDestination(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
