<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrawlerRequestJobSearchNewAndClosedProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $productsName;
    protected string $citiesName;
    protected int $reportId;
    protected int $productNameId;
    protected int $cityId;
    protected object $baseReport;
    protected ReportService $reportService;
    protected Array $reportDate;

    /**
     * Create a new job instance.
     */
    public function __construct(object $report,object $product,object $city,object $baseReport,
                                ReportService $reportService, $reportData)
    {
        $this->productsName = $product->product_name;
        $this->citiesName = $city->city_name;
        $this->reportId = $report->id;
        $this->productNameId = $product->id;
        $this->cityId = $city->id;
        $this->baseReport = $baseReport;
        $this->reportService = $reportService;
        $this->reportDate = $reportData;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Отправляем данные краулеру
            $response = Http::timeout(6000)->post('http://localhost:3000/crowler', [
                'productName' => $this->productsName,
                'city' => $this->citiesName,
            ]);

            // Получаем ответ от краулера
            $newReportAds = $response->json();

            //передаем новый рапорт
            $newProduct = $this->reportService->findProduct($newReportAds, $this->baseReport, $this->productNameId,
                $this->reportId, $this->cityId, $this->reportDate['reportTypes']);

            if($this->reportDate['reportTypes'] === "Закрытые объявления")
            {
                $statusAd = 2;
            } else
            {
                $statusAd = 1;
            }

            foreach ($newProduct as $item)
            {
                Ad::create([
                    'product_name_id' => $item['product_name_id'],
                    'status_name_id' => $statusAd,
                    'report_id' => $item['report_id'],
                    'city_name_id' => $item['city_name_id'],
                    'title' => $item['title'],
                    'link' => $item['link'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                ]);
            }

            //Меняем статус рапорта
            Report::where('id', $this->reportId)->update(['report_status_id' => 2,
                'report_in_base' => $this->baseReport[0]->id]);

        } catch (\Exception $e) {
            Log::error('Error processing the job: ' . $e->getMessage());
        }
    }
}
