<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileupload extends Model
{
    use HasFactory;

    public function idea() {
        return $this->belongsTo(Idea::class);
    }

    public $timestamps = false;
}
