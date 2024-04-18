<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Good;
use App\Models\Report;
use App\Models\Report_status;
use App\Models\Report_type;
use App\Services\AdService;
use App\Services\ReportService;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReportController extends BaseController
{
    protected AdService $adService;
    protected ReportService $reportService;

    public function __construct(AdService $adService, ReportService $reportService)
    {
        $this->adService = $adService;
        $this->reportService = $reportService;
    }

    /**
     * @return View|Application
     */
    public function index(): View|Application
    {
        $reports = Report::all();
        $citiesName = City::all();
        $productsName = Good::all();
        $reportStatuses = Report_status::all();
        $reportTypes = Report_type::all();

        return view('avitoParser.index', [
            'reports' => $reports,
            'citiesName' => $citiesName,
            'productsName' => $productsName,
            'reportStatuses' => $reportStatuses,
            'reportTypes' => $reportTypes
        ]);
    }

    /**
     * @param int $id
     * @return Application|View
     */
    public function show(int $id): Application|View
    {
        $data = $this->adService->getAdsAndDetails($id);
        return view('avitoParser.show', $data);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function createNewReport(Request $request): RedirectResponse
    {
        $reportService = new ReportService();
        try {
            if($reportService->defineTypeReportAndStartJob($request)){
                return redirect('/avitoParser')->with('flash_message', 'Report created successfully!');
            } else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Log::error('Error in store method: ' . $exception->getMessage());
            return redirect()->back()->with('error_message', 'Error occurred while creating report!');
        }
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Report::destroy($id);
        return redirect('avitoParser');
    }
}
