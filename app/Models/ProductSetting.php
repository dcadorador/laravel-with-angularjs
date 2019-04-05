<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class ProductSetting extends Model
{
    public function domain()
    {
        return $this->belongsTo(DomainSetting::class,'domain_id');
    }
}
