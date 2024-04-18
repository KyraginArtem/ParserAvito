<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\City;
use App\Models\Good;

class AdService
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getAdsAndDetails(int $id): array
    {
        $ads = Ad::where('report_id', $id)->get();
        if($ads->isEmpty())
        {
            $reportDetails = $this->reportService->getReportDetails($id);
            $city = $this->getCityName($reportDetails['reportCityNameId']);
            $productName = $this->getProductName($reportDetails['reportProductNameId']);

            return [
                'city' => $city,
                'productName' => $productName,
                'reportType' => $reportDetails['reportType'],
                'reportDate' => $reportDetails['reportDate'],
                'id' => $id,
            ];
        } else
        {
            $reportDetails = $this->reportService->getReportDetails($id);
            $city = $this->getCityName($reportDetails['reportCityNameId']);
            $productName = $this->getProductName($reportDetails['reportProductNameId']);
            return [
                'ads' => $ads,
                'city' => $city,
                'productName' => $productName,
                'reportType' => $reportDetails['reportType'],
                'reportDate' => $reportDetails['reportDate'],
                'id' => $id,
            ];
        }
    }

    /**
     * @param int $cityId
     * @return mixed
     */
    protected function getCityName(int $cityId): mixed
    {
        return City::where('id', $cityId)->value('city_name');
    }

    /**
     * @param int $productNameId
     * @return mixed
     */
    protected function getProductName(int $productNameId): mixed
    {
        return Good::where('id', $productNameId)->value('product_name');
    }
}

