<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image',
        'banner',
        'icon',
        'menu_enabled',
        'home_enabled',
        'sort_order',
        'seo_title',
        'seo_description',
    ];
    public $timestamps = true;

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'category_product_attribute', 'category_id', 'attribute_id');
    }
}
