@extends('layouts.app')
@section('content')
    <form method="post" action="/category/delete">
        @csrf
        <div class="card m-2 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h4 class="fw-normal">Категории</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-dark"
                                    onclick="window.location.href = '{{ route(\App\RouteName::CATEGORY_SHOW_CREATE_FORM) }}'; return false;">
                                Добавить
                            </button>
                            <button class="btn btn-outline-dark" type="submit">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @foreach($categories as $category)
                    <div class="container my-1">
                        <div class="row">
                            <div class="col-auto">
                                <input name="check[]" type="checkbox" value="{{$category->id}}">
                            </div>
                            @if($category->parent_id != null )
                                &nbsp;
                                &nbsp;
                                &nbsp;
                            @endif
                            <div class="col-2">
                                {{$category->name}}
                            </div>
                            <div class="col">
                                {{$category->level}}
                            </div>
                            <div class="col-auto">
                                <input type="button" value="Редактировать"
                                       onclick="window.location.href='{{ route(\App\RouteName::CATEGORY_SHOW_EDIT_FORM )}}?id={{$category->id}}'"/>
                            </div>
                        </div>
                        <div class="row  mt-1" style="height: 1px; background: rgba(0,0,0,0.09);"></div>
                    </div>

                @endforeach
            </div>
        </div>
    </form>
@endsection
