<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Order;
use App\Models\Blogs;
use App\Models\OrderDetail;
use App\Models\Page;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    protected string $activeTemplate;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
        
        // Share common data across all views
        view()->composer('*', function ($view) {
            try {
                // Cache common data that's used across multiple views
                $commonData = cache()->remember('common_data_' . $this->activeTemplate, 1440, function () { // Cache for 24 hours
                    try {
                        return [
                            'siteSettings' => GeneralSetting::first(['sitename', 'base_color', 'cur_text', 'cur_sym']),
                            'language' => Language::orderBy('is_default', 'desc')->get(['id', 'code', 'name']),
                        ];
                    } catch (\Exception $e) {
                        Log::error('Language query error: ' . $e->getMessage());
                        return [
                            'siteSettings' => null,
                            'language' => collect([]),
                        ];
                    }
                });
                
                $view->with($commonData);
            } catch (\Exception $e) {
                // Log error but don't break the view
                Log::error('View composer error: ' . $e->getMessage());
                
                // Provide fallback data
                $view->with([
                    'siteSettings' => null,
                    'languages' => collect([])
                ]);
            }
        });
    }

    public function index()
    {
        $pageTitle = 'Home';
        
        // Cache frequently accessed data for better performance (24-hour cache)
        $cacheKey = 'home_page_data_' . $this->activeTemplate;
        
        $data = cache()->remember($cacheKey, 1440, function () { // Cache for 24 hours
            return [
                'sections' => Page::where('tempname', $this->activeTemplate)
                    ->where('slug', 'home')
                    ->select('id', 'tempname', 'slug', 'secs') // Select only needed fields
                    ->first(),
                    
                'todayDealProducts' => Product::active()
                    ->where('today_deals', 1)
                    ->select('id', 'name', 'image', 'price', 'discount', 'status', 'today_deals') // Select only needed fields
                    ->with(['category:id,name,status', 'brand:id,name,status'])
                    ->latest()
                    ->take(8)
                    ->get(),
                    
                'cats' => Category::active()
                    ->where('featured', 1)
                    ->select('id', 'name', 'image', 'status', 'featured', 'orderno') // Select only needed fields
                    ->with(['subcategories' => function($query) {
                        $query->select('id', 'category_id', 'name', 'status')
                              ->where('status', 1);
                    }])
                    ->orderBy('orderno')
                    ->take(6)
                    ->get(),
                    
                'categories' => Category::active()
                    ->select('id', 'name', 'image', 'status', 'orderno') // Select only needed fields
                    ->with(['subcategories' => function($query) {
                        $query->select('id', 'category_id', 'name', 'status')
                              ->where('status', 1);
                    }])
                    ->orderBy('orderno')
                    ->get(),
                    
                'brands' => Brand::where('status', 1)
                    ->where('featured', 1)
                    ->select('id', 'name', 'image', 'status', 'featured') // Select only needed fields
                    ->latest()
                    ->take(2)
                    ->get(),
                    
                'products' => Product::active()
                    ->where('hot_deals', 1)
                    ->select('id', 'name', 'image', 'price', 'discount', 'status', 'hot_deals') // Select only needed fields
                    ->with(['category:id,name,status', 'brand:id,name,status'])
                    ->latest()
                    ->with(['reviews' => function($query) {
                        $query->select('id', 'product_id', 'stars')
                              ->where('stars', '>', 0); // Only get reviews with stars
                    }])
                    ->take(6)
                    ->get()
            ];
        });
        
        return view($this->activeTemplate . 'home', array_merge(
            ['pageTitle' => $pageTitle], 
            $data
        ));
    }

    /**
     * Clear home page cache when data is updated (24-hour cache)
     */
    private function clearHomePageCache()
    {
        $cacheKey = 'home_page_data_' . $this->activeTemplate;
        cache()->forget($cacheKey);
    }

    /**
     * Clear all caches (useful for admin operations)
     */
    public function clearAllCaches()
    {
        $this->clearHomePageCache();
        
        // Clear common data cache
        $commonCacheKey = 'common_data_' . $this->activeTemplate;
        cache()->forget($commonCacheKey);
        
        // Clear other related caches
        cache()->forget('products_cache');
        cache()->forget('categories_cache');
        cache()->forget('brands_cache');
        
        // Clear any other potential cache keys
        $cacheKeys = [
            'home_page_data_*',
            'common_data_*',
            'products_cache',
            'categories_cache',
            'brands_cache',
            'featured_products',
            'hot_deals_products',
            'today_deals_products',
            'featured_categories',
            'featured_brands'
        ];
        
        foreach ($cacheKeys as $key) {
            if (str_contains($key, '*')) {
                // Handle wildcard keys
                $pattern = str_replace('*', '', $key);
                $keys = cache()->get('cache_keys', []);
                foreach ($keys as $cacheKey) {
                    if (str_contains($cacheKey, $pattern)) {
                        cache()->forget($cacheKey);
                    }
                }
            } else {
                cache()->forget($key);
            }
        }
        
        return response()->json(['success' => 'All caches cleared successfully']);
    }

    public function pages($slug)
    {
        $page      = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = ['jpg', 'png', 'jpeg', 'pdf'];

        $this->validate($request, [
            'name'    => 'required|max:191',
            'email'   => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = 2;

        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = 0;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                   = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message          = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->back()->withNotify($notify);
    }

    public function about()
    {
        $pageTitle = "About Us";
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'about-us')->first();
        return view($this->activeTemplate . 'about', compact('pageTitle', 'sections'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();

        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function cookieAccept()
    {
        session()->put('cookie_accepted', true);
        return response('Cookie accepted successfully');
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;

        // Prefer font from public/assets/font; gracefully fallback if missing
        $fontPath = public_path('assets/font/RobotoMono-Regular.ttf');
        $fontAvailable = is_string($fontPath) && file_exists($fontPath);

        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }

        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);

        $canUseTtf = $fontAvailable && function_exists('imagettfbbox') && function_exists('imagettftext');

        header('Content-Type: image/jpeg');
        if ($canUseTtf) {
            $textBox    = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth  = abs($textBox[4] - $textBox[0]);
            $textHeight = abs($textBox[5] - $textBox[1]);
            $textX      = ($imgWidth - $textWidth) / 2;
            $textY      = ($imgHeight + $textHeight) / 2;
            imagettftext($image, $fontSize, 0, (int)$textX, (int)$textY, $colorFill, $fontPath, $text);
        } else {
            // Fallback to built-in GD font when TTF is unavailable
            $gdFont     = 5;
            $textWidth  = imagefontwidth($gdFont) * strlen($text);
            $textHeight = imagefontheight($gdFont);
            $textX      = (int)(($imgWidth - $textWidth) / 2);
            $textY      = (int)(($imgHeight - $textHeight) / 2);
            imagestring($image, $gdFont, $textX, $textY, $text, $colorFill);
        }

        imagejpeg($image);
        imagedestroy($image);
    }

    public function pageDetails($id, $slug)
    {
        $page      = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $page->data_values->title;
        return view($this->activeTemplate . 'policy_pages', compact('page', 'pageTitle'));
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $emailExist = Subscriber::where('email', $request->mobile)->first();

        if (!$emailExist) {
            $subscribe        = new Subscriber();
            $subscribe->email = $request->mobile;
            $subscribe->save();
            return response()->json(['success' => 'Subscribed Successfully']);
        } else {
            return response()->json(['error' => 'Already Subscribed']);
        }
    }

    public function allCategory()
    {
        $pageTitle    = 'All Categories';
        $emptyMessage = 'No category found';
        $categoryList = Category::where('status', 1)
            ->with(['subcategories' => function($query) {
                $query->select('id', 'category_id', 'name', 'status')
                      ->where('status', 1);
            }])
            ->orderBy('name')
            ->paginate(getPaginate());
        return view($this->activeTemplate . 'all_category', compact('pageTitle', 'emptyMessage', 'categoryList'));
    }

    public function allBrands()
    {
        $pageTitle    = 'All Brands';
        $emptyMessage = 'No brand found';
        $brands       = Brand::where('status', 1)->orderBy('name')->paginate(getPaginate());
        return view($this->activeTemplate . 'all_brands', compact('pageTitle', 'emptyMessage', 'brands'));
    }

    public function products(Request $request)
    {

        $pageTitle    = 'All Products';
        $emptyMessage = 'No product found';

        $products = Product::active()->with('reviews');

        if ($request->route()->getName() == 'hot_deals.products') {
            $pageTitle = 'Hot Deal Products';
            $products  = $products->where('hot_deals', 1);
        }

        if ($request->route()->getName() == 'featured.products') {
            $pageTitle = 'Featured Products';
            $products  = $products->where('featured_product', 1);
        }

        if ($request->route()->getName() == 'best-selling.products') {
            $pageTitle = 'Best Selling Products';

            $products = $products->where('sale_count', '!=', 0)->orderBy('sale_count', 'desc');
        }

        if ($request->search) {
            $pageTitle     = 'Search Results';
            $searchKeyword = $request->search;
            $products      = $products->where(function ($q) use ($searchKeyword) {
                $q->orWhere('description', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('features', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('summary', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('model_no', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('product_sku', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('name', 'LIKE', '%' . $searchKeyword . '%')->orWhereHas('category', function ($category) use ($searchKeyword) {
                        $category->where('name', 'like', "%$searchKeyword%");
                    })->orWhereHas('subcategory', function ($subcategory) use ($searchKeyword) {
                        $subcategory->where('name', 'like', "%$searchKeyword%");
                    })->orWhereHas('brand', function ($brand) use ($searchKeyword) {
                        $brand->where('name', 'like', "%$searchKeyword%");
                    });
            });
        }

        $cloneProducts = clone $products;
        $minPrice      = $cloneProducts->min('price') ?? 0;
        $maxPrice      = $cloneProducts->max('price') ?? 0;

        $categoryArray = [];
        $brandArray    = [];

        foreach ($products->get() as $product) {
            $categoryArray[] = $product->category_id;
            $brandArray[]    = $product->brand_id;
        }

        $categoryId = array_unique($categoryArray);
        $brandId    = array_unique($brandArray);


        $categoryList = Category::whereIn('id', $categoryId)
            ->where('status', 1)
            ->with(['subcategories' => function($query) {
                $query->select('id', 'category_id', 'name', 'status')
                      ->where('status', 1);
            }])
            ->withCount('product')
            ->get();
        $brands       = Brand::whereIn('id', $brandId)->where('status', 1)->withCount('product')->get();
        $products     = $products->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'products.all', compact('pageTitle', 'products', 'brands', 'minPrice', 'maxPrice', 'emptyMessage', 'categoryList'));
    }

    public function productsFilter(Request $request)
    {

        $productList = Product::active()->with('reviews');

        if ($request->route == 'hot_deals.products') {
            $productList = $productList->where('hot_deals', 1);
        }

        if ($request->route == 'featured.products') {
            $productList = $productList->where('featured_product', 1);
        }

        if ($request->route == 'best-selling.products') {
            $productList = $productList->where('sale_count', '!=', 0)->orderBy('sale_count', 'desc');
        }

        if ($request->search) {
            $searchKeyword = $request->search;
            $productList   = $productList->where(function ($q) use ($searchKeyword) {
                $q->orWhere('description', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('features', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('summary', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('name', 'LIKE', '%' . $searchKeyword . '%')->orWhereHas('category', function ($query) use ($searchKeyword) {
                        $query->where('name', 'like', "%$searchKeyword%");
                    })->orWhereHas('subcategory', function ($query) use ($searchKeyword) {
                        $query->where('name', 'like', "%$searchKeyword%");
                    })->orWhereHas('brand', function ($query) use ($searchKeyword) {
                        $query->where('name', 'like', "%$searchKeyword%");
                    });
            });
        }


        if ($request->brandId) {
            $productList = $productList->where('brand_id', $request->brandId);
        }

        if ($request->categoryId) {

            if ($request->categoryId != 0) {
                $productList   = $productList->where('category_id', $request->categoryId);
                $productFilter = $this->subcategoriesQuery($productList, $request);
            }
        } else {
            $productFilter = $this->categoriesQuery($productList, $request);
        }

        if ($request->subcategoryId) {
            $productFilter = $productList->where('subcategory_id', $request->subcategoryId);
        }

        $productFilter = $this->productsQuery($productFilter, $request);

        if ($request->paginate == null) {
            $paginate = getPaginate();
        } else {
            $paginate = $request->paginate;
        }

        $emptyMessage = 'No product found';
        $products     = $productFilter->latest()->paginate($paginate);
        return view($this->activeTemplate . 'products.show_products', compact('products', 'emptyMessage'));
    }

    public function categoryProducts(Request $request, $id, $name)
    {

        $orderBy = $request->has('orderBy') ? $request->orderBy : null;

        $pageTitle    = $name . ' - Products';
        $emptyMessage = 'No product found';
        $products     = Product::active()->with('reviews');
        $categoryId    = 0;
        $subcategoryId = 0;
        $catmeta = null;

        $products->sorting($orderBy);
        if ($request->route()->getName() == 'category.products') {
            $categoryId    = $id;
            //$products      = $products->where('category_id', $categoryId);
            $subcategories = SubCategory::where('category_id', $categoryId)
                ->withCount('product')->where('status', 1)->get();
            $catmeta = Category::where('id', $categoryId)->first();
        }

        if ($request->route()->getName() == 'subcategory.products') {
            $subcategoryId = $id;
            $catmeta = SubCategory::where('id', $subcategoryId)->first();
            // $products      = $products->where('subcategory_id', $subcategoryId);
            $subcategories = null;
        }

        $cloneProducts = clone $products;

        $minPrice      = $cloneProducts->min('price') ?? 0;
        $maxPrice      = $cloneProducts->max('price') ?? 0;

        $brandArray = [];

        foreach ($products->get() as $product) {
            $brandArray[] = $product->brand_id;
        }

        $brandId  = array_unique($brandArray);
        $brands   = Brand::whereIn('id', $brandId)->where('status', 1)->withCount('product')->get();

        $products = $products->filterProduct($id);
        //return  $products->dump();
        $products = $products->latest()->paginate(getPaginate());


        if ($request->ajax()) {
            return view('templates.basic.products.partials.mainProduct', compact('pageTitle', 'catmeta', 'emptyMessage', 'products', 'minPrice', 'maxPrice', 'subcategories', 'brands', 'categoryId', 'subcategoryId', 'orderBy'));
        }

        return view($this->activeTemplate . 'products.category_products', compact('pageTitle', 'catmeta', 'emptyMessage', 'products', 'minPrice', 'maxPrice', 'subcategories', 'brands', 'categoryId', 'subcategoryId', 'orderBy'));
    }

    public function brandProducts(Request $request, $id, $name)
    {

        $brandId      = $id;
        $pageTitle    = $name . ' - Products';
        $emptyMessage = 'No product found';
        $products     = Product::active()->with('reviews')->where('brand_id', $brandId);

        $cloneProducts = clone $products;
        $minPrice      = $cloneProducts->min('price') ?? 0;
        $maxPrice      = $cloneProducts->max('price') ?? 0;

        $categoryArray = [];

        foreach ($products->get() as $product) {
            $categoryArray[] = $product->category_id;
        }

        $categoryId   = array_unique($categoryArray);
        $categoryList = Category::whereIn('id', $categoryId)
            ->where('status', 1)
            ->with(['subcategories' => function($query) {
                $query->select('id', 'category_id', 'name', 'status')
                      ->where('status', 1);
            }])
            ->withCount('product')
            ->get();
        $products     = $products->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'products.brand_products', compact('pageTitle', 'emptyMessage', 'products', 'minPrice', 'maxPrice', 'categoryList', 'brandId'));
    }

    protected function categoriesQuery($productList, $request)
    {

        if ($request->categories) {
            $productList = $productList->whereIn('category_id', $request->categories);
        }

        return $productList;
    }

    protected function subcategoriesQuery($productList, $request)
    {

        if ($request->subcategories) {
            $productList = $productList->whereIn('subcategory_id', $request->subcategories);
        }

        return $productList;
    }

    protected function productsQuery($productFilter, $request)
    {
        if ($request->brands) {
            $productFilter = $productFilter->whereIn('brand_id', $request->brands);
        }

        if ($request->min && $request->max) {
            $productFilter = $productFilter->whereBetween('price', [$request->min, $request->max]);
        }

        if ($request->sort) {
            $sort          = explode('_', $request->sort);
            $productFilter = $productFilter->orderBy(@$sort[0], @$sort[1]);
        }

        return $productFilter;
    }

    public function quickView(Request $request)
    {
        $product = Product::active()->with('productGallery')->with('reviews')->findOrFail($request->product_id);
        return view($this->activeTemplate . 'products.quickView', compact('product'));
    }

    public function productDetail($id, $name)
    {
        $emptyMessage = 'No review found.';

        $product        = Product::active()->with('category', 'productGallery', 'reviews.user')->findOrFail($id);
        $pageTitle      = $product->name;
        $relatedProduct = Product::active()->where('subcategory_id',  $product->subcategory_id)->get();

        $productId = OrderDetail::with('order')->whereHas('order', function ($order) {
            $order->where('order_status', 3);
        })->groupBy('product_id')->selectRaw('*, sum(quantity) as sum')->orderBy('sum', 'desc')->distinct('product_id')->pluck('product_id');

        $topProducts = Product::active()->where('sale_count', '!=', 0)->orderBy('sale_count', 'desc')->latest()->with('reviews')->take(8)->get();

        $seoContents['social_title']        = $product->name;
        $seoContents['social_description']  = $product->summary;
        $seoContents['description']         = $product->summary;
        $seoContents['image']               = getImage(imagePath()['product']['thumb']['path'] . '/' . $product->image, imagePath()['product']['thumb']['size']);
        $seoContents['image_size']          = imagePath()['product']['thumb']['size'];

        return view($this->activeTemplate . 'products.detail', compact('pageTitle', 'product', 'relatedProduct', 'topProducts', 'emptyMessage', 'seoContents'));
    }

    public function trackOrder()
    {
        $pageTitle = 'Track Your Order';
        return view($this->activeTemplate . 'track.track_order', compact('pageTitle'));
    }

    public function getTrackOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderNo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $order = Order::where('order_no', $request->orderNo)->first();

        if (!$order) {
            return response()->json(['error' => 'Sorry! The order number was not found.']);
        }

        $emptyMessage = 'Your order has been cancelled.';
        return view($this->activeTemplate . 'track.show_track', compact('order', 'emptyMessage'));
    }


    public function accountDeletion(Request $request)
    {
        $pageTitle = "Deletion Request";
        return view($this->activeTemplate . 'delaccount', compact('pageTitle'));
    }

    public function blogdetails(Request $request, $id)
    {
        $blog      = Blogs::where('id', $id)->first();
        $pageTitle = "Blogs";
        return view($this->activeTemplate . 'blogs', compact('blog', 'pageTitle'));
    }
}
