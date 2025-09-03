<?php

namespace App\Http\Controllers;

use App\Models\SeminarRegistration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use App\Models\PrimaryDisease;
use App\Models\SecondaryDisease;
use Illuminate\Support\Facades\{Http, Log};
use Xenon\Paystation\Paystation;

class SeminarRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getSeminarRegistrations()
    {
        $registrations = SeminarRegistration::select(['id', 'name', 'mobile', 'diseases', 'address', 'age', 'comment', 'trx_id', 'status']);

        return DataTables::of($registrations)
            ->addColumn('action', function ($registration) {
                // Add any additional action buttons if needed
                return '<button class="btn btn-sm btn-info">View</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getRegistrationInformation(Request $request)
    {
        // Retrieve registration information based on mobile and trx_id
        $registration = SeminarRegistration::where('mobile', $request->input('mobile'))
            ->where('trx_id', $request->input('trx_id'))
            ->first();

        if ($registration) {
            // Return HTML with registration information
            return view('registration-information', compact('registration'));
        } else {
            // Return an error message
            return 'Registration not found.';
        }
    }
    public function showForm()
    {
        return view('seminar-registration-form');
    }
    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'diseases' => 'required|string|max:255',
            'address' => 'required|string',
            'age' => 'required|integer',
            'comment' => 'nullable|string',
        ]);

        $done = SeminarRegistration::create($validatedData);
        return redirect()->back()->with('success', 'Registration submitted successfully!');
        if ($done) {
            # code...
        } else {
            return redirect()->back()->with('error', 'Registration submitted successfully!');
            # code...
        }
    }
    public function index()
    {
        $registrations = SeminarRegistration::get();
        return view('home');
    }
    public function seeinfo()
    {
        return view('seeinfo');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submitSeminarForm(Request $request)
    {
        $data = $request->all();

        // API URL
        $apiUrl = 'http://192.168.11.15/Lacuna_main_only/public/api/store/seminar/information';
        $response = Http::post($apiUrl, $data);
        Log::info('Seminar Registration Response', ['response' => $response->json()]);
        if ($response->successful()) {
            $invoice_no = $response->json('invoice_no');
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
            $output = [
                'success' => true,
                'msg' => "Registration submitted successfully \nInvoice No: " . $response->json('invoice_no'),
                'data' => [
                    'invoice_no' => $invoice_no,
                    'cust_name' => $request->input('name'),
                    'cust_phone' => $request->input('mobile'),
                    'cust_address' => $request->input('address'),
                    'seminar_id' => $request->input('seminar_id'),
                    'fee' => $request->input('seminar_amount'),
                ]
            ];
        } else {
            $output = [
                'success' => false,
                'msg' => 'Registration failed! Please try again.'
            ];
            Log::error('API call failed', ['status' => $response->status(), 'body' => $response->body()]);
        }

        return response()->json($output);
    }
    public function seminarProcessPayment(Request $request)
    {

    $config = [
        'merchantId' => config('paystation.merchant_id'),
        'password' => config('paystation.merchant_password')
    ];

    // Decode the nested JSON payload from 'data' parameter
    $payload = json_decode($request->input('data'), true);

    if (!$payload) {
        Log::error('Failed to decode payment data', ['data' => $request->input('data')]);
        return response()->json(['error' => 'Invalid payment data'], 400);
    }

    $invoice_no = $payload['invoice_no'] ?? null;
    $cust_name = $payload['cust_name'] ?? null;
    $cust_phone = $payload['cust_phone'] ?? null;
    $cust_address = $payload['cust_address'] ?? null;
    $fee = $payload['fee'] ?? null;

        $pay = new Paystation($config);
        $pay->setPaymentParams([
            'invoice_number' => $invoice_no,
            'currency' => "BDT",
            'payment_amount' => $fee,
            'reference' => "AWC",
            'cust_name' => $cust_name,
            'cust_phone' => $cust_phone,
            'cust_email' => "awc@gmail.com",
            'cust_address' => $cust_address,
            'callback_url' => route('payment.verify'),
            'checkout_items' => "orderItems"
        ]);

        return $pay->payNow();
    }

    /**
     * Display the specified resource.
     */
    public function show(SeminarRegistration $seminarRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeminarRegistration $seminarRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeminarRegistration $seminarRegistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeminarRegistration $seminarRegistration)
    {
        //
    }
    public function getDistrict($divId)
    {
        $division = Division::find($divId);
        if (!$division) {
            return response()->json(['error' => 'Division not found'], 404);
        }

        $zilas = District::where('division_id', $divId)->get();
        return response()->json($zilas);
    }
    public function getUpazila($divId)
    {
        $district = District::find($divId);
        if (!$district) {
            return response()->json(['error' => 'District not found'], 404);
        }
        $zilas = Upazila::where('district_id', $divId)->get();
        return response()->json($zilas);
    }
    public function showRegistrationForm()
    {


        $seminarData = [];

        try {
            $response = Http::get('http://192.168.11.15/Lacuna_main_only/public/api/get/seminar/information');
            if ($response->successful()) {
                $body = $response->json();
                $seminarData = $body['success'] ? $body['data'] : [];
            } else {
                Log::error('Seminar API returned error', [
                    'url' => 'http://192.168.11.15/Lacuna_main_only/public/api/get/seminar/information',
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $seminarData = [];
            }
        } catch (\Throwable $e) {
            Log::error('Failed to call Seminar API', ['exception' => $e]);
            $seminarData = [];
        }

        return view('welcome', compact('seminarData'));
    }
    public function showFormDetails($id)
    {
        $primaryDiseasesResponse = Http::get('http://192.168.11.15/Lacuna_main_only/public/api/get/seminar/disease/')->json();
        $primaryDiseases = $primaryDiseasesResponse['success'] ? $primaryDiseasesResponse['data'] : [];

        $divisionsData = Http::get('http://192.168.11.15/Lacuna_main_only/public/api/get/division/')->json();
        $divisions = $divisionsData['success'] ? $divisionsData['data'] : [];
        $seminarData = [];

        try {
            $response = Http::get('http://192.168.11.15/Lacuna_main_only/public/api/get/seminar/information/' . $id);
            if ($response->successful()) {
                $body = $response->json();
                $seminarData = $body['success'] ? $body['data'] : [];
            } else {
                Log::error('Seminar API returned error', [
                    'url' => 'http://192.168.11.15/Lacuna_main_only/public/api/get/seminar/information',
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $seminarData = [];
            }
        } catch (\Throwable $e) {
            Log::error('Failed to call Seminar API', ['exception' => $e]);
            $seminarData = [];
        }

        return view('seminar_registration_form', compact('seminarData', 'primaryDiseases', 'divisions'));
    }
}
