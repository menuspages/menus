<?php

namespace App\Models\City;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class   Cityrestaurant extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','name','description','image','menu_link','map_link' , 'phone'];

}
