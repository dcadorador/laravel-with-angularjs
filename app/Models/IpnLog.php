<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class IpnLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receipt',
        'email',
        'trans_type',
        'trans_data',
        'total_amount',
        'cid',
        'affiliate',
        'processed',
        'processed_to_infs',
        'auto_cancel'
    ];

    public function validateRule(){
        return [
            'receipt' => 'required',
            'transactionType' => 'required',
        ];
    }


    /**
    * Takes the cb data from IPN and create an INFS contact format structure
    * @return array
    */

    public function createInfsContactFormat()
    {
        $transData = json_decode($this->trans_data);

        $infsContactFormat['Email'] = $transData->customer->billing->email ?? null;
        $infsContactFormat['FirstName'] = $transData->customer->billing->firstName ?? null;
        $infsContactFormat['LastName'] = $transData->customer->billing->lastName ?? null;

        $infsContactFormat['StreetAddress1'] = $transData->customer->billing->address->address1 ?? null;
        $infsContactFormat['StreetAddress2'] = $transData->customer->billing->address->address2 ?? null;
        $infsContactFormat['City'] = $transData->customer->billing->address->city ?? null;
        //$infsContactFormat['Country'] = $transData->customer->billing->address->country ? isset(config('country')[$transData->customer->billing->address->country]) ?: $transData->customer->billing->address->country] ) : null;
        //$infsContactFormat['State'] = $transData->customer->billing->address->state ?? null;

        $address = $transData->customer->billing->address;
        if(property_exists($address,'country')){
            if($transData->customer->billing->address->country) {
                if(isset(config('country')[$transData->customer->billing->address->country])) {
                    $infsContactFormat['Country'] = config('country')[$transData->customer->billing->address->country];
                } else {
                    $infsContactFormat['Country'] = $transData->customer->billing->address->country;
                }
            }
        } else {
            $infsContactFormat['Country'] = null;
        }

        if(property_exists($address,'state')){
            if($transData->customer->billing->address->state) {
                if(isset(config('state')[$transData->customer->billing->address->state])) {
                    $infsContactFormat['State'] = config('state')[$transData->customer->billing->address->state];
                } else {
                    $infsContactFormat['State'] = $transData->customer->billing->address->country;
                }
            }
        } else {
            $infsContactFormat['State'] = null;
        }

        $infsContactFormat['PostalCode'] = $transData->customer->billing->address->postalCode ?? null;
        $infsContactFormat['Address2Street1'] = $transData->customer->shipping->address->address1 ?? null;
        $infsContactFormat['Address2Street2'] = $transData->customer->shipping->address->address2 ?? null;
        $infsContactFormat['City2'] = $transData->customer->shipping->address->city ?? null;
        $infsContactFormat['Country2'] = $transData->customer->shipping->address->country ?? null;
        $infsContactFormat['State2'] = $transData->customer->shipping->address->state ?? null;
        $infsContactFormat['PostalCode2'] = $transData->customer->shipping->address->postalCode ?? null;

        return $infsContactFormat;
    }

}
