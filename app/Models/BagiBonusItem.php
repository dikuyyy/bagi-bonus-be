<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagiBonusItem extends Model
{
    use HasFactory;

    protected $table = 'bagi_bonus_item';
    protected $guarded = [];

    public function BagiBonus() {
        return $this->belongsTo(BagiBonus::class, 'bagi_bonus_id', 'id');
    }
}
