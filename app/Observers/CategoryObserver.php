<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $this->clearHomePageCache();
    }

    /**
     * Clear home page cache when category data changes
     */
    private function clearHomePageCache()
    {
        $activeTemplate = activeTemplate();
        $cacheKey = 'home_page_data_' . $activeTemplate;
        $commonCacheKey = 'common_data_' . $activeTemplate;
        
        cache()->forget($cacheKey);
        cache()->forget($commonCacheKey);
        
        // Log cache clearing for debugging
        Log::info('Category cache cleared', [
            'model' => 'Category',
            'cache_keys' => [$cacheKey, $commonCacheKey],
            'timestamp' => now()
        ]);
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
