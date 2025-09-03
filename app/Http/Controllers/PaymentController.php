<?php

namespace App\Http\Controllers;

use App\Models\SeminarRegistration;
use Xenon\Paystation\Paystation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Http, Log};
use Illuminate\Support\Str;
class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:20',
                'address' => 'nullable|string',
                'age' => 'required|string',
                'primary_diseases_id' => 'required|int',
                'secondary_diseases_id' => 'required|int',
                'comment' => 'nullable|string',
                'division_id'=>'required',
                'district_id'=>'required',
                'upazila_id'=>'required',
            ]);
            $config = [
                'merchantId' => config('paystation.merchant_id'),
                'password' => config('paystation.merchant_password')
            ];

            $invoice_no ='AWC420'. rand(111111, 999999). time();
            $cust_name = $request->input('name');
            $cust_phone = $request->input('mobile');
            $cust_address = $request->input('address');
            $cust_age = $request->input('age');
            $cust_comment = $request->input('comment');
            $primary_diseases_id = $request->input('primary_diseases_id');
            $secondary_diseases_id = $request->input('secondary_diseases_id');
            $division_id = $request->input('division_id');
            $district_id = $request->input('district_id');
            $upazila_id = $request->input('upazila_id');

            $seminarRegistration = new SeminarRegistration();
            $seminarRegistration->invoice_number = $invoice_no;
            $seminarRegistration->name = $cust_name;
            $seminarRegistration->mobile = $cust_phone;
            $seminarRegistration->address = $cust_address;
            $seminarRegistration->age = $cust_age;
            $seminarRegistration->comment = $cust_comment;
            $seminarRegistration->primary_diseases_id = $primary_diseases_id;
            $seminarRegistration->secondary_diseases_id = $secondary_diseases_id;
            $seminarRegistration->division_id = $division_id;
            $seminarRegistration->district_id = $district_id;
            $seminarRegistration->upazila_id = $upazila_id;
            $seminarRegistration->save();

            $pay = new Paystation($config);
            $pay->setPaymentParams([
                'invoice_number' => $invoice_no,
                'currency' => "BDT",
                'payment_amount' => 499,
                'reference' => "AWC",
                'cust_name' => $cust_name,
                'cust_phone' => $cust_phone,
                'cust_email' => "awc@gmail.com",
                'cust_address' => $cust_address,
                'callback_url' => route('payment.verify'),
                'checkout_items' => "orderItems"
            ]);

            $pay->payNow(); //will automatically redirect to gateway payment page


        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            return redirect()->route('/')->with('error', $e->getMessage());
        }
    }

    public function verifyPayment(Request $request)
    {

        if ($request->trx_id == null) {
            return redirect()->back()->with('error', 'Transaction Failed!');
        }

        $config = [
            'merchantId' => config('paystation.merchant_id'),
            'password' => config('paystation.merchant_password')
        ];

        $pay = new Paystation($config);

        $responseData  = $pay->verifyPayment($request->invoice_number, $request->trx_id); //this will retrieve response as json

        $response = json_decode($responseData, true);

        if ($response['status'] == 'success' && $response['status_code'] == 200) {
            $callUrl = "http://192.168.11.15/Lacuna_main_only/public/api/update/seminar/payment/status/".$request->invoice_number.'/'.$request->trx_id;
            $callApi = Http::get($callUrl);

            $userData = SeminarRegistration::where('invoice_number',$request->invoice_number)->first();
            $userData->status = 'paid';
            $userData->trx_id= $request->trx_id;
            $userData->save();
            //store payment transaction and order information
            echo 'store payment transaction';

            return redirect()->route('seeinfo')->with('success', 'Registration successfully, Thank You');

        } else {
            return redirect()->route('/')->with('error', 'Transaction Failed!');
        }
    }
}
