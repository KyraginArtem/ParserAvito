<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $primaryKey = 'id';

    protected $fillable = ['product_name_id', 'report_type_id', 'report_status_id',
        'city_name_id', 'report_in_base', 'date_request'];

    public function ad(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    // Один к многим
    public function good(): HasMany
    {
        return $this->hasMany(Good::class);
    }

    // Один ко многим
    public function city(): HasMany
    {
        return $this->hasMany(City::class);
    }

    // Один ко одному
    public function reportStatus(): HasOne
    {
        return $this->hasOne(Report_status::class);
    }

    //Один ко одному
    public function reportType(): HasOne
    {
        return $this->hasOne(Report_type::class);
    }
}
