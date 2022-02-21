<?php

namespace App\Jobs;

use App\Services\NewsApiService;
use App\Services\NewsContentService;
use App\Services\NewsContentSourceService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class NewsJob extends Job
{

    private $data = ['Bitcoin', 'Litecoin', 'Ripple', 'Dash', 'Ethereum'];
    private $page = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->page = config('news.query.page');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = collect($this->data)->map(function ($item) {
            $data = $this->getNews($item);
            $data['theme'] = $item;
            return $this->setNews($data);
        });
        Log::info(json_encode($data));
    }

    private function getNews($item, $page = 1): array
    {
        $apiService = App::make(NewsApiService::class);
        $result = $apiService->get($item, $page);
        $filtered = collect($result)->keyBy(function ($value, $key) {
            if ($key == 'urlToImage') {
                return 'image';
            } elseif ($key == 'publishedAt') {
                return 'published';
            } else {
                return $key;
            }
        });

        return $filtered->toArray();
    }

    private function setNews($data): bool
    {
        $newsContentService = App::make(NewsContentService::class);
        $newsContentSourceService = App::make(NewsContentSourceService::class);
        $source = $newsContentSourceService->store(['source' => $data['source']->name]);
        $data['source_id'] = $source;
        $content = $newsContentService->store($data);
        if (!$content->wasRecentlyCreated) {
            if ($this->page < 100) {
                $this->page += 1;
                $content = $this->getNews($data['theme'], $this->page);
                $content['theme'] = $data['theme'];
                $this->setNews($content);
            }
        }
        return true;
    }
}
