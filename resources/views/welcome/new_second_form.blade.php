@extends('layouts.admin-top-sidebar')

@section('title')
    Основные жалобы
@endsection

@section("content")
    <form method="post" action="{{route('welcome.store_second')}}">
        @csrf
        @foreach($data as $i => $cat)
            <div class="card">
                <div class="card-header">
                    {{$cat['block']}}
                </div>
                <div class="card-body">
                    @foreach($cat['items'] as $j => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="assign[{{$i}}]" id="q{{$i}}{{$j}}" value="{{$j}}" @if(isset($model->jsonData['results'][$i]) && $model->jsonData['results'][$i] == ($j+1))checked="checked"@endif>
                            <label class="form-check-label" for="q{{$i}}{{$j}}">
                                {{$item}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection
