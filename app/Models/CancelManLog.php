<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelManLog extends Model
{
    //
    use SoftDeletes;

    protected $table = 'cancel_manual_subs';

    protected $guarded = [];

    public function ipn() {
        return $this->belongsTo(IpnLog::class,'ipn_log_id');
    }
}
