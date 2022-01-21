<?php

namespace App\Models\City;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class   Citycategory extends Model
{
    use HasFactory;

    protected $fillable = ['id','name'];

}
