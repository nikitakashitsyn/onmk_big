@extends('layouts.admin-top-sidebar')


@section("title")
    Общение с {{ $to?->name ?? $to?->login ?? 'Собеседник' }}
@endsection

@section("content")

    @include('messenger.form')

    @foreach($messages as $message)
        <div class="card">
            <div class="card-header">

                @if(($to?->id ?? null) == $message->user_id)
                    {{ $to?->name ?? $to?->login ?? 'Собеседник' }} написал  {{$message->created_at}}
                @else
                    Вы написали  {{$message->created_at}}
                @endif

            </div>
            <div class="card-body">
                {{$message->body}}
            </div>
        </div>
    @endforeach
@endsection

