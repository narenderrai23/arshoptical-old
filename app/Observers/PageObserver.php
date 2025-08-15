<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Facades\Log;

class PageObserver
{
    /**
     * Handle the Page "created" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function created(Page $page)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Page "updated" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function updated(Page $page)
    {
        $this->clearHomePageCache();
    }

    /**
     * Handle the Page "deleted" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function deleted(Page $page)
    {
        $this->clearHomePageCache();
    }

    /**
     * Clear home page cache when page data changes
     */
    private function clearHomePageCache()
    {
        $activeTemplate = activeTemplate();
        $cacheKey = 'home_page_data_' . $activeTemplate;
        $commonCacheKey = 'common_data_' . $activeTemplate;
        
        cache()->forget($cacheKey);
        cache()->forget($commonCacheKey);
        
        // Log cache clearing for debugging
        Log::info('Page cache cleared', [
            'model' => 'Page',
            'cache_keys' => [$cacheKey, $commonCacheKey],
            'timestamp' => now()
        ]);
    }

    /**
     * Handle the Page "restored" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function restored(Page $page)
    {
        //
    }

    /**
     * Handle the Page "force deleted" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function forceDeleted(Page $page)
    {
        //
    }
}
