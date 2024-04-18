<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\Report;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrawlerRequestJobSelectionByNewReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $productsName;
    protected string $citiesName;
    protected int $reportId;
    protected int $productNameId;
    protected int $cityId;

    public function __construct(object $report,object $product,object $city)
    {
        $this->productsName = $product->product_name;
        $this->citiesName = $city->city_name;
        $this->reportId = $report->id;
        $this->productNameId = $product->id;
        $this->cityId = $city->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            // Отправляем данные краулеру
            $response = Http::timeout(6000)->post('http://localhost:3000/crowler', [
                'productName' => $this->productsName,
                'city' => $this->citiesName,
            ]);

            // Получаем ответ от краулера
            $crawlerResponse = $response->json();

            info('Получили данные записываем данные');
            //Пишем в БД
            foreach ($crawlerResponse as $value) {
                foreach ($value as $item){

                    Ad::create([
                        'product_name_id' => $this->productNameId,
                        'status_name_id' => 1,
                        'report_id' => $this->reportId,
                        'city_name_id' => $this->cityId,
                        'title' => $item['title'],
                        'link' => $item['link'],
                        'price' => $item['price'],
                        'description' => $item['description'],
                    ]);
                }
            }
            //Меняем статус рапорта
            Report::where('id', $this->reportId)->update(['report_status_id' => 2]);

        } catch (Exception $e) {
            Log::error('Error processing the job: ' . $e->getMessage());
        }
    }
}
