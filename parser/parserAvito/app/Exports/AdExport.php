<?php

namespace App\Exports;

use App\Models\Ad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdExport implements FromCollection
{

    protected int $reportId;

    public function __construct(int $reportId)
    {
        $this->reportId = $reportId;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Ad::where('report_id', $this->reportId)->get();
    }
}
