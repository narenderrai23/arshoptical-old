<?php

namespace App\Observers;

use App\Models\SubCategory;
use Illuminate\Support\Facades\Log;

class SubCategoryObserver
{
    /**
     * Handle the SubCategory "created" event.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return void
     */
    public function created(SubCategory $subCategory)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the SubCategory "updated" event.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return void
     */
    public function updated(SubCategory $subCategory)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the SubCategory "deleted" event.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return void
     */
    public function deleted(SubCategory $subCategory)
    {
        $this->clearHomePageCache();
    }

    /**
     * Clear home page cache when subcategory data changes
     */
    private function clearHomePageCache()
    {
        $activeTemplate = activeTemplate();
        $cacheKey = 'home_page_data_' . $activeTemplate;
        $commonCacheKey = 'common_data_' . $activeTemplate;
        
        cache()->forget($cacheKey);
        cache()->forget($commonCacheKey);
        
        // Log cache clearing for debugging
        Log::info('SubCategory cache cleared', [
            'model' => 'SubCategory',
            'cache_keys' => [$cacheKey, $commonCacheKey],
            'timestamp' => now()
        ]);
    }

    /**
     * Handle the SubCategory "restored" event.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return void
     */
    public function restored(SubCategory $subCategory)
    {
        //
    }

    /**
     * Handle the SubCategory "force deleted" event.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return void
     */
    public function forceDeleted(SubCategory $subCategory)
    {
        //
    }
}
