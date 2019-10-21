<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speler extends Model
{
    use SoftDeletes;
    protected $table = 'spelers';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}
