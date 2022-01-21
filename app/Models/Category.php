<?php

namespace App\Models;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'restaurant_id', 'image_path'];

    public function imageUrl()
    {
        return $this->image_path;
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function delete()
    {
        ImageUploader::deleteExistingImage($this->image_path);
        $this->items()->delete();

        parent::delete();
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
