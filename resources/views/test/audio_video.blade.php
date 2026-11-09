@if($model->data['question']['type'] === 'video_with_text')
    <video src="{{$model->data['question']['image']}}"></video>
@endif

@if($model->data['question']['type'] === 'audio_with_text')
    @if(isset($model->data['question']['image']))
        <audio src="{{$model->data['question']['image']}}"></audio>
    @endif
@endif

@push('javascript')
    $('video, audio').mediaelementplayer();
@endpush
