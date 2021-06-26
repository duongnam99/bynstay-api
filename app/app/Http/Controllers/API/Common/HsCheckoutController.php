<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Mail\MailOrder;
use App\Repositories\HomestayOrder\HomestayOrderRepositoryInterface;
use FasterPay\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

require_once(__DIR__.'/../../../../Libs/Payment/FasterPay/lib/autoload.php');

class HsCheckoutController extends BaseController
{
    protected $homestayOrderRepo;

    public function __construct(HomestayOrderRepositoryInterface $homestayOrderRepo)
    {
        $this->homestayOrderRepo = $homestayOrderRepo;
    }
    
    protected function initGateway()
    {
        $gateway = new Gateway([
            'publicKey' => 't_0441721cc11450fe0e1f848bdd53ee',
            'privateKey' => 't_af91a1bd1a51a0c9718454a5475c24',
            'isTest' => 1,
        ]);

        return $gateway;
    }

    public function fasterPayCheckout(Request $request)
    {
        
        $gateway = $this->initGateway();
        
        $form = $gateway->paymentForm()->buildForm(
            [
                'description' => 'Test order',
                'amount' => $request->amount/23100,
                'currency' => 'USD',
                'merchant_order_id' => $request->merchant_order_id,
                'success_url' => $this->buildSuccessUrl($request->hs_id, $request->merchant_order_id),
                // 'pingback_url' => 'https://yourcompanywebsite.com/pingback',
                'sign_version' => 'v2'
            ],
            [
                'autoSubmit' => false,
                'hidePayButton' => false
            ]
        );
        
        return response()->json(['pay' => $form]);
    }

    protected function buildSuccessUrl($hsId, $orderId)
    {
        return 'http://bynstayapp.azurewebsites.net/home-detail/'.$hsId.'/order/result?order_id='.$orderId;
    }

    public function pingback(Request $request)
    {
        $gateway = $this->initGateway();

        $signVersion = \FasterPay\Services\Signature::SIGN_VERSION_1;
        if (!empty($_SERVER['HTTP_X_FASTERPAY_SIGNATURE_VERSION'])) {
            $signVersion = $_SERVER['HTTP_X_FASTERPAY_SIGNATURE_VERSION'];
        }

        $pingbackData = null;
        $validationParams = [];

        switch ($signVersion) {
            case \FasterPay\Services\Signature::SIGN_VERSION_1:
                $validationParams = ["apiKey" => $_SERVER["HTTP_X_APIKEY"]];
                $pingbackData = $request->all();
                break;
            case \FasterPay\Services\Signature::SIGN_VERSION_2:
                $validationParams = [
                    'pingbackData' => $request->all(),
                    'signVersion' => $signVersion,
                    'signature' => $_SERVER["HTTP_X_FASTERPAY_SIGNATURE"],
                ];
            $pingbackData = $request->all();
            break;
                default:
                    exit('NOK');
            }

        if (empty($pingbackData)) {
            exit('NOK');
        }

        // if (!$gateway->pingback()->validate($validationParams)) {
        //     exit('NOK');
        // }
        
        $this->processOrder($pingbackData);
        $this->sendMail($pingbackData);
        exit();
    }

    public function processOrder($pingbackData)
    {
        $orderInfo = $pingbackData['payment_order'];
        $orderId = $orderInfo['merchant_order_id'];
        $result = $this->homestayOrderRepo->update($orderId, [
            'payment_status' => 1,
            'success_code' => $this->getRandomString(8)
        ]);

        if (!empty($result)) {
            die('OK');
        }
    }

    public function getRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
    
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $string;
    }

    protected function sendMail($pingbackData)
    {
        $orderId = $pingbackData['payment_order']['merchant_order_id'];

        $order = $this->homestayOrderRepo->find($orderId);
         
        return Mail::to($order['customer_email'])->send(new MailOrder($order));
   
        // if (Mail::failures()) {
        //      return response()->Fail('Sorry! Please try again latter');
        // }else{
        //      return response()->success('Great! Successfully send in your mail');
        // }
    }
}
