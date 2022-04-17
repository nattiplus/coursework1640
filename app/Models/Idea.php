<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function viewers() {
        return $this->hasMany(Viewer::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->orderBy('create_date', 'desc');
    }

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }

    public function fileuploads() {
        return $this->hasMany(Fileupload::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function submission() {
        return $this->belongsTo(Submission::class);
    }

    public $timestamps = false;
}
