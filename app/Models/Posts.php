<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['judul', 'category_id', 'content', 'gambar', 'slug', 'users_id'];
    protected $table = 'posts';

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tags');
    }

    public function users() {
        return $this->belongsTo('App\Models\User');
    }
}