<?php

namespace App\Models;

use App\Helpers\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'order_id', 'status'];
}
