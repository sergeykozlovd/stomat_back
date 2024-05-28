<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="card mb-4 rounded-3 shadow-sm"
     style="width: 18rem; position: fixed; top: 50%;left: 50%; transform: translate(-50%, -50%);">
    <div class="card-header py-3">
        <h4 class="my-0 fw-normal">Authorization</h4>
    </div>
    <div class="card-body">

        <form method="post" action="/login">
            @csrf
            <input name="email" id="email" placeholder="Enter email" value="sergeykozlov.d@ya.ru" class="form-control"><br>
            @error('email')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror

            <input name="password" id="password" placeholder="Enter password" class="form-control" type="password"><br>
            @error('password')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror


            <button type="submit" class="w-100 btn btn-lg btn-primary">Sign In</button>
        </form>
    </div>
</div>
</body>
</html>

