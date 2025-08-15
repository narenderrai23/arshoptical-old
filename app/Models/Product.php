<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;
    protected $guarded = [];

    public function productGallery() {
        return $this->hasMany(ProductGallery::class, 'product_id')->orderBy('color_code');
    }
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory() {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function scopeActive() {

        return $this->where('status',1)
            ->whereHas('category', function ($category) {
                $category->where('status', 1);
            })->whereHas('subcategory', function ($subcategory) {
                $subcategory->where('status', 1);
            })->whereHas('brand', function ($brand) {
                $brand->where('status', 1);
            });
    }
    public function scopeSorting($query, $orderBy)
    {
        if ($orderBy) {
            if ($orderBy == 'id') {
                $query->orderBy('products.id', 'desc');
            } elseif ($orderBy == 'price_asc') {
                $query->orderBy('products.price', 'asc');
            } elseif($orderBy == 'price_desc') {
                $query->orderBy('products.price', 'desc');
            }
        }
        return $query;
    }
 	public function decrementInventory($quantity,$color_id){
        $pg=ProductGallery::find($color_id);

        $qty=$pg->qty-$quantity;
        $pg->qty=$qty ?? 0;
        $pg->save();


    }
    public function galleryImage($imageid)
    {
       $image =$this->with('productGallery')->where('product_galleries.id',$imageid)->first();

        return $image;
    }

    public function scopeFilterProduct($query, $cats) {
       return $query->whereRaw("find_in_set($cats,cats)");
    }
}