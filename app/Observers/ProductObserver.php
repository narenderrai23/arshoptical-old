<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $this->clearHomePageCache();
    }

    /**
     * Clear home page cache when product data changes
     */
    private function clearHomePageCache()
    {
        $activeTemplate = activeTemplate();
        $cacheKey = 'home_page_data_' . $activeTemplate;
        $commonCacheKey = 'common_data_' . $activeTemplate;
        
        cache()->forget($cacheKey);
        cache()->forget($commonCacheKey);
        
        // Log cache clearing for debugging
        Log::info('Product cache cleared', [
            'model' => 'Product',
            'cache_keys' => [$cacheKey, $commonCacheKey],
            'timestamp' => now()
        ]);
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
