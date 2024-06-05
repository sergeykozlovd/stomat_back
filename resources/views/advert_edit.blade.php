@extends('layouts.app')
@section('content')

    <div class="card mb-4 rounded-3 shadow-sm"
         style="width: 28rem; position: fixed; top: 50%;left: 50%; transform: translate(-50%, -50%);">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Редактирование Объявления</h4>
        </div>
        <div class="card-body">

            <form method="post" action="{{ route(\App\RouteName::ADVERT_CHANGE) }}" enctype="multipart/form-data">
                @csrf

                @foreach(['title', 'image' , 'description', 'price'] as $errorKey)
                    @error($errorKey)
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endforeach

                <input name="id" id="id" type="hidden" value="{{ $advert->id }}"/>

                <dev>Заголовок</dev>
                <input name="title" id="title" class="form-control"
                       value="{{ $advert->title }}"/><br>

                <dev>Цена</dev>
                <input name="price" id="price"  class="form-control"
                       value="{{ $advert->price }}"/><br>


                <dev>Кртинка</dev>
                <input name="image" id="image"  class="form-control" type="file"  onchange="previewImage(event)"><br>
                <img id= "imagePreview" src="/storage/{{$advert->image}} " alt="" height="100" width="200"/><br><br>


                <dev>Категория</dev>
                <select class="form-control" id="category" name="category">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{ $advert->category->id == $category->id ? 'selected' : '' }} >{{$category->name}}</option>
                    @endforeach
                </select> <br>

                <dev>Описание</dev>
                <textarea class="form-control" id="description" name="description"
                          rows="5">{{ $advert->description }}</textarea>

                <button type="submit" class="my-3 w-100 btn btn-lg btn-primary">Готово</button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function () {
                const dataURL = reader.result;
                const preview = document.getElementById('imagePreview');
                preview.src = dataURL;
                // preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
