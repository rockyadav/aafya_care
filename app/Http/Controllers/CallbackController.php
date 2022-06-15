<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Callback;
use App\Http\Controllers\HomeController;

class CallbackController extends Controller
{
    //
    function confirm(Request $request)
    {

        $gatewayresult = $request->all();
        $Body = $gatewayresult['Body'];
        $stkCallback = $Body['stkCallback'];
        if($stkCallback['ResultDesc'] == "The service request is processed successfully." && $stkCallback['ResultCode'] == "0")
        {
            $CallbackMetadata = $stkCallback['CallbackMetadata'];
            $BillReceiptNo = $stkCallback['CheckoutRequestID'];
            $item = $CallbackMetadata['Item'];
            $amount = $item[0]['Value'];

            // Get Bill Details 
            $method = "GET";
            $url = "http://zetatest.elabassist.com/Services/Test_RegnService.svc/GetBillRecieptDtls_Global?BillRecieptNo=$BillReceiptNo&LabID=a76aeb22-c144-4748-a75c-9ba45ea80d8c";
            $mydata = $this->callAPI($method, $url, 1);
            $result = json_decode($mydata, true);
            $result = $result["d"];

            $TestRegnID = $result['TestRegnID'];
            $TotalAmount = $result['TotalAmount'];
            $UserID = $result['UserID'];

            // UPDATE PAYMENT
            $paymentUpdation = [
                "objBillRecieptClass" => [
                  "TestRegnID" => $TestRegnID,
                  "AmountPaid" => $amount,
                  "TotalAmount"=> $TotalAmount,
                  "CurrentPayAmt" => $amount,
                  "BillReceiptNo"=> $BillReceiptNo,
                  "Task" => 3,
                  "PaymentMethodType" => "7",
                  "UserID" => $UserID,
                  "LabID" => "a76aeb22-c144-4748-a75c-9ba45ea80d8c"    // TEST_LAB_ID
                ]
              ];  
          
              $postdata = json_encode($paymentUpdation);
              $method = "POST";
              $url = "http://zetatest.elabassist.com/Services/Test_RegnService.svc/UpdateTestRegnBalAmt";
              $mydata = $this->callAPI($method, $url, $postdata);
              echo $mydata;
        }
    }

    public function callAPI($method, $url, $data = false)
    {
      $curl = curl_init();  
      switch ($method) {
        case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
        case "GET":
          // curl_setopt($curl, CURLOPT_POST,1);
          break;
      }
      curl_setopt($curl, CURLOPT_URL, $url);
      /* Define Content Type */
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('content-type:application/json'));
      /* Return JSON */
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // /* new connection instead of cached one */
      // curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
      $result = curl_exec($curl);
      curl_close($curl);
      return $result;
    }
}
