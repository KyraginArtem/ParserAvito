<?php

namespace App\Services;

use App\Jobs\CrawlerRequestJobSearchNewAndClosedProducts;
use App\Jobs\CrawlerRequestJobSelectionByNewReport;
use App\Models\Ad;
use App\Models\City;
use App\Models\Good;
use App\Models\Report;
use App\Models\Report_type;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ReportService
{
    /**
     * @param array $data
     * @return array
     */
    public function createReport(array $data): array
    {
        $productName = $data['productsName'];
        $cityName = $data['citiesName'];
        $reportTypeName = $data['reportTypes'];

        $product = Good::firstOrCreate(['product_name' => $productName]);
        $city = City::firstOrCreate(['city_name' => $cityName]);
        $reportType = Report_type::firstOrCreate(['report_name' => $reportTypeName]);

        $report = Report::create([
            'product_name_id' => $product->id,
            'city_name_id' => $city->id,
            'report_status_id' => 1,
            'report_type_id' => $reportType->id,
            'report_in_base' => 0,
            'date_request' => now(),
        ]);
        info('Создали рапорт');
        return [
            'report' => $report,
            'product' => $product,
            'city' => $city
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getReportDetails(int $id): array
    {
        $report = Report::findOrFail($id);
        $reportTypeId = $report->report_type_id;
        $reportProductNameId = $report->product_name_id;
        $reportStatusId = $report->report_status_id;
        $reportCityNameId = $report->city_name_id;
        $reportType = Report_type::where('id', $reportTypeId)->value('report_name');
        $reportDate = $report->date_request;

        return [
            'reportType' => $reportType,
            'reportDate' => $reportDate,
            'reportProductNameId' => $reportProductNameId,
            'reportStatusId' => $reportStatusId,
            'reportCityNameId' => $reportCityNameId,
            'report_in_base' => $report->report_in_base,
        ];
    }

    /**
     * @param $newReportAds
     * @param $baseReport
     * @param $productNameId
     * @param $reportId
     * @param $cityId
     * @return Collection
     */
    public function findProduct(array $newReportAds,object $baseReport,int $productNameId,
                                int $reportId,int $cityId,string $reportType): Collection
    {
        $result = collect();
        $comparisonList = [];
        try
        {
            if($reportType === 'Поиск новых товаров')
            {
                $searchList = Ad::where('report_id', $baseReport[0]->id)->pluck('link')->toArray();

                foreach ($newReportAds as $item)
                {
                    foreach ($item as $value)
                    {
                        $comparisonList[] = $value;
                    }

                }
            } else {
                $searchList = [];
                foreach ($newReportAds as $value)
                {
                    foreach ($value as $item)
                    {
                        $searchList[] = $item['link'];
                    }
                }
                $comparisonList = Ad::where('report_id', $baseReport[0]->id)->get();
            }

            foreach ($comparisonList as $value) {
                if(!in_array($value['link'], $searchList))
                {
                    $result->push([
                        'product_name_id' => $productNameId,
                        'status_name_id' => 1,
                        'report_id' => $reportId,
                        'city_name_id' => $cityId,
                        'title' => $value['title'],
                        'link' => $value['link'],
                        'price' => $value['price'],
                        'description' => $value['description'],
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error processing the job: ' . $e->getMessage());
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function defineTypeReportAndStartJob(Request $request) : bool
    {
        $reportData = $request->validate([
            'productsName' => 'required|string',
            'citiesName' => 'required|string',
            'reportTypes' => 'required|string',
        ]);

        $reportInBase = Report::where('id', $request->input('reportNumberBase'))->get();

        if($request->input('reportTypes') === "Выборка по наименованию")
        {
            $result = $this->createReport($reportData);
            info('Создаем Job');
            CrawlerRequestJobSelectionByNewReport::dispatch($result['report'], $result['product'], $result['city']);
            return true;
        }
        elseif ($request->input('reportTypes') === "Новые товары" ||
            $request->input('reportTypes') === "Закрытые объявления")
        {
            if($request->input('reportNumberBase') === null)
            {
                Session::flash('message', 'Необходимо ввести номер отчета.');
                return false;
            }
            //------------------//
            if ($reportInBase->isEmpty())
            {
                Session::flash('message', 'Необходимо ввести номер существующего отчета.');
                return false;
            }
            //------------------//
            $productBaseReport = Good::where('id', $reportInBase[0]->product_name_id)->value('product_name');
            $cityBaseReport = City::where('id', $reportInBase[0]->city_name_id)->value('city_name');
            $nameBaseReport = Report_type::where('id', $reportInBase[0]->report_type_id)->value('report_name');

            if (($productBaseReport !== $reportData['productsName']) ||
                ($cityBaseReport !== $reportData['citiesName']) || ($nameBaseReport !== 'Выборка по наименованию'))
            {
                Session::flash('message', 'Название города и наименование товара должны быть идентичными. Тип отчета Выборка по наименованию');
                return false;
            }
            else
            {
                $result = $this->createReport($reportData);
                $reportService = new ReportService();
                CrawlerRequestJobSearchNewAndClosedProducts::dispatch(
                    $result['report'], $result['product'], $result['city'], $reportInBase, $reportService, $reportData);
                return true;
            }
        }
        return false;
    }
}
