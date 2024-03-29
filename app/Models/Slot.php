<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $gaurded = [];

    public function slot_classifications()
    {
        return $this->hasMany(SlotClassification::class);
    }
}
