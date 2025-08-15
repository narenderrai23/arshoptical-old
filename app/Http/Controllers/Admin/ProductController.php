<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request) {

        $pageTitle    = 'All Products';
        $emptyMessage = 'No product found';
        $products     = Product::query()->orderBy('status','DESC');

        if ($request->search) {
            $products->where('name', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('product_sku', 'LIKE', "%$request->search%");
        }

        $products = $products->latest()->paginate(getPaginate(200));
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products'));
    }

    public function create() {
        $pageTitle   = 'Create New Product';
        $allCategory = Category::where('status', 1)->with(['subcategories' => function ($q) {
            $q->where('status', 1);
        },
        ])->orderBy('name')->get();
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        return view('admin.product.create', compact('pageTitle', 'allCategory', 'brands'));
    }

    public function store(Request $request) {

        // if ($request->hasFile('files')) {

        //     if (count($request->file('files')) >= 8) {
        //         $notify[] = ['error', 'Maximum 8 files can be uploaded.'];
        //         return back()->withNotify($notify)->withInput();
        //     }

        // }

       // dd($request->cats_id);

        $request->validate([
            'name'           => 'required|max:255',
            'product_sku'    => 'nullable|string|max:40|unique:products',
            'category_id'    => 'required',
            'subcategory_id' => 'required',
            'brand'          => 'required',
            'price'          => 'required|numeric|gt:0',
            'quantity'       => 'required|integer|gt:0',
            'discount'       => 'numeric|min:0|max:100',
            'discount_type'  => 'required|in:1,2',
            'digital_item'   => 'required',
            'file_type'      => 'required_if:digital_item,1',
            'image'          => ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'files.*'        => ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'digi_file'      => ['required_if:file_type,1', new FileTypeValidate(['pdf', 'docx', 'txt', 'zip', 'xlx', 'csv', 'ai', 'psd', 'pptx'])],
            'digi_link'      => 'required_if:file_type,2',
        ]);
    
        $filename = '';
        $path     = imagePath()['product']['thumb']['path'];

       
        if ($request->hasFile('image')) {
            try {
			
                $filenamemain = uploadImage($request->image, $path);
		
            } catch (\Exception $exp) {
		
                $notify[] = ['error', 'Image could not be uploaded.'.$exp];
                return back()->withNotify($notify);
            }

        }



        $galleryFileName = [];
$gallerycolorName = [];
$arr=[]; 
$colr=[]; 
        if ($request->myfiles) {

            $path = imagePath()['product']['gallery']['path'];

            foreach ($request->myfiles as $file) {

                try {
                     //$arr[] = uploadImage($file, $path);

                        $color=explode('filename',$file)[1];
			//$color=explode(' ',$color)[1];
			$im=explode('filename',$file)[0];
			
                         $image = explode('base64',$im)[1];
			
                         //$image = end($image);
                         $image = str_replace(' ', '+', $image);

                         $filename =   uniqid() . time() . '.png';
                         array_push($arr,$filename);
			array_push($colr,$color);
				//dd($image);
			file_put_contents($path.'/'.$filename, base64_decode($image));
                         //Storage::disk('public')->put( $path . $file,);


                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Image could not be uploaded.'.$exp];
                    return back()->withNotify($notify)->withInput();
                }

            }

            $galleryFileName = $arr;
		$gallerycolorName =$colr;
        }
	
        $digiFile = '';
        $path     = imagePath()['digital_item']['path'];

        if ($request->hasFile('digi_file')) {
            try {
                $digiFile = uploadFile($request->digi_file);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload your file'];
                return back()->withNotify($notify)->withInput();
            }

        }

        $input_feature = [];

        if ($request->has('feature_title')) {

            for ($a = 0; $a < count($request->feature_title); $a++) {
                $arr                  = [];
                $arr['feature_title'] = $request->feature_title[$a];
                $arr['feature_desc']  = $request->feature_desc[$a];
                $input_feature[]      = $arr;
            }

        }

        $product                   = new Product();
        $product->name             = $request->name;
        $product->model_no         = $request->model_no;
        $product->product_sku      = $request->product_sku;
        $product->category_id      = $request->category_id;
        $product->subcategory_id   = $request->subcategory_id;
        $product->brand_id         = $request->brand;
        $product->slug             = slug($request->name);
        $product->price            = $request->price;
        $product->discount         = $request->discount;
        $product->discount_type    = $request->discount_type;
        $product->quantity         = $request->quantity;
        $product->hot_deals        = $request->hot_deals ? 1 : 0;
        $product->featured_product = $request->featured_product ? 1 : 0;
        $product->today_deals      = $request->today_deals ? 1 : 0;
        $product->description      = $request->description;
        $product->summary          = $request->summary;
        $product->features         = json_encode($input_feature);
        $product->digital_item     = $request->digital_item;
        $product->file_type        = $request->file_type;
        $product->digi_file        = $digiFile;
        $product->digi_link        = $request->digi_link;
        $product->cats             = implode(',',$request->cats_id);
        $product->image            = $filenamemain;
        $product->save();

        foreach ($galleryFileName as   $key => $file) {

           // $color_code=$this->get_string_between($file,'_','.');

            $files             = new ProductGallery();
            $files->product_id = $product->id;
            $files->image      = $galleryFileName[$key] ;
            $files->color_code      = $gallerycolorName[$key];
            $files->save();
        }

        $notify[] = ['success', 'Product added successfully.'];
        return redirect()->back()->withNotify($notify);
    }


    function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


    public function edit($id) {
        $pageTitle   = 'Update Product';
        $product     = Product::where('id', $id)->with('ProductGallery')->first();
        $allCategory = Category::where('status', 1)->with(['subcategories' => function ($q) {
            $q->where('status', 1);
        },
        ])->orderBy('name')->get();
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        return view('admin.product.edit', compact('pageTitle', 'product', 'allCategory', 'brands'));
    }

    public function update(Request $request, $id) {

		
    // dd($request->description);


        $product = Product::where('id', $id)->with('ProductGallery')->first();
        $request->validate([
            'name'           => 'required',
            'product_sku'    => 'nullable|unique:products,product_sku,' . $product->id,
            'category_id'    => 'required',
            'subcategory_id' => 'required',
            'brand'          => 'required',
            'price'          => 'required|numeric|gt:0',
            'quantity'       => 'required|integer|gt:0',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'digital_item'   => 'required',
            'file_type'      => 'required_if:digital_item,1',
            'image'          => ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'files'          => 'nullable|array',
            'files.*'        => ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'digi_file'      => ['nullable', new FileTypeValidate(['pdf', 'docx', 'txt', 'zip', 'xlx', 'csv', 'ai', 'psd', 'pptx'])],
            'digi_link'      => 'required_if:file_type,2',
        ]);

        $filename = $product->image;

        $path = imagePath()['product']['thumb']['path'];
    
        $galleryPath = imagePath()['product']['gallery']['path'];

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify)->withInput();
            }

        }

        $oldImages   = $product->ProductGallery->pluck('id')->toArray();
        $imageRemove = array_values(array_diff($oldImages, $request->imageId ?? []));

        foreach ($imageRemove as $remove) {
            $singleImage = ProductGallery::find($remove);
            $location    = $galleryPath;
            removeFile($location . '/' . $singleImage->image);
            $singleImage->delete();
        }

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $image) {

                if (isset($request->imageId[$key])) {
                    $singleImage = ProductGallery::find($request->imageId[$key]);
                    $location    = $galleryPath;
                    removeFile($location . '/' . $singleImage->image);
                    $singleImage->delete();
                    $newImage           = uploadImage($image, $galleryPath);
                    $singleImage->image = $newImage;
                    $singleImage->save();
                } else {
                    try {
                        $newImage = uploadImage($image, $galleryPath);
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Image could not be uploaded.'];
                        return back()->withNotify($notify);
                    }

                    $productImage             = new ProductGallery();
                    $productImage->product_id = $product->id;
                    $productImage->image      = $newImage;
                    $productImage->save();


			

                }

            }

        }






        $input_feature = [];

        if ($request->has('feature_title')) {

            for ($a = 0; $a < count($request->feature_title); $a++) {
                $arr                  = [];
                $arr['feature_title'] = $request->feature_title[$a];
                $arr['feature_desc']  = $request->feature_desc[$a];
                $input_feature[]      = $arr;
            }

        }

        $digiFile = $product->digi_file;

        if ($request->hasFile('digi_file')) {
            $path = imagePath()['digital_item']['path'];
            try {
                $digiFile = uploadFile($request->digi_file, $path);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload your file'];
                return back()->withNotify($notify)->withInput();
            }

        }

        $product->name             = $request->name;
        $product->model_no         = $request->model_no;
        $product->category_id      = $request->category_id;
        $product->subcategory_id   = $request->subcategory_id;
        $product->cats             = implode(',',$request->cats_id);
        $product->brand_id         = $request->brand;
         $product->product_sku      = $request->product_sku;
        $product->price            = $request->price;
        $product->discount         = $request->discount;
        $product->discount_type    = $request->discount_type;
        $product->quantity         = $request->quantity;
        $product->hot_deals        = $request->hot_deals ? 1 : 0;
        $product->featured_product = $request->featured_product ? 1 : 0;
        $product->today_deals      = $request->today_deals ? 1 : 0;
        $product->status           = $request->status ? 1 : 0;
        $product->summary          = $request->summary;
        $product->description      = $request->description;
        $product->features         = json_encode($input_feature);
        $product->digital_item     = $request->digital_item;
        $product->file_type        = $request->file_type;
        $product->digi_file        = $digiFile;
        $product->digi_link        = $request->digi_link;
        $product->image            = $filename;
        $product->save();

	        


			 foreach ($request->imageId ??  [] as $key => $img) {
				$productImage= ProductGallery::where('id', $img)->first();
			

                    
                    $productImage->qty= $request['qty'.$img];
 			$productImage->color_code= $request['colorcode'.$img];
                    $productImage->save();
			

		}


        $notify[] = ['success', 'Product updated successfully'];
        return redirect()->back()->withNotify($notify)->withInput();
    }

    public function digitalFileDownload($id) {
        $product   = Product::findOrFail($id);
        $file      = $product->digi_file;
        $path      = imagePath()['digital_item']['path'];
        $full_path = $path . '/' . $file;
        return response()->download($full_path);
    }

    public function todayDeals(Request $request) {
        $pageTitle    = 'Today Deals Products';
        $emptyMessage = 'No product found';
        $products     = Product::where('today_deals', 1);

        if ($request->search) {
            $products->where('name', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('product_sku', 'LIKE', "%$request->search%");
        }

        $products = $products->latest()->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products'));
    }

    public function todayDealsDiscount(Request $request) {
        $request->validate([
            'discount'      => 'required|numeric|min:0|max:100',
            'discount_type' => 'required|integer|in:1,2',
        ]);

        $general                = GeneralSetting::first();
        $general->discount      = $request->discount;
        $general->discount_type = $request->discount_type;
        $general->save();

        $notify[] = ['success', 'Today deal discount updated successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function reviews($id) {
        $product      = Product::findOrFail($id);
        $pageTitle    = 'Reviews of ' . $product->name;
        $emptyMessage = 'Data not found';
        $reviews      = Review::where('product_id', $id)->with('user')->paginate(getPaginate());
        return view('admin.product.reviews', compact('pageTitle', 'reviews', 'emptyMessage'));
    }

    public function reviewRemove($id) {
        $review = Review::findOrFail($id);
        $review->delete();

        $product     = Product::with('reviews')->findOrFail($review->product_id);

        if($product->reviews->count() > 0){

            $totalReview = $product->reviews->count();
            $totalStar   = $product->reviews->sum('stars');
            $avgRating   = $totalStar / $totalReview;
        }else{
            $avgRating = 0;
        }

        $product->avg_rate = $avgRating;
        $product->save();

        $notify[] = ['success', 'Review remove successfully'];
        return back()->withNotify($notify);
    }

}