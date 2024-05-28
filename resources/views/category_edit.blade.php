@extends('layouts.app')
@section('content')

    <div class="card mb-4 rounded-3 shadow-sm"
         style="width: 28rem; position: fixed; top: 50%;left: 50%; transform: translate(-50%, -50%);">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Редактирование категории</h4>
        </div>
        <div class="card-body">

            <form method="post" action="{{ route(\App\RouteName::CATEGORY_CHANGE) }}" enctype="multipart/form-data">
                @csrf

                @foreach(['title'] as $errorKey)
                    @error($errorKey)
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endforeach

                <input name="id" id="id" type="hidden" value="{{ $category->id }}"/>
                <div>Наименование</div>
                <input name="name" id="name" class="form-control"
                       value="{{ $category->name }}"/><br>

{{--                <div>Раздел</div>--}}
{{--                <select class="form-control" id="section" name="section">--}}
{{--                    <option value="0" {{ $category->type == 0 ? 'selected' : '' }} >Баннер</option>--}}
{{--                    <option value="1" {{ $category->type == 1 ? 'selected' : '' }} >Курсы</option>--}}
{{--                    <option value="2" {{ $category->type == 2 ? 'selected' : '' }} >Оборудование</option>--}}
{{--                    <option value="3" {{ $category->type == 3 ? 'selected' : '' }} >Инстркменты</option>--}}
{{--                    <option value="4" {{ $category->type == 4 ? 'selected' : '' }} >Лектора</option>--}}
{{--                </select> <br>--}}



                <button type="submit" class="my-3 w-100 btn btn-lg btn-primary">Изменить</button>
            </form>
        </div>
    </div>
@endsection
