<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    protected $with = ['product_variant_one_title','product_variant_two_title','product_variant_three_title'];
    public function product_variant_one_title()
    {
        return $this->belongsTo('App\Models\Variant', 'product_variant_one');
    }
    public function product_variant_two_title()
    {
        return $this->belongsTo('App\Models\Variant', 'product_variant_two');
    }
    public function product_variant_three_title()
    {
        return $this->belongsTo('App\Models\Variant', 'product_variant_three');
    }

    
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    
}
