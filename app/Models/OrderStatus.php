<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrderStatus extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'status', 'order_id','user_id','created_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
