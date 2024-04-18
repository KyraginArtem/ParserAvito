<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report_status extends Model
{
    use HasFactory;

    protected $table = 'report_statuses';
    protected $primaryKey = 'id';

    protected $fillable = ['status_name'];

    // Один ко многим
    public function report(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
