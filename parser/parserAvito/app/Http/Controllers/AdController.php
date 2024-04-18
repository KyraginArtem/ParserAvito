<?php

namespace App\Http\Controllers;

use App\Exports\AdExport;
use App\Models\Ad;
use App\Models\City;
use App\Models\Good;
use App\Services\ReportService;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdController extends BaseController
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

        public function wordSearch(Request $request, int $report_id): View|Application
        {
        $wordSearch = $request->input('wordSearch');
        $foundAds = Ad::where('report_id', $report_id)->where('description', 'like', "%{$wordSearch}%")->get();

        $reportDetails = $this->reportService->getReportDetails($report_id);
        $report = [
            'report_id' => $report_id,
            'product_name' => Good::where('id', $reportDetails['reportProductNameId'])->value('product_name'),
            'city_name' => City::where('id', $reportDetails['reportCityNameId'])->value('city_name'),
            'report_type' => $reportDetails['reportType'],
            'date_request' => $reportDetails['reportDate'],
        ];

        return view('avitoParser.wordSearch', ['foundAds' => $foundAds ,
            'report' => $report,
            'wordSearch' => $wordSearch]);
    }

    public function export(int $id): BinaryFileResponse
    {
        return Excel::download(new AdExport($id), 'Рапорт №'.$id.'.xlsx');
    }
}
