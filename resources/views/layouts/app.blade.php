<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    {{--    <link rel="preconnect" href="https://fonts.bunny.net">--}}
    {{--    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>--}}
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="/bootstrap.css">
    <link rel="stylesheet" href="/my.css">

</head>

<body class="antialiased">
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}

</body>
@include('inc.header')
@yield('content')

@if (session('alert'))
    <div id="resultModal">
        <div class="modal fade d-flex justify-content-center align-items-center show" tabindex="-1" role="dialog"
             aria-labelledby="resultModalLabel" aria-hidden="true" style="display: block; background-color: #aaaaaaaa">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">  {{session('alert.title')}}</h5>
                    </div>
                    <div class="modal-body">
                        {{session('alert.text')}}
                    </div>
                    <div class="modal-footer">
                        <button id="closeButton" type="button" onclick="resultModal.innerHTML = '';"
                                class="btn btn-secondary">Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</html>
