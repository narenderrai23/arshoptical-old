<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\PageObserver;
use App\Observers\ProductObserver;
use App\Observers\ReviewObserver;
use App\Observers\SubCategoryObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        // $this->app['request']->server->set('HTTPS', true);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $activeTemplate                  = activeTemplate();
        $general                         = GeneralSetting::first();
        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language']           = Language::all();
        $viewShare['pages']              = Page::where('tempname', $activeTemplate)->where('is_default', 0)->get();
        $viewShare['categories']         = Category::active()->with('subcategories', 'product')->get();
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count'           => User::banned()->count(),
                'email_unverified_users_count' => User::emailUnverified()->count(),
                'sms_unverified_users_count'   => User::smsUnverified()->count(),
                'pending_ticket_count'         => SupportTicket::whereIN('status', [0, 2])->count(),
                'pending_deposits_count'       => Deposit::pending()->count(),
                'pending_withdraw_count'       => Withdrawal::pending()->count(),
                'pending_order_count'          => Order::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->get(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }

        // Register model observers for automatic cache clearing
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        Brand::observe(BrandObserver::class);
        Page::observe(PageObserver::class);
        SubCategory::observe(SubCategoryObserver::class);
        Review::observe(ReviewObserver::class);

        Paginator::useBootstrap();

        // Polyfill for IDE tools expecting newer Blade methods on Laravel 8
        $blade = $this->app->make('blade.compiler');
        if (!method_exists($blade, 'getAnonymousComponentNamespaces')) {
            // Method doesn't exist in Laravel 8, skip polyfill
        }
        if (!method_exists($blade, 'getAnonymousComponentPaths')) {
            // Method doesn't exist in Laravel 8, skip polyfill
        }
    }

}
