<?php
declare(strict_types=1);

namespace App;

class Month extends Year
{
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
