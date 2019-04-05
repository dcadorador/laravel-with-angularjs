<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class PostLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_url',
        'email',
        'receipt',
        'contact_id',
        'cid'
    ];

    public function validateRule(){
        return [
            'key' => [
                'required',
                Rule::in([env('SYSTEM_KEY')]),
            ],
            'cid' => 'required',
        ];
    }
}
