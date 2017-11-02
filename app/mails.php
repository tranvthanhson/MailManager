<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mails extends Model
{
    protected $table = 'mails';
    protected $primaryKey = 'mail_id';
    public $timestamps = false;
}
