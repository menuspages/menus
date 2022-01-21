<?php

namespace App\Models;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'rating','created_at','restaurant_id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
