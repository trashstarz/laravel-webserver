<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id', 'path'];

    public function user(){
        //a model is a table,
        //a post is owned by an user. look for user_id in this table to figure out which one
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
