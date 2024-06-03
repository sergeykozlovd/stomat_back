@extends('layouts.app')
@section('content')
    <form method="post" action="/advert/delete">
        @csrf
        <div class="card m-2 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h4 class="fw-normal">Объявления</h4>
                        </div>


                        <div class="col-auto">
                            <button class="btn btn-outline-dark" onclick="window.location.href = '{{ route(\App\RouteName::ADVERT_SHOW_CREATE_FORM) }}'; return false;" >Добавить</button>
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

    @if(session('not_deleted_adverts'))
        <div class="modal fade d-flex justify-content-center align-items-center show" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" role="document" style="box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">Adverts Deletion Result</h5>
                    </div>
                    <div class="modal-body">
                        The following adverts could not be deleted because they are in the purchase table: {{ implode(', ', session('not_deleted_adverts')->toArray()) }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var closeButton = document.getElementById('close');

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
