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
    <link rel="stylesheet" href="/bootstrap.css" >
    <link rel="stylesheet" href="/my.css" >

</head>

<body class="antialiased">
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}

</body>
    @include('inc.header')
    @yield('content')

    @if (session('alert'))

        <div class="modal card mb-4 rounded-3 shadow-lg bg"
             style="width: 18rem; position: fixed; top: 50%;left: 50%; transform: translate(-50%, -50%);">
            <div class="card-header py-3 @if (session('alert.success')) bg-success @else bg-warning @endif">
                <h4 class="my-0 fw-normal">Внимание</h4>
            </div>
            <div class="card-body">

            </div>

            <div class="card-footer">
                <button id="closeButton" type="button" class="btn btn-secondary align-self-end" >Close</button>
            </div>
        </div>
    @endif

    @if (session('alert2'))

        <div class="modal fade d-flex justify-content-center align-items-center show" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true" style="display: block; background-color: #330a53be">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">  {{session('alert2.title')}}</h5>
                    </div>
                    <div class="modal-body">
                        {{session('alert2.text')}}
                    </div>
                    <div class="modal-footer">
                        <button id="closeButton" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




   @endif

</html>
