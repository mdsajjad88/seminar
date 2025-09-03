@extends('main')
@section('title', 'Registration Form')
@section('content')
    <div class="container-fluid">
        @foreach ($seminarData as $seminar)
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title text-center">{{ $seminar['name'] }}</h4>
                            <h5 class="card-title text-center">Maximum Participant : {{ $seminar['patient_allow_count'] }}
                                (Person)</h5>
                            <h5 class="card-title text-center">Seminar Fee : {{ $seminar['fee'] }} TK</h5>
                            <div class="row">
                                <div class="col-md-7">
                                    <div>
                                        {!! $seminar['description'] !!}
                                    </div>
                                    Mobile: {{ $seminar['mobile'] }} <br>
                                    Website: <a href="{{ $seminar['website_url'] }}" target="_blank"
                                        rel="noopener noreferrer">{{ $seminar['website_url'] }}</a>
                                </div>
                                <div class="col-md-5">
                                    <img src="{{ $seminar['banner_img'] }}" class="card-img" alt="{{ $seminar['name'] }}"
                                        style="max-width: 98%; height: 250px; margin-top: 20px" />
                                </div>
                            </div>
                            <h6 class="card-title text-center"><a href="{{ $seminar['already_registered_link'] }}"
                                    target="_blank" rel="noopener noreferrer">If Already Registered Click Here</a></h6>
                        </div>
                        <div class="card-body">
                            <form id="seminarRegistrationForm" action="{{ route('submit.seminar.registration.form') }}"
                                method="post">
                                @csrf
                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold fs-5">নাম<span
                                            class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" id="name" name="name"
                                        placeholder="আপনার নাম লিখুন">
                                </div>
                                <input type="hidden" name="seminar_id" value="{{ $seminar['id'] }}">
                                <input type="hidden" name="seminar_amount" value="{{ $seminar['fee'] }}">
                                <!-- Mobile Field -->
                                <div class="mb-3">
                                    <label for="mobile" class="form-label fw-bold fs-5">মোবাইল নাম্বার<span
                                            class="text-danger">*</span></label>
                                    <input required type="number" class="form-control" id="mobile" name="mobile"
                                        placeholder="আপনার মোবাইল নাম্বার লিখুন">
                                </div>

                                <!-- Primary Disease Selection -->
                                <div class="mb-3">
                                    <label for="primary_diseases_id" class="form-label fw-bold fs-5">আপনি কি রোগে
                                        ভুগতেছেন<span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="primary_diseases_id" id="primary_diseases_id"
                                        required>
                                        <option value="">আপনার রোগের নাম নির্বাচণ করুন</option>
                                        @foreach ($primaryDiseases as $disease)
                                            <option value="{{ $disease['id'] }}">{{ $disease['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Secondary Disease Selection -->
                                <div class="mb-3">
                                    <label for="secondary_diseases_id" class="form-label fw-bold fs-5">সেকেন্ডারি রোগের নাম
                                        নির্বাচণ করুন <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="secondary_diseases_id"
                                        id="secondary_diseases_id" required>
                                        <option value="">সেকেন্ডারি রোগের নাম নির্বাচণ করুন</option>
                                        @foreach ($primaryDiseases as $disease2)
                                            <option value="{{ $disease2['id'] }}">{{ $disease2['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Division and District Selection -->
                                <div class="mb-3">
                                    <div class="row g-3">
                                        <!-- Division Dropdown -->
                                        <div class="col-md-6">
                                            <label for="division_id" class="form-label fw-bold">বিভাগ নির্বাচন করুন <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select select2" name="division_id" id="division_id"
                                                required>
                                                <option value="">আপনার বিভাগ নির্বাচন করুন</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division['id'] }}">
                                                        {{ $division['name'] }}/{{ $division['bn_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- District Dropdown -->
                                        <div class="col-md-6">
                                            <label for="district_id" class="form-label fw-bold">জেলা নির্বাচন করুন <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select select2" name="district_id" id="district_id"
                                                required>
                                                <option value="">আপনার জেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="upazila_id" class="form-label fw-bold">উপজেলা নির্বাচন করুন <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" name="upazila_id" id="upazila_id" required>
                                        <option value="">আপনার উপজেলা নির্বাচন করুন</option>
                                    </select>
                                </div>

                                <!-- Address Field -->
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold fs-5">ঠিকানা</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder='আপনার ঠিকানা'></textarea>
                                </div>

                                <!-- Age Field -->
                                <div class="mb-3">
                                    <label for="age" class="form-label fw-bold fs-5">বয়স<span
                                            class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" id="age" name="age"
                                        placeholder="আপনার বয়স লিখুন">
                                </div>

                                <!-- Comment Field -->
                                <div class="mb-3">
                                    <label for="comment" class="form-label fw-bold fs-5">মন্তব্য</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"
                                        placeholder='আপনি ডাক্তার "হক" কে কি প্রশ্ন করতে চান ?'></textarea>
                                    <div id="word-count" class="form-text">Word count: 0/50</div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="submit" id="submitBtn"
                                        class="btn btn-primary bg-purple-600 px-4 py-2">
                                        Register Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        @endforeach
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

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

                var formData = $(this).serialize();

                // ভ্যালিডেশন যদি লাগে, আগে করো (তোর আগে যা ছিল)

                // Ajax কল
                $.ajax({
                    url: $(this).attr('action'), // ফর্মের action attribute থেকে URL নেবে
                    method: $(this).attr('method'), // POST method
                    data: formData,
                    beforeSend: function() {
                        $('#submitBtn').prop('disabled', true).text('Processing...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#seminarRegistrationForm')[0].reset();
                            $('.select2').val(null).trigger('change');
                            $('#word-count').text('Word count: 0/50');
                            window.location.href = baseUrl + '/seminar-payment-process?data=' + encodeURIComponent(JSON.stringify(response.data));

                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Registration Failed!',
                                text: response.msg,
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            let errorMessages = Object.values(errors).flat().join('\n');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessages,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong. Please try again.',
                            });
                        }
                    },
                    complete: function() {
                        $('#submitBtn').prop('disabled', false).text('Register Now');
                    }
                });
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
            $('#division_id').on('change', function() {
                let divisionId = $(this).val();
                $('#district_id').empty().append('<option value="">Select Area</option>');
                $('#upazila_id').empty().append('<option value="">Select Area</option>');

                if (divisionId) {
                    let url = 'http://192.168.11.15/Lacuna_main_only/public/api/get/district/' + divisionId;

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            if (response.success && response.data.length > 0) {
                                $.each(response.data, function(key, zila) {
                                    $('#district_id').append(
                                        '<option value="' + zila.id + '">' + zila
                                        .name + ' / ' + zila.bn_name + '</option>'
                                    );
                                });
                            } else {
                                $('#district_id').append(
                                    '<option value="">No areas available</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching districts: ", error);
                            $('#district_id').append(
                                '<option value="">Error loading areas</option>');
                        }
                    });
                } else {
                    $('#district_id').empty().append('<option value="">Select Area</option>');
                }
            });

            $('#district_id').on('change', function() {
                let districtId = $(this).val();
                $('#upazila_id').empty().append('<option value="">Select Area</option>');

                if (districtId) {
                    let url = 'http://192.168.11.15/Lacuna_main_only/public/api/get/upazila/' + districtId;
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            if (response.success && response.data.length > 0) {
                                $.each(response.data, function(key, upzila) {
                                    $('#upazila_id').append(
                                        '<option value="' + upzila.id + '">' +
                                        upzila
                                        .name + ' / ' + upzila.bn_name + '</option>'
                                    );
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

                const maxWords = 50;
                $("#comment").on("input", function() {
                    let text = $(this).val();
                    let words = text.trim().split(/\s+/); // Split text by spaces to count words
                    let wordCount = words.filter(word => word.length > 0)
                        .length; // Exclude empty strings

                    if (wordCount > maxWords) {
                        // Trim the text to the allowed number of words
                        $(this).val(words.slice(0, maxWords).join(" "));
                        wordCount = maxWords;
                    }

                    // Update word count display
                    $("#word-count").text(`Word count: ${wordCount}/${maxWords}`);
                });
            });
        });
    </script>
@endsection
