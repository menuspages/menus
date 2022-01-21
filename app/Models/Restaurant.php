<?php

namespace App\Models;

use App\Constants\constOrderStatus;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = ['is_deleted'];

    public function logoUrl()
    {
        return $this->logo_path;
    }
    public function links (){
        return $this->hasOne(Link::class);
    }
    public function backgroundImageUrl()
    {
        return $this->background_image_path;
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

    public function attachManager($user)
    {
        $this->manager_id = $user->id;
        $this->save();
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function delete()
    {
        $this->is_deleted = 1;
        $this->subdomain = $this->subdomain . '-' . $this->id . '-' . date('Y-m-d-H-i-s');
        $this->save();
    }

    public function isThemeAvailable($themeId)
    {
        $availableThemes = json_decode($this->available_themes, true);
        return in_array($themeId, $availableThemes);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function newOrdersCount()
    {
        return $this->orders()->where('status', constOrderStatus::NEW)->count();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    public function isOpened (){
        if(!$this->open_from && !$this->open_to){
            return null;
        }
        $currentTime = (new DateTime("now", new DateTimeZone('Asia/Riyadh') ));
        $openFrom = Carbon::createFromTimeString($this->open_from);
        $openTo = Carbon::createFromTimeString($this->open_to);
        if($openTo < $openFrom){
            $openTo->addDay();
        }
        $ISOFormat = 'Y-m-d H:i:s';
        if($currentTime->format($ISOFormat) > $openFrom->format($ISOFormat) && $currentTime->format($ISOFormat)< $openTo->format($ISOFormat)){
            return true;
        }
        return false;
    }
}
