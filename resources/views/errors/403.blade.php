<title>403</title>
    <link rel="stylesheet" crossorigin href="{{ asset('template/dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('template/dist/assets/compiled/css/error.css') }}">
    <script src="{{ asset('template/dist/assets/static/js/initTheme.js') }}"></script>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('template/dist/assets/compiled/svg/error-403.svg') }}"
                        alt="Forbidden">
                    <h1 class="error-title">Forbidden</h1>
                    <p class="fs-5 text-gray-600">You are unauthorized to see this page.</p>
                    <a href="javascript:history.back()" class="btn btn-lg btn-outline-primary mt-3">Go Back</a>

                </div>
            </div>
        </div>
    </div>

