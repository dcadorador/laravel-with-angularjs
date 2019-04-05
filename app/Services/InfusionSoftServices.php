<?php

namespace App\Services;

use App\Services\Infusionsoft\Infusionsoft_App;
use App\Services\Infusionsoft\Infusionsoft_DataService;

use App\Services\Infusionsoft\Infusionsoft_DataFormTab;
use App\Services\Infusionsoft\Infusionsoft_DataFormGroup;
use App\Services\Infusionsoft\Infusionsoft_DataFormField;

use App\Services\Infusionsoft\Infusionsoft_Contact;
use App\Services\Infusionsoft\Infusionsoft_ContactAction;
use App\Services\Infusionsoft\Infusionsoft_ContactGroup;
use App\Services\Infusionsoft\Infusionsoft_ContactGroupAssign;
use App\Services\Infusionsoft\Infusionsoft_ContactGroupCategory;
use App\Services\Infusionsoft\Infusionsoft_Exception;
use App\Services\Infusionsoft\Infusionsoft_PhoneContact;

use App\Services\Infusionsoft\Infusionsoft_Company;

use App\Services\Infusionsoft\Infusionsoft_Lead;

use App\Services\Infusionsoft\Infusionsoft_Product;

use App\Services\Infusionsoft\Infusionsoft_Invoice;
use App\Services\Infusionsoft\Infusionsoft_InvoiceItem;
use App\Services\Infusionsoft\Infusionsoft_InvoicePayment;
use App\Services\Infusionsoft\Infusionsoft_Payment;

use App\Services\Infusionsoft\Infusionsoft_CreditCard;

use App\Services\Infusionsoft\Infusionsoft_Job;
use App\Services\Infusionsoft\Infusionsoft_OrderItem;
use App\Services\Infusionsoft\Infusionsoft_JobRecurringInstance;

use App\Services\Infusionsoft\Infusionsoft_EmailStatus;
use App\Services\Infusionsoft\Infusionsoft_EmailAddStatus;
use App\Services\Infusionsoft\Infusionsoft_EmailService;
use App\Services\Infusionsoft\Infusionsoft_EmailSent;

use App\Services\Infusionsoft\Infusionsoft_FileBox;
use App\Services\Infusionsoft\Infusionsoft_RecurringOrder;
use App\Services\Infusionsoft\Infusionsoft_InvoiceService;
use App\Services\Infusionsoft\Infusionsoft_SubscriptionPlan;


