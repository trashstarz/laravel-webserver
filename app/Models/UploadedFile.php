<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{

    //enable mass assignment = tell laravel "its ok to assign these in bulk (create, update)"
    //and only these fields can be assigned
    protected $fillable = [
        'original_name',
        'path',
        'mime_type',
        'size',
    ];
}
