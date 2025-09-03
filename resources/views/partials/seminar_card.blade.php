    <div class="card h-100">
        <img src="{{ $seminar['banner_img'] }}" class="card-img-top" alt="{{ $seminar['name'] }}" />
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $seminar['name'] }}</h5>
            <p class="card-text">
                <!-- Optional: Add a short description or something here -->
            </p>
            <a href="{{ action([\App\Http\Controllers\SeminarRegistrationController::class, 'showFormDetails'], [$seminar['id']]) }}"
                class="btn btn-primary mt-auto w-100">Register Here</a>
        </div>
    </div>
