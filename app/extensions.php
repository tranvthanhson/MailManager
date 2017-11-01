<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class extensions extends Model
{
    protected $table = 'extensions';
    protected $primaryKey = 'extension_id';
    public $timestamps = false;
}
