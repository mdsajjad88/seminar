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

        .select2-container--default .select2-selection--single {
            height: 40px;
            line-height: 40px;
            text-align: left;
            padding-top: 5px;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="p-8">
        <div class="max-w-xl md:max-w-none mx-auto awcbg opacity-8 p-6 rounded-md shadow-xl">
            <h1 class="text-3xl text-white font-semibold mb-6 text-center">Dr. Haque's Seminar Registration Form</h1>
            <h2 class="text-2xl text-white bg-red-600 font-semibold mb-6 py-2 text-center">Registration Only 80 Persons</h2>
            <div class="text-white text-center">
                <span class="text-2xl"></span> সেমিনার ফিঃ 499 টাকা ।
                <br>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Text Content -->
                <div class="order-2 md:order-1">
                    <div class="text-white">
                        ✅ ৩০% ডিসকাউন্টে ডক্টর কনসালটেশন । <br>
                        ✅ ফ্রি পুষ্টিবিদের পরামর্শ । <br>
                        ✅ ফ্রি ফুড গাইডলাইন । <br>
                        ✅ সকল টেস্টে ৩০% ডিসকাউন্ট। <br>
                        ✅ ওজন থেরাপিতে ২০% ডিসকাউন্ট। <br>
                        ✅ “গ্রীন কিচেন” রেস্টুরেন্টে ১০% ছাড়। <br>
                        ✅ আবাসিক ভর্তিতে ৫০% ছাড় । <br>
                        ✅ "জিও ন্যাচারালস"এর প্রডাক্টে ১০% ছাড় । <br>
                        Mobile: <a href="tel:09666-747470">09666-747470</a>
                        <br> Web: <a href="https://awcbd.org/" target="__blank">https://awcbd.org</a>
                    </div>
                </div>
                <!-- Image Content -->
                <div class="flex justify-center items-center order-1 md:order-2">
                    <img class="h-auto max-w-full rounded-lg"
                        src="https://i.ibb.co/pWXxRPL/344935355-913595823411401-1126604170863478250-n.jpg" alt="">
                </div>
            </div>


            <div class="my-3 text-center">
                If already registered <a class="text-white" href="{{ route('seeinfo') }}">click here</a>
            </div>

            <form id="seminarRegistrationForm" action="{{ route('payment.process') }}" method="post">
                @csrf
                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-900 font-bold text-xl mb-2">নাম<span
                            class="text-red-500">*</span></label>
                    <input required type="text" id="name" name="name"
                        class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Mobile Field -->
                <div class="mb-4">
                    <label for="mobile" class="block text-gray-900 font-bold text-xl mb-2">মোবাইল নাম্বার<span
                            class="text-red-500">*</span></label>
                    <input required type="number" id="mobile" name="mobile"
                        class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Primary Disease Selection -->
                <div class="mb-4">
                    <label for="primary_diseases_id" class="block text-gray-900 font-bold text-xl mb-2">আপনি কি রোগে
                        ভুগতেছেন<span class="text-red-500">*</span></label>
                    <select name="primary_diseases_id" id="primary_diseases_id" class="primary_diseases_id"
                        style="width: 100%; height: 100px;" required>
                        <option value="">আপনার রোগের নাম নির্বাচণ করুন </option>
                        @foreach ($primaryDiseases as $disease)
                            <option value="{{ $disease->id }}">
                                {{ $disease->condition_name }}/{{ $disease->bangla_meaning }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Secondary Disease Selection -->
                <div class="mb-4">
                    <label for="secondary_diseases_id" class="block text-gray-900 font-bold text-xl mb-2">সেকেন্ডারি রোগের
                        নাম নির্বাচণ করুন <span class="text-red-500">*</span></label>
                    <select name="secondary_diseases_id" id="secondary_diseases_id" class="secondary_diseases_id"
                        style="width: 100%" required>
                        <option value="">সেকেন্ডারি রোগের নাম নির্বাচণ করুন </option>
                        @foreach ($secondaryDiseases as $disease2)
                            <option value="{{ $disease2->id }}">
                                {{ $disease2->condition_name }}/{{ $disease2->bangla_meaning }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Division and District Selection -->
                <div class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Division Dropdown -->
                        <div>
                            <label for="division_id" class="block text-gray-900 font-bold text-lg mb-2">
                                বিভাগ নির্বাচন করুন <span class="text-red-500">*</span>
                            </label>
                            <select name="division_id" id="division_id" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" required>
                                <option value="">আপনার বিভাগ নির্বাচন করুন</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}/{{ $division->bn_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- District Dropdown -->
                        <div>
                            <label for="district_id" class="block text-gray-900 font-bold text-lg mb-2">
                                জেলা নির্বাচন করুন <span class="text-red-500">*</span>
                            </label>
                            <select name="district_id" id="district_id" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" required>
                                <option value="">আপনার জেলা নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex-1">
                        <label for="upazila_id" class="block text-gray-900 font-bold text-lg mb-2">উপজেলা নির্বাচন করুন
                            <span class="text-red-500">*</span></label>
                        <select name="upazila_id" id="upazila_id" class="upazila_id" style="width: 100%" required>
                            <option value="">আপনার উপজেলা নির্বাচন করুন</option>

                        </select>
                    </div>
                </div>
                <!-- Address Field -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-900 font-bold text-xl mb-2">ঠিকানা</label>
                    <textarea id="address" name="address"
                        class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <!-- Age Field -->
                <div class="mb-4">
                    <label for="age" class="block text-gray-900 font-bold text-xl mb-2">বয়স<span
                            class="text-red-500">*</span></label>
                    <input required type="text" id="age" name="age"
                        class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                </div>

                <!-- Comment Field -->
                <div class="mb-4">
                    <label for="comment" class="block text-gray-900 font-bold text-xl mb-2">মন্তব্য</label>
                    <textarea id="comment" name="comment"
                        class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" placeholder='আপনি ডাক্তার  "হক" কে কি প্রশ্ন করতে চান ?'></textarea>
                        <p id="word-count" class="text-white-500 text-sm mt-1">Word count: 0/50</p>

                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" id="submitBtn"
                        class="bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                        Register Now
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#seminarRegistrationForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                var name = $('#name').val();
                var mobile = $('#mobile').val();
                var age = $('#age').val();
                var comment = $('#comment').val();

                // Validate fields
                var isNameValid = validateField($('#name'), 'Please enter a valid name.');
                var isMobileValid = validateField($('#mobile'),
                    'The phone number must start with 01 and have a length of 11 characters',
                    /^01\d{9}$/);
                var isAgeValid = validateField($('#age'), 'Please enter a valid age.');

                if (!isNameValid || !isMobileValid || !isAgeValid) {
                    return;
                }

                $('#seminarRegistrationForm').unbind('submit').submit();
            });

            function validateField(element, errorMessage, regex) {
                var value = element.val();
                if (regex && !regex.test(value) || !value.trim()) {
                    showValidationError(element, errorMessage);
                    return false;
                } else {
                    clearValidationError(element);
                    return true;
                }
            }

            function showValidationError(element, errorMessage) {
                element.css('border-color', 'red');
                var errorSpan = element.next('.validation-error');
                if (!errorSpan.length) {
                    errorSpan = $('<span class="validation-error"></span>').css({
                        'font-size': '18px',
                        'color': 'maroon',
                    });
                    element.after(errorSpan);
                }
                errorSpan.text(errorMessage);
            }

            function clearValidationError(element) {
                element.css('border-color', '');
                element.next('.validation-error').remove();
            }

            $('#primary_diseases_id').select2({
                placeholder: "আপনার রোগ নির্বাচন করুন",
            });

            $('#secondary_diseases_id').select2({
                placeholder: "আপনার রোগ নির্বাচন করুন",
            });
            $('#district_id').select2({
                placeholder: "জেলা নির্বাচন করুন",
            });
            $('#division_id').select2({
                placeholder: "বিভাগ নির্বাচন করুন",
            });
            $('#upazila_id').select2({
                placeholder: "উপজেলা নির্বাচন করুন ",
            });
            $('#division_id').on('change', function() {
                let divisionId = $(this).val();
                $('#district_id').empty().append('<option value="">Select Area</option>');

                if (divisionId) {
                    let url = '{{ route('get.district', ':divisionId') }}';
                    url = url.replace(':divisionId', divisionId);
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, zila) {
                                    $('#district_id').append('<option value="' + zila
                                        .id + '">' + zila.name + '/' + zila
                                        .bn_name + '</option>');
                                });
                            } else {
                                $('#district_id').append(
                                    '<option value="">No areas available</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching upazilas: ", error);
                            $('#district_id').append(
                                '<option value="">Error loading areas</option>');
                        }
                    });
                } else {
                    $('#district_id').empty().append('<option value="">Select Area</option>');
                }
            });
        });
        $('#district_id').on('change', function() {
            let districtId = $(this).val();
            $('#upazila_id').empty().append('<option value="">Select Area</option>');

            if (districtId) {
                let url = '{{ route('get.upazila', ':districtId') }}';
                url = url.replace(':districtId', districtId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(key, upazila) {
                                $('#upazila_id').append('<option value="' + upazila
                                    .id + '">' + upazila.name + '/' + upazila.bn_name +
                                    '</option>');
                            });
                        } else {
                            $('#upazila_id').append(
                                '<option value="">No areas available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching upazilas: ", error);
                        $('#upazila_id').append(
                            '<option value="">Error loading areas</option>');
                    }
                });
            } else {
                $('#upazila_id').empty().append('<option value="">Select Area</option>');
            }
        });
        $(document).ready(function () {
    const maxWords = 50;

    $("#comment").on("input", function () {
        let text = $(this).val();
        let words = text.trim().split(/\s+/); // Split text by spaces to count words
        let wordCount = words.filter(word => word.length > 0).length; // Exclude empty strings

        if (wordCount > maxWords) {
            // Trim the text to the allowed number of words
            $(this).val(words.slice(0, maxWords).join(" "));
            wordCount = maxWords;
        }

        // Update word count display
        $("#word-count").text(`Word count: ${wordCount}/${maxWords}`);
    });
});

    </script>
@endsection

</body>

</html>
