<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotClassification extends Model
{
    use HasFactory;

    protected $gaurded =[];

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
