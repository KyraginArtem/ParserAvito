<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad_status extends Model
{
    use HasFactory;

    protected $table = 'ad_statuses';
    protected $primaryKey = 'id';

    protected $fillable = ['status_name'];

    // Один ко многим
    public function ad(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

}
