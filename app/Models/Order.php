<?php

namespace App\Models;

use App\Constants\constOrderStatus;
use App\Constants\Order as OrderPickUp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'customer_address', 'customer_phone', 'customer_notes', 'restaurant_id', 'total', 'admin_notes', 'pickup_type' , 'location',
    'transfer_type'
];

    protected $dates = ['created_at', 'updated_at', 'noticed_at', 'finished_at'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_order')->withPivot('quantity', 'item_name', 'price_per_unit')->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeOfRestaurant($query, $restaurantId)
    {
        return $query->where('restaurant_id', $restaurantId);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function notice()
    {
        $this->status = constOrderStatus::NOTICED;
        $this->noticed_at = date('Y-m-d H:i:s');
        $this->save();
    }

    public function finish()
    {
        $this->status = constOrderStatus::FINISHED;
        $this->finished_at = date('Y-m-d H:i:s');
        $this->save();
    }

    public function isFinished()
    {
        return $this->status === constOrderStatus::FINISHED;
    }

    public function pickupLabel (){
        return OrderPickUp::PICKUP_TYPES[$this->pickup_type];
    }
    public function order_statuses(){
        return $this->hasMany(OrderStatus::class);
    }
}
