<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Good extends Model
{
    use HasFactory;

    protected $table = 'goods';
    protected $primaryKey = 'id';

    protected $fillable = ['product_name'];

    // Один ко многим
    public function ad(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    // Один к одному
    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }

}
