@extends('layouts.app')
@section('content')

    <div class="card mb-4 rounded-3 shadow-sm"
         style="width: 28rem; position: fixed; top: 50%;left: 50%; transform: translate(-50%, -50%);">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Создание категории</h4>
        </div>
        <div class="card-body">

            <form method="post" action="{{ route(\App\RouteName::CATEGORY_CREATE) }}"  enctype="multipart/form-data">
                @csrf

                @foreach(['name', 'image'] as $errorKey)
                    @error($errorKey)
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endforeach

                <div>Наименование</div>
                <input class="form-control" name="name" id="name"/><br>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="section" name="section" >
                    <label class="form-check-label" for="section">Раздел</label>
                </div>
                <br>

                <div id="categorySection" >
                    <div>Раздел</div>
                    <select class="form-control" id="category" name="category" >
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select> <br>
                </div>

                <div id="imageSection" style="display: none">
                    <div>Кртинка</div>
                    <input name="image" id="image" class="form-control" type="file"><br>
                </div>

                <button type="submit" class="my-3 w-100 btn btn-lg btn-primary">Создать</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const switchElement = document.getElementById('section');
            const categorySection = document.getElementById('categorySection');
            const imageSection = document.getElementById('imageSection');

            switchElement.addEventListener('change', function() {
                if (switchElement.checked) {
                    categorySection.style.display = 'none'; // Hide
                    imageSection.style.display = 'block'; // Hide
                } else {
                    categorySection.style.display = 'block'; // Show
                    imageSection.style.display = 'none'; // Show
                }
            });
        });
    </script>
@endsection



