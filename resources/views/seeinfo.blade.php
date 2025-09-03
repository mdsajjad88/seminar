@extends('main')
@section('title', 'Appointment Form')
@section('styles')
    <style>
        .bgimg {
            background-image: url("{{ asset('assets/logo.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .awcbg {
            background-color: #229894;
        }
    </style>
@endsection
@section('content')
    <div class="p-8">


        <div class="max-w-md mx-auto awcbg opacity-8 p-6 rounded-md shadow-xl ">

            <div class="my-3 text-center">If Not registered <a class="text-white" href="{{ url('/') }}">click here</a>
            </div>

            <div class="text-center">
                <form action="{{ route('get_registration_information') }}" method="post">
                    <!-- Name Field -->
                    @csrf
                    <div class="text-xl my-4">
                        If already registered
                        <div class="mb-4">
                            <label for="mobile" class="block text-gray-900 font-bold text-xl mb-2">Mobile<span
                                    class="text-red-500">*</span></label>
                            <input required type="text" id="mobile" name="mobile"
                                class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="trx_id" class="block text-gray-900 font-bold text-xl mb-2">Transaction ID<span
                                    class="text-red-500">*</span></label>
                            <input required type="text" id="trx_id" name="trx_id"
                                class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="text-center">
                            <button type="submit" id="seeinformation"
                                class="bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                                See Information
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection


</body>

</html>
