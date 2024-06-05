@extends('layouts.app')
@section('content')
    <form method="post" action="/purchase/delete">
        @csrf
        <div class="card m-2 rounded-3">
            <div class="card-header py-3">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h4 class="fw-normal">Покупки</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-dark" type="submit">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="container my-1">
                    <table style="width:100%">
                        <tr>
                            <th></th>
                            <th>Email</th>
                            <th>Объявление</th>
                            <th class="ta-c">Количество</th>
                            <th class="ta-c">Статус</th>
                        </tr>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td class="ta-c"> <input name="check[]" type="checkbox" value="{{$purchase->id}}"></td>
                                <td>{{$purchase->email}}</td>
                                <td>{{$purchase->title}}</td>
                                <td class="ta-c">{{$purchase->count}}</td>
                                <td class="ta-c">{{ \App\Http\Controllers\AppConst::$purchaseStatus[$purchase->state]}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </form>
@endsection
