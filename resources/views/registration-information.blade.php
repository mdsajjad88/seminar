@extends('main')
@section('title', 'Appointment Form')
@section('styles')
@endsection
@section('content')
    <div class="min-h-screen py-10 bg-gray-300">


        <div class=" max-w-md mx-auto awcbg opacity-8 p-6 rounded-md shadow-xl">
            <h2 class="text-xl font-semibold text-center text-teal-500">{{ $registration->name }}, Thanks For Registrations</h2>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Registration Details</h2>
                <a href="{{url('/')}}" class="text-blue-500">Back</a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Name:</p>
                    <p class="font-semibold">{{ $registration->name }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Mobile:</p>
                    <p class="font-semibold">{{ $registration->mobile }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Diseases:</p>
                    <p class="font-semibold">{{ $registration->diseases }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Address:</p>
                    <p class="font-semibold">{{ $registration->address }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Invoice Number:</p>
                    <p class="font-semibold">{{ $registration->invoice_number }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Age:</p>
                    <p class="font-semibold">{{ $registration->age }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Comment:</p>
                    <p class="font-semibold">{{ $registration->comment }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Transaction ID:</p>
                    <p class="font-semibold">{{ $registration->trx_id }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Status:</p>
                    <p class="font-semibold">{{ $registration->status }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
