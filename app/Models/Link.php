<?php

namespace App\Models;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['id','restaurant_id',
    'features->bg_image',
    'features->bg_color',
    'features->selected',
    
    'links'
    ];
    protected $casts = [
        'features' => 'json',        
    ];
}
