@extends('layouts.app')
@section('content')
    <div style="display: flex; justify-content: center;">
        <div class="card mb-4 rounded-3 shadow-sm"
             style="width: 28rem;">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Добавление объявления</h4>
            </div>
            <div class="card-body">

                <form method="post" action="{{ route(\App\RouteName::ADVERT_CREATE) }}" enctype="multipart/form-data">
                    @csrf

                    @foreach(['title', 'image' , 'description'] as $errorKey)
                        @error($errorKey)
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    @endforeach

                    <div>Заголовок</div>
                    <input name="title" id="title" class="form-control"/><br>

                    <div>Цена</div>
                    <input name="price" id="price" class="form-control"/><br>

                    <div>Кртинка</div>

                    <input name="image" id="image" class="form-control" type="file" onchange="previewImage(event)"><br>
                    <img id="imagePreview" alt="Image Preview" height="100" style="display: none;"/>
                    <br>

                    <div>Категория</div>
                    <select class="form-control" id="category" name="category">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach

                    </select> <br>

                    <div>Описание</div>
                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>

                    <button type="submit" class="my-3 w-100 btn btn-lg btn-primary">Создать</button>
                </form>
            </div>
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
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection



