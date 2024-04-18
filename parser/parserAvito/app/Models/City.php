<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primaryKey = 'id';

    protected $fillable = ['city_name'];

    // Один ко многим
    public function deliveryCost(): HasMany
    {
        return $this->hasMany(Delivery_cost::class);
    }

    public function ad(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }

}
