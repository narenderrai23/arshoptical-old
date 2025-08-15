<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function created(Brand $brand)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Brand "updated" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function updated(Brand $brand)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Brand "deleted" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function deleted(Brand $brand)
    {
        $this->clearHomePageCache();
    }

    /**
     * Clear home page cache when brand data changes
     */
    private function clearHomePageCache()
    {
        $activeTemplate = activeTemplate();
        $cacheKey = 'home_page_data_' . $activeTemplate;
        $commonCacheKey = 'common_data_' . $activeTemplate;
        
        cache()->forget($cacheKey);
        cache()->forget($commonCacheKey);
        
        // Log cache clearing for debugging
        Log::info('Brand cache cleared', [
            'model' => 'Brand',
            'cache_keys' => [$cacheKey, $commonCacheKey],
            'timestamp' => now()
        ]);
    }

    /**
     * Handle the Brand "restored" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function restored(Brand $brand)
    {
        //
    }

    /**
     * Handle the Brand "force deleted" event.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    public function forceDeleted(Brand $brand)
    {
        //
    }
}
