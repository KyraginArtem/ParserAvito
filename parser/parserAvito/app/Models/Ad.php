<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ad extends Model
{
    use HasFactory;

    protected $table = 'ads';
    protected $primaryKey = 'id';

    protected $fillable = ['product_name_id', 'status_name_id', 'report_id', 'city_name_id', 'title', 'link', 'price', 'description'];

    // Один ко многим
    public function good(): HasMany
    {
        return $this->hasMany(Good::class);
    }

    // Один к одному
    public function adStatus(): HasOne
    {
        return $this->hasOne(Ad_status::class);
    }

    // Один ко многим
    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    // Один ко многим
    public function city(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
