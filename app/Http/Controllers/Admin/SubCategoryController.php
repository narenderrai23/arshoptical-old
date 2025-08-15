<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;     
class SubCategoryController extends Controller {

    public function index(Request $request) {

        $pageTitle     = 'All Subcategories';
        $emptyMessage  = 'No subcategory found';
        $subcategories = SubCategory::query();


        if ($request->search) {
           $search = request()->search;
           $subcategories = $subcategories->where(function($q) use($search){
                $q->where('name','like',"%$search%")->orWhereHas('category',function($query) use ($search){
                    $query->where('name','like',"%$search%");
                });
           });
           
        }

        $subcategories = $subcategories->with('category')->orderBy('status','desc')->orderBy('orderno')->paginate(getPaginate(200));
        $categories    = Category::where('status', 1)->orderBy('name')->get();

        return view('admin.subcategory.index', compact('pageTitle', 'emptyMessage', 'subcategories', 'categories'));
    }


    public function updateorder(Request $request){

        $order=$request->order;
    for($i=0;$i<count($order);$i++){
    
         $landmaster =SubCategory::find($order[$i]);
        $landmaster->orderno = $i+1;
        $landmaster->save();
    }
       
        $notification = 'SubCategory order updated successfully.';
        $notify[] = ['success',$notification];
        return back()->withNotify($notify);
        //return redirect()->route('landmasters.index')
                      // ->with('success','LandMaster updated successfully');
    }
    public function store(Request $request, $id = 0) {
         // dd($request->hasFile('image'));


        $request->validate([
            'category_id' => 'required',
            'name'        => 'required|unique:sub_categories,name,' . $id,
        ]);

        if ($id) {
            $subcategory         = SubCategory::findOrFail($request->id);
             $validate['image'] = ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $subcategory->status = $request->status ? 1 : 0;
            $notification        = 'Subcategory updated successfully.';
                $oldFile = null;
        } else {
            $subcategory  = new SubCategory();
            $validate['image'] = ['image', new FileTypeValidate(['jpeg', 'jpg', 'png']),];
            $notification = 'Subcategory added successfully.';
            $oldFile = $subcategory->image;
        }

       // $request->validate($validate);

        $path = imagePath()['category']['path'];
        $size = imagePath()['category']['size'];

	$pathbanner = imagePath()['categorybanner']['path'];
        $sizebanner = imagePath()['categorybanner']['size'];

       // dd('imaganema'.$request->hasFile('image'));
          if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $oldFile);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
           // dd('imaganema'.$filename);
            $subcategory->image = $filename;
        }

	 $digiFile = '';
        //assets/digitalItem
        $path     = imagePath()['digital_item']['path'];

        if ($request->hasFile('digi_file')) {
            try {
                $digiFile = uploadFile($request->digi_file,$path );
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload your file'];
                return back()->withNotify($notify)->withInput();
            }

        }

	if ($request->hasFile('banner')) {

            try {
                $filename = uploadImage($request->banner, $pathbanner , $sizebanner , $oldFile);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
           // dd('imaganema'.$filename);
            $subcategory->banner = $filename;
        }
        $subcategory->category_id = $request->category_id;
        $subcategory->name        = $request->name;
 	$subcategory->price        = $request->price;
        $subcategory->metatitle     = $request->metatitle;
	 if ($request->hasFile('digi_file')) {
		$subcategory->pdf = $digiFile;
	}
        $subcategory->metadescription     = $request->metadescription;
        $subcategory->metakeywords     = $request->metakeywords;
        $subcategory->special_offer= $request->special_offer? 1 : 0;;
        $subcategory->best_seller= $request->best_seller? 1 : 0;;
        $subcategory->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

}