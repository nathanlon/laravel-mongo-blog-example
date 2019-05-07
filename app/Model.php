<?php
declare(strict_types=1);

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    //define any fields we are not allowed to edit here.
    protected $guarded = [];

    public function getId()
    {
        return $this->getIdAttribute();
    }
}
