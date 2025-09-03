<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Seminar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="container-fluid">
        @php
            $count = count($seminarData);
        @endphp

        @if ($count === 1)
            {{-- শুধু ১টা seminar হলে center এ দেখাবে --}}
            <div class="row justify-content-center" style="margin-top: 10px">
                <div class="col-md-4">
                    @include('partials.seminar_card', ['seminar' => $seminarData[0]])
                </div>
            </div>
        @elseif ($count === 2)
            {{-- ২টা seminar হলে মাঝখানে ৪+৪ এবং দুই পাশে ২ করে ফাঁকা --}}
            <div class="row" style="margin-top: 10px">
                <div class="col-md-2"></div>
                @foreach ($seminarData as $seminar)
                    <div class="col-md-4">
                        @include('partials.seminar_card', ['seminar' => $seminar])
                    </div>
                @endforeach
                <div class="col-md-2"></div>
            </div>
        @else
            {{-- ৩ বা তার বেশি হলে প্রতি row তে ৩টা col-md-4 --}}
            <div class="row" style="margin-top: 10px">
                @foreach ($seminarData as $index => $seminar)
                    <div class="col-md-4 mb-4">
                        @include('partials.seminar_card', ['seminar' => $seminar])
                    </div>
                    @if (($index + 1) % 3 == 0)
                        </div><div class="row">
                    @endif
                @endforeach
            </div>
        @endif
    </div>
    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
