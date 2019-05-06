<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    //define any fields we are not allowed to edit here.
    protected $guarded = [];
}
