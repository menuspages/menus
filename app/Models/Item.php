<?php

namespace App\Models;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id', 'image_path', 'current_price', 'old_price', 'calories', 'is_visible', 'is_available' ,'new',
    'quantity_summary->target',
    'quantity_summary->total',
    'quantity_summary->remaining',
    'quantity_summary->input_quantity_summary',
    'allergens',
    'sub_details_new->subject',
    'sub_details_new->items',
    
    
];
    protected $casts = [
        'quantity_summary' => 'json',        
        'sub_details_new' => 'json',        
        
    ];
    public function allergensExists()
{
    if($this->allergens != null)
    {
        return true;
    }
    return false;
}
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute($value)
    {
        return $this->imageUrl($value);
    }

    public function imageUrl($value = null)
    {
         return $value; //;?? //$this->image_path;
    }

    public function scopeOfRestaurantId($query, $restaurantId)
    {
        return $query->whereHas('category.restaurant', function ($query) use ($restaurantId) {
            return $query->where('restaurants.id', $restaurantId);
        });
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', 1);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delete()
    {
        ImageUploader::deleteExistingImage($this->image_path);
        parent::delete();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'item_order');
    }
}
