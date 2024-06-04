@extends('layouts.app')
@section('content')
    <form method="post" action="/purchases/delete">
        @csrf
        <div class="card m-2 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h4 class="fw-normal">Объявления</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-dark" type="submit">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @foreach($adverts as $advert)
                    <div class="container my-1">
                        <div class="row">
                            <div class="col-auto">
                                <input name="check[]" type="checkbox" value="{{$advert->id}}">
                                <img class="advert-img" src="/storage/{{$advert->image}} " alt="" height="100"/>
                            </div>
                            <div class="col">
                                <div class="row">
                                    {{$advert->title}}
                                </div>
                                <div class="row">
                                    {{$advert->price}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <input type="button" value="Редактировать"
                                       onclick="window.location.href='{{ route(\App\RouteName::ADVERT_SHOW_EDIT_FORM )}}?id={{$advert->id}}'"/>
                            </div>
                        </div>
                        <div class="row  mt-1" style="height: 1px; background: rgba(0,0,0,0.09);"></div>
                    </div>

                @endforeach
            </div>
        </div>
    </form>
@endsection