Class InfusionSoftServices
{

    public $infusionsoft_host;
    public $infusionsoft_api_key;
    
    public $app=null;
    
	public function __construct(){

        $this->infusionsoft_host = env('INFS_APP_NAME');
        $this->infusionsoft_api_key = env('INFS_APP_KEY');
        
        $this->app = new Infusionsoft_App($this->infusionsoft_host, $this->infusionsoft_api_key);
	}

    public function getObject($table_name, $id=null, $app=null){
        $obj=null;
        switch($table_name){
            case "Contact": $obj = new Infusionsoft_Contact($id, $app); break;
            case "ContactAction": $obj = new Infusionsoft_ContactAction($id, $app); break;
            case "ContactGroup": $obj = new Infusionsoft_ContactGroup($id, $app); break;
            case "ContactGroupAssign": $obj = new Infusionsoft_ContactGroupAssign($id, $app); break;
            case "ContactGroupCategory": $obj = new Infusionsoft_ContactGroupCategory($id, $app); break;
            case "PhoneContact": $obj = new Infusionsoft_PhoneContact($id, $app); break;
            case "EmailAddStatus": $obj = new Infusionsoft_EmailAddStatus($id, $app); break;
            case "Company": $obj = new Infusionsoft_Company($id, $app); break;
            case "Invoice": $obj = new Infusionsoft_Invoice($id, $app); break;
            case "InvoiceItem": $obj = new Infusionsoft_InvoiceItem($id, $app); break;
            case "InvoicePayment": $obj = new Infusionsoft_InvoicePayment($id, $app); break;
            case "Payment": $obj = new Infusionsoft_Payment($id, $app); break;
            case "Job": $obj = new Infusionsoft_Job($id, $app); break;
            case "OrderItem": $obj = new Infusionsoft_OrderItem($id, $app); break;
            case "Subscription": $obj = new Infusionsoft_JobRecurringInstance($id, $app); break;
            case "CreditCard": $obj = new Infusionsoft_CreditCard($id, $app); break;
            case "Product":   $obj = new Infusionsoft_Product(); break;
            case "DataFormGroup": $obj = new Infusionsoft_DataFormGroup(); break;
            case "DataFormField": $obj = new Infusionsoft_DataFormField(); break;
            case "DataFormTab":   $obj = new Infusionsoft_DataFormTab(); break;
            case "DataFormGroup": $obj = new Infusionsoft_DataFormGroup(); break;
            case "DataFormField": $obj = new Infusionsoft_DataFormField(); break;
            case "EmailService":$obj = new Infusionsoft_EmailService(); break;
            case "EmailStatus": $obj = new Infusionsoft_EmailStatus(); break;
            case "EmailSent":   $obj = new Infusionsoft_EmailSent(); break;
            case "FileBox": $obj = new Infusionsoft_FileBox($id, $app); break;
            case "Lead":    $obj = new Infusionsoft_Lead($id, $app); break;
            case "RecurringOrder":    $obj = new Infusionsoft_RecurringOrder($id, $app); break;
            case "InvoiceService":    $obj = new Infusionsoft_InvoiceService($id, $app); break;
            case "SubscriptionPlan":    $obj = new Infusionsoft_SubscriptionPlan($id, $app); break;
            case "":  $obj = new Infusionsoft_RecurringOrder($id,$app); break;
        }
        return $obj;
    }
    
    public function queryTable($table_name, $query, $return=false, $limit=1000, $page=-1, $orderByField="Id", $ascending = true){
        $obj = $this->getObject($table_name);
        $return_data = $this->getAllData($obj, $query, $return, $limit, $page, $orderByField, $ascending);
        return $return_data;
    }

//    function for fetching all data from a particular table 
    public function getAllData($obj, $query, $return, $limit=1000, $page=-1, $orderByField="Id", $ascending = true){
        $return_data = [];

        while(true){
            $page++;
            $data = Infusionsoft_DataService::queryWithOrderBy($obj, $query, $orderByField, $ascending, $limit, $page, $return,  $this->app);

            foreach($data as $single_data){
                $return_data[] = $single_data->toArray();
            }

            if(count($data) != $limit) break;
            break;
        }
        return $return_data;
    }

    /**
     * Get Subscription from INFS
     *
     * @param
     *      $contact_id - contact id
     *      $product_id - product id
     *      $subscription_plan_id - subs plan id
     *
     * @return array
     */
    public function getSubscription( $contact_id, $product_id, $subscription_plan_id, $select )
    {
        // table name
        $table = 'RecurringOrder';

        // query filter
        $filter = [
            'ContactId' => $contact_id,
            'ProductId' => $product_id,
            'SubscriptionPlanId' => $subscription_plan_id
        ];

        // return fields
        $select = ["id", "status", "nextBillDate", "promoCode", "reasonStopped"];

        // get the data returned by the INFS
        return $this->queryTable($table, $filter, $select, 1, -1, "Id", false);
    }

    /**
     * Get Subscription from INFS by transaction, cbproduct and contact id
     *
     * @param
     *      $contact_id - contact id
     *      $cbTransaction - the IPN data sent by CB
     *      $cbProduct - The products included in the IPN
     *
     * @return array
     */
    public function getSubscriptionByContactIdAndTransaction($contactId, $cbTransaction, $cbProdct)
    {
        $table = 'RecurringOrder';

        // query filter
        $filter = [
            'ContactId' => $contactId,
            'PromoCode' => "__cbReceipt:".explode("-", $cbTransaction->receipt)[0]."__cbSku:".$cbProdct->sku,
        ];

        // return fields
        $select = ["id", "status", "nextBillDate", "promoCode", "reasonStopped"];

        return $this->queryTable($table, $filter, $select, 1, -1, "Id", false);
    }

    /**
     * Update the date of the next payment date in INFS
     *
     * @param
     *      $subscriptionId - The identified of subscription
     *      $nextPaymentDate - The updating date
     *
     * @return array
     */
    public function updateJobRecurringNextBillDate($subscriptionId, $nextPaymentDate)
    {
        return Infusionsoft_InvoiceService::updateJobRecurringNextBillDate($subscriptionId, $nextPaymentDate, $this->app);
    }

    /**
     * Create an INFS invoice
     *
     * @param
     *      $subscriptionId - The identified of subscription
     *
     * @return array
     */
    public function createInvoiceForRecurring($subscriptionId)
    {
        return Infusionsoft_InvoiceService::createInvoiceForRecurring($subscriptionId, $this->app);
    }

    public function createSubscription($contactId, $ipn, $ipnProduct, $cbResult, $productSettings, $transData, $status)
    {
        $frequencyMap = [1 => "year", 2 => "month", 3 => "week", 6 => "day"];

        $transactionTime = $transData->transactionTime;
        
        $infsRecurring =    new Infusionsoft_RecurringOrder();
        $subscriptionPlan = $this->queryTable("SubscriptionPlan", ['ProductId' => $productSettings->infs_product_id], ["Id", "Cycle", "Frequency", "NumberOfCycles", "PlanPrice"]);

        if(empty($subscriptionPlan)) die("No subscription plan found");
        if(!isset($frequencyMap[$subscriptionPlan[0]['Frequency']])) die("Invalid billing cycle!");

        \Log::info('Frequency Time: '.strtotime("-1 ".$frequencyMap[$subscriptionPlan[0]['Frequency']]));
        \Log::info('Transaction Time: '.strtotime($transactionTime));

        $paidThruDate = $lastBillDate = date('Y-d-m', strtotime("-1 ".$frequencyMap[$subscriptionPlan[0]['Frequency']], strtotime($transactionTime)));
        //$startDate = date('Y-d-m');
        $startDate = explode("T", $transactionTime)[0];
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d',$startDate);

        \Log::info('Start Date'.json_encode($startDate));
        \Log::info('Last Bill Date'.json_encode($lastBillDate));

        $params = [
            'Status' =>  $status,
            'ContactId' =>  $contactId,
            'StartDate' =>  $startDate->format('Y-d-m'),
            'PaidThruDate' => $paidThruDate ,
            'LastBillDate' => $lastBillDate ,
            'PromoCode' => "__cbReceipt:".$ipn->receipt."__cbSku:".$ipnProduct->sku,
            'ProductId'  => $productSettings->infs_product_id,
            'ProgramId'  => $subscriptionPlan[0]['Id'] ,
            'SubscriptionPlanId'  => $subscriptionPlan[0]['Id'] ,
            'Frequency'  => $subscriptionPlan[0]['Frequency']  ,
            'BillingAmt'  => $subscriptionPlan[0]['PlanPrice'],
            'BillingCycle'  => $subscriptionPlan[0]['Cycle'],
            'CC1'  => 0,
            'LeadAffiliateId'  => 0,
            'CC2'  => 0,
            'NumDaysBetweenRetry'  => 2,
            'Qty'  => 1,
            'MerchantAccountId'  => 0,
            'AffiliateId'  => 0,
            'AutoCharge'  => 0,
            'MaxRetry'  => 3
        ];

        $table_name = "RecurringOrder";

        $obj = $this->getObject($table_name, null, $this->app);

        foreach($params as $key=>$value){
            $obj->$key = $value;
        }

        $obj->save($this->app);

        $id = $obj->Id;
        
        return $id;
    }

    public function updateSubscription($id, $params)
    {
        $table_name = "RecurringOrder";

        $obj = $this->getObject($table_name, $id, $this->app);

        foreach($params as $key=>$value){
            $obj->$key = $value;
        }

        $obj->save($this->app);
        
        return $id;
    }

    public function fetchContact($query=array("Id"=>"286471"), $return=false){

        if(count($query) == 0){
            return array();
        }
        
        $return_contact = $this->queryTable("Contact", $query, $return);

        echo "<pre>"; print_r($return_contact); echo "</pre>";
        return $return_contact;
    }

    public function deDupeContact($id=null, array $data){
        $table_name = "Contact";
        if($id == null){
            #check if email exists in the data array, which can be checked in the INFS 
            if(isset($data["Email"]) && $data["Email"] != ""){
                $return_contact = $this->queryTable($table_name, array("Email"=>$data["Email"]), false);

                if(count($return_contact) > 0 && isset($return_contact[0]["Id"])){
                    $id = $return_contact[0]["Id"];
                }
            }
        }
        #save the data 

        try {
            $obj = $this->getObject($table_name, $id, $this->app);
            foreach($data as $key=>$value){
                $obj->$key = $value;
            }

            $obj->save($this->app);
        }
        catch(\App\Services\Infusionsoft\Infusionsoft_Exception $e) {
            if(strpos(strtolower($e->getMessage()), "recordnotfound") > 0) {
                $id = null;

                if(isset($data["Email"]) && $data["Email"] != ""){
                    $return_contact = $this->queryTable($table_name, array("Email"=>$data["Email"]), false);

                    if(count($return_contact) > 0 && isset($return_contact[0]["Id"])){
                        $id = $return_contact[0]["Id"];
                    }
                }

                if($id == null) {
                    $obj = $this->getObject($table_name, $id, $this->app);
                    foreach($data as $key=>$value){
                        $obj->$key = $value;
                    }

                    $obj->save($this->app);
                }
                
            }
        }

        if($id == null){
            $id = $obj->Id;
        }
        
        return $id;
    }

    public function deDupeTagCategory($tagCategory=""){

        $table_name = "ContactGroupCategory";
        if($tagCategory != ""){
            $return_data = $this->queryTable($table_name, array("CategoryName"=>$tagCategory), array("Id"));

            if(count($return_data) > 0 && isset($return_data[0]["Id"])){
                return $return_data[0]["Id"];
            }
            else{ #add the tag category
                #save the data 
                $obj = $this->getObject($table_name, null, $this->app);
                $obj->CategoryName=$tagCategory;
                $obj->save($this->app);
                return $obj->Id;
            }
        }

        return 0;
    }

    public function deDupeTag($tagname="", $tagCategory=null){

        $table_name = "ContactGroup";
        if($tagname != ""){
            $query = array("GroupName"=>$tagname);
            if($tagCategory != null && $tagCategory > 0){
                $query["GroupCategoryId"] = $tagCategory;
            }
            $return_data = $this->queryTable($table_name, $query, array("Id"));

            if(count($return_data) > 0 && isset($return_data[0]["Id"])){
                return $return_data[0]["Id"];
            }
            else{ #add the tag category
                #save the data 
                $obj = $this->getObject($table_name, null, $this->app);
                $obj->GroupName=$tagname;
                
                if($tagCategory != null && $tagCategory > 0) $obj->GroupCategoryId=$tagCategory;

                $obj->save($this->app);
                return $obj->Id;
            }
        }

        return 0;
    }

    public function fetchCard($id=null, $ContactId=null, $Status=null, $Last4=null, $ExpiratonMonth=null, $ExpirationsYear=null, $orderBy="Id", $order=true){
        $table_name = "CreditCard";
        $query = [];
        if($id != null && !empty($id)){
            $query["Id"] = $id;
        }
        if($ContactId != null && !empty($ContactId)){
            $query["ContactId"] = $ContactId;
        }
        if($Status != null && !empty($Status)){
            $query["Status"] = $Status;
        }
        if($Last4 != null && !empty($Last4)){
            $query["Last4"] = $Last4;
        }
        if($ExpiratonMonth != null && !empty($ExpiratonMonth)){
            $query["ExpirationMonth"] = $ExpiratonMonth;
        }
        if($ExpirationsYear != null && !empty($ExpirationsYear)){
            $query["ExpirationYear"] = $ExpirationsYear;
        }
        
        if(count($query) == 0) return array();
        
        $return = ["ContactId", "NameOnCard", "Id", "Last4", "Status", "ExpirationMonth", "ExpirationYear"];
        return $this->queryTable($table_name, $query, $return, 1000, -1, "Id", true);
        
    }

    public function deDupeCard($id = null, $data=array()){

        $table_name = "CreditCard";
        if(!isset($data["CardNumber"])) return 0;

        $Last4 = substr($data["CardNumber"], -4, 4);

        #save the data 
        $obj = $this->getObject($table_name, $id, $this->app);

        foreach($data as $key=>$value){
            $obj->$key = $value;
        }

        $obj->save($this->app);

        if($id == null){
            $id = $obj->Id;
        }

        return $id;
    }

    public function blankOrder($ContactId, $order_desc, $order_date=""){

        $table_name = "Job";
        
        if($order_date == "") $order_date=date("Y-m-d H:i:s");

        #save the data 
        $obj = $this->getObject($table_name, null, $this->app);

        $obj->ContactId = $ContactId;
        $obj->JobTitle = $order_desc;
        $obj->JobNotes = $order_desc;
        $obj->StartDate = $order_date;

        $obj->save($this->app);

        return $obj->Id;

    }

    public function addOrderItem($OrderId, $ProductId, $ItemType, $price, $quantity, $description="", $notes=""){
        
        $table_name = "OrderItem";

        #save the data 
        $obj = $this->getObject($table_name, null, $this->app);

        $obj->OrderId = $OrderId;
        $obj->ProductId = $ProductId;
        $obj->ItemType = $ItemType;
        $obj->PPU = (double)$price;
        $obj->Qty = $quantity;
        $obj->ItemDescription = $description;
        $obj->Notes = $notes;

        $obj->save($this->app);

        return $obj->Id;

    }

    public function chargeInvoice($InvoiceId, $invoiceNotes, $cardId, $merchantAccountId, $bypassCommissions=false){
        $result = \App\Services\Infusionsoft\Infusionsoft_InvoiceService::chargeInvoice($InvoiceId, $invoiceNotes, $cardId, $merchantAccountId, $bypassCommissions, $this->app);

        return $result;

    }

    public function addManualPayment($invoiceId, $amount, $PayDate="", $PayType="", $invoiceNotes="", $bypassCommissions=false){
        $result = \App\Services\Infusionsoft\Infusionsoft_InvoiceService::addManualPayment($invoiceId, $amount, $PayDate, $PayType, $invoiceNotes, $bypassCommissions, $this->app);

        return $result;

    }
    
    public function optIn($Email, $OptInReason="Opted In as per request"){
        $result = \App\Services\Infusionsoft\Infusionsoft_APIEmailService::optIn($Email, $OptInReason, $this->app);
        return $result;
    }
    
    public function optOut($Email, $OptOutReason="Opted Out as per request"){
        $result = \App\Services\Infusionsoft\Infusionsoft_APIEmailService::optOut($Email, $OptOutReason, $this->app);
        return $result;
    }

    public function getOptStatus($Email){
        $result = \App\Services\Infusionsoft\Infusionsoft_APIEmailService::getOptStatus($Email, $this->app);
        return $result;
    }

    public function grpAssign($ContactId, $GroupId){
        try{
            $result = \App\Services\Infusionsoft\Infusionsoft_ContactService::addToGroup($ContactId, $GroupId, $this->app);
        } catch (Infusionsoft_Exception $e) {
            \Log::error("Add Tag Error Contact ID: ".$ContactId." | Error:".print_r($e->getMessage(),true));
            $result = $ContactId;
        }

        return $result;
    }

    public function grpRemove($ContactId, $GroupId){
        try{
            $result = \App\Services\Infusionsoft\Infusionsoft_ContactService::removeFromGroup($ContactId, $GroupId, $this->app);
        } catch (Infusionsoft_Exception $e) {
            \Log::error("Remove Tag Error Contact ID: ".$ContactId." | Error:".print_r($e->getMessage(),true));
            $result = $ContactId;
        }
        return $result;
    }

    public function findByEmail($email, $fields){
        $result = \App\Services\Infusionsoft\Infusionsoft_ContactService::findByEmail($email, $fields, $this->app);
        return $result;
    }

}