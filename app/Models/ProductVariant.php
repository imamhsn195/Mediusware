<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $with = ['variant'];
    public function variant()
    {
        return $this->belongsTo('App\Models\Variant', 'variant_id');
    }
    
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    
}
