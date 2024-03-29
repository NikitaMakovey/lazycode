<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['filename', 'mime', 'path', 'size'];
}
