<?php

namespace App\Models;

use App\Constants\MenuRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function markAsSeen (){
        $this->status = MenuRequestStatus::SEEN;
        $this->save();
    }

    public function updateNote ($note){
        $this->admin_notes = $note;
        $this->save();
    }
}
