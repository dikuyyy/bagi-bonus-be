<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagiBonus extends Model
{
    use HasFactory;

    protected $table = 'bagi_bonus';
    protected $guarded = [];

    public function BagiBonusItem(){
        return $this->hasMany(BagiBonusItem::class, 'bagi_bonus_id', 'id');
    }
}
