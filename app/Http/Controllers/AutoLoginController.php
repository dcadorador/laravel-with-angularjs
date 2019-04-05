<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Services\InfusionSoftServices;
use App\Models\PostLog;
use App\Models\IpnLog;
use App\Models\OrderContact;
use App\Models\IpnProduct;
use App\Models\SystemSetting;
use App\Models\ProductSetting;
use App\Models\DomainSetting;
use Exception;
use Mail;
use App\Models\AutoLogin;

class AutoLoginController extends Controller
{
    private $systemSettings;

    public function __construct()
    {
        $this->infs = new InfusionSoftServices;
        $this->systemSettings = $this->loadSystemSettings();
    }

	public function index(Request $request)
    {
        $data = $request->all();
        /*Mail::raw(json_encode($data), function ($message) {
            $message->to('ted@fusedsoftware.com')
            ->subject('hays');
        });
        exit;*/

        Log::debug('Autologin request: '.json_encode($data));

        if(!$this->validateCb($data)) {
            Log::debug("Invalid clickbank parameters");
            die("Invalid clickbank parameters");
        }

        if(!isset($data['cemail'])) {
            Log::debug("Customer email is missing from the parameters " . json_encode($data));
            die("Customer email is missing from the parameters " . json_encode($data));
        }

        if(!isset($data['item'])) {
            Log::debug("Customer item is missing from the parameters " . json_encode($data));
            die("Customer item is missing from the parameters " . json_encode($data));
        }

        $items = explode('|', $data['item']);
        $productRec = null;

        foreach ($items as $item) {
            $productRec = ProductSetting::where('cb_sku', $data['item'])->first();
        }
        

        if(!$productRec) {
            Log::debug("No such product record " . json_encode($data));
            die("No such product record " . json_encode($data));
        }

        $domainSetting = DomainSetting::find($productRec->domain_id);

        $contactId = $this->createOrRetrieveIdByEmail($data['cemail']);
        $contactId = intval($contactId);

        // added new auto login logging
        $datetime = date('Y-m-d H:i:s',strtotime($data['time']));
        $auto_log = new AutoLogin();
        $auto_log->email = $data['cemail'];
        $auto_log->contact_id = $contactId;
        $auto_log->redirect_url = $data['redirect'];
        $auto_log->receipt = $data['cbreceipt'];
        $auto_log->date_time = $datetime;
        $auto_log->save();

        $queryData = [
            'memb_autologin' => 'yes',
            'forcelogin'     => '1',
            'auth_key'       => $domainSetting['memberium_auth_key'],
            'Id'             => $contactId,
            'Email'          => $data['cemail']
        ];

        if (isset($data['redirect'])) {
            $redirect = $data['redirect'];
            $redirectSplitted = explode('?', $redirect);
            $url = $redirectSplitted[0];
            $params = $data;
            unset($params['redirect']);
            if (count($redirectSplitted) === 2) {
                $query = $redirectSplitted[1];
                parse_str($query, $redirectParams);
                $params = array_merge($params, $redirectParams);
            }
            $params['contactId'] = $contactId;
            $query = http_build_query($params);
            $queryData['redir'] = "$url?$query";
        }


        $queryData['tag_ids'] = "3025";
        $items = explode('|', $data['item']);
        foreach ($items as $item) {
            $productSettingRecord = ProductSetting::where('cb_sku', $item)->first();
            $queryData['tag_ids'] .= ',' . $productSettingRecord->memberium_tags;
        }

        $query = http_build_query($queryData);
        $url = $domainSetting['url']."?".$query;
        // adding the logging for the auto login
        $auto_log->result = $url;
        $auto_log->update();
        Log::debug('Auto logging in'. $url);
        return redirect($url);

    }

    protected function validateCb($data)
    {
        if (!isset($data['cbreceipt'], $data['time'], $data['item'], $data['cbpop'])) {
            return false;
        }

        $sales = count(explode('|', $data['cbreceipt']));
        $receipts = explode('|', $data['cbreceipt']);
        $times    = explode('|', $data['time']);
        $items    = explode('|', $data['item']);
        $pops     = explode('|', $data['cbpop']);

        $valids = 0;
        for ($i = 0; $i < $sales; $i++) {
            $receipt = $receipts[$i];
            $time = $times[$i];
            $item = $items[$i];
            $pop = $pops[$i];
            $xxpop = sha1($this->systemSettings['CB_SECRET_KEY'] . "|$receipt|$time|$item");
            $xxpop = strtoupper(substr($xxpop,0,8));
            if ($pop === $xxpop) {
                $valids++;
            }
        }

        return $sales === $valids;
    }

    /**
    * query for contact id DB logs, if no result, find in infs, if no result, create a contact record in infs
    * 
    * @param
    *   $email string = the unique email to find contact
    * @return $contactId integer
    */
    protected function createOrRetrieveIdByEmail($email)
    {
        $contactId = 0;
        $infsOrderContact = OrderContact::where('email', $email)->first();
        if(!$infsOrderContact){
            $contactRecord = $this->infs->queryTable("Contact", ['Email' => $email], false);
            
            if(!isset($contactRecord[0]['Id'])){
                $contactId = $this->infs->deDupeContact(null, ["Email"=>$email]); //create infs contact record
                if($contactId > 0){
                    $this->infs->optIn($email, "CB Optin");
                }
            }
            else{
                $contactId = $contactRecord[0]['Id'];
            }
        }
        else{
            $contactId = $infsOrderContact->contact_id;
        }
        OrderContact::updateOrCreate (['contact_id'=>$contactId], ['contact_id'=>$contactId,'email' => $email]);
        return $contactId;
    }

    protected function loadSystemSettings()
    {
        $return = [];
        $dbSystemSettings = SystemSetting::all();
        foreach($dbSystemSettings as $dbSystemSetting) {
            $return[strtoupper($dbSystemSetting['meta_key'])] = $dbSystemSetting['meta_value'];
        }

        return $return;
    }
}
