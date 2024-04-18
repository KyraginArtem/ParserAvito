<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report_type extends Model
{
    use HasFactory;

    protected $table = 'report_types';
    protected $primaryKey = 'id';

    protected $fillable = ['report_name'];

    // Один ко многим
    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
