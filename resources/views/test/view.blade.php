<?php

use App\Models\Test;

?>
@extends('layouts.admin-top-sidebar')


@section("title")
    Проверка теста
@endsection

@section("content")

    @if($result)
        <div
            class="alert alert-info alert-dismissible">
            Вы набрали {{$points}}
            {{ Lang::choice('балл|балла|баллов', $points , [], 'ru')  ?? 0}}
            @if($errors)
                ({{$errors}}  {{ Lang::choice('ошибка|ошибок|ошибок', $errors , [], 'ru')  ?? 0}})
            @endif
        </div>
    @endif


    {{ Form::open() }}

    {{Form::hidden('question_id',$model->id ?? null)}}
    {{Form::hidden('exam_data_id',$examTest->id ?? null)}}

    @if($timeout = ($model->data['show_timeout']?? null))
        <div class="callout callout-danger timer-block">
            <div class="timer-text">
                Задание имеет ограничение по времени в {{$timeout}} секунд, подготовьтесь и нажмите кнопку "начать". По
                истечению времени задание скроется.
            </div>

            <button class="start-button">
                Начать тест
            </button>
        </div>
    @endif


    @if($timeout)
        <div class="d-none hidden-content" data-timeout="{{$timeout}}">
            @endif


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Задание</h3>
                </div>

                <div class="card-body">

                    @php
                        $tts =  $model->updateQuestionTts();
                    @endphp

                    @if($path = $model->getQuestionAudioUrl())
                        <a href="#"
                           class="btn btn-default js-audio-toggle"
                           id="playQuestion"
                           data-path="{{$path}}"
                           data-audio-control="true"
                           role="button"
                           aria-pressed="false"
                           aria-label="Воспроизвести задание"
                           title="Воспроизвести">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                    @endif

                    <div class="row">


                        @if(isset($model->data['question']['type']) && in_array($model->data['question']['type'],['text','text_with_image','video_with_text','audio_with_text']))
                            <div>
                                {{$model->data['question']['text'] ?? null}}
                            </div>
                        @endif

                        @if(isset($model->data['question']['type']) && in_array($model->data['question']['type'],['image','text_with_image']))
                            @if(isset($model->data['question']['image']))
                                <div class="col-md-12">
                                    <img src="{{$model->data['question']['image']}}" alt="" class="img-thumbnail"
                                         style="max-width: 30%">
                                </div>
                            @endif
                        @endif

                        @if(isset($model->data['question']['type']) && in_array($model->data['question']['type'], ['video_with_text','audio_with_text']))
                            @include('test.audio_video')
                        @endif

                        @if($model->type === Test::TYPE_TABLES_SCHULTE)
                            @include('test.schulte')
                        @endif

                    </div>

                </div>
            </div>
            @if($timeout)
        </div>
    @endif

    @if($timeout)
        <div class="d-none hidden-answers" data-timeout="{{$timeout}}">
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if($model->type === Test::TYPE_INPUT)
                            Впишите ответ
                        @else
                            Выберите ответ
                        @endif
                    </h3>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        @if($model->type === Test::TYPE_CHOICE)
                            <div class="row">
                                @if(isset($answers))
                                    @foreach($answers as $i=>$answer)
                                        @if(isset($answer['image']))
                                            <div class="col-sm-4 py-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            <img src="{{$answer['image']}}" alt=""
                                                                 class="img-thumbnail">
                                                            @if(isset($model->data['question']['multiple']) && $model->data['question']['multiple'] == "1")
                                                                <input type="checkbox" id="customRadio{{$i}}"
                                                                       value="{{$answer['text'] ?? $answer['image']}}"
                                                                       style="position: absolute;bottom:20px;left:20px"
                                                                       name="answer[]">
                                                            @else
                                                                <input type="radio" id="customRadio{{$i}}"
                                                                       value="{{$answer['text'] ?? $answer['image']}}"
                                                                       style="position: absolute;bottom:20px;left:20px"
                                                                       name="answer">
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-12 py-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            @if(isset($model->data['question']['multiple']) && $model->data['question']['multiple'] == "1")
                                                                <input class="custom-control-input" type="checkbox"
                                                                       id="customRadio{{$i}}"
                                                                       value="{{$answer['text']}}"
                                                                       style=""
                                                                       name="answer[]">
                                                            @else
                                                                <input class="custom-control-input" type="radio"
                                                                       id="customRadio{{$i}}"
                                                                       value="{{$answer['text']}}"
                                                                       style=""
                                                                       name="answer">
                                                            @endif
                                                            <label for="customRadio{{$i}}"
                                                                   class="custom-control-label ml-3">{{$answer['text']}}</label>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif


                        @if($model->type === Test::TYPE_INPUT)
                            <input class="form-control" type="text" name="answer">
                        @endif


                    </div>
                </div>
            </div>
            @if($timeout)
        </div>
    @endif
    {{ Form::submit('Дальше', array('class' => 'btn btn-success')) }}






    {{ Form::close() }}

    @role('ROLE_ADMIN')
    <p class="pt-3">
        <a href="{{ route('test.edit',$model->id) }}" target="_blank"
           class="btn btn-sm btn-danger">Редактировать</a>
    </p>
    @endrole

@endsection

@push('javascript')
    ;(function (window, document) {
        'use strict';

        if (window.TestAudioController && window.TestAudioController.__initialized) {
            return;
        }

        var DEBOUNCE_MS = 400;
        var BUTTON_SELECTOR = '[data-audio-control], .js-audio-toggle, #playQuestion';

        var controller = {
            __initialized: true,
            __eventsBound: false,
            debounceMs: DEBOUNCE_MS,
            currentAudio: null,
            currentButton: null,
            currentUrl: null,
            lastTriggerTime: 0,
            _hasTriggered: false,
            _cleanupHandlers: null,

            init: function () {
                if (this.__eventsBound) {
                    return this;
                }

                var self = this;

                document.addEventListener('click', function (event) {
                    var button = event.target && event.target.closest
                        ? event.target.closest(BUTTON_SELECTOR)
                        : null;

                    if (!button) {
                        return;
                    }

                    event.preventDefault();
                    self.handleButtonClick(button);
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key !== ' ' && event.key !== 'Spacebar') {
                        return;
                    }
                    var button = event.target && event.target.closest
                        ? event.target.closest(BUTTON_SELECTOR)
                        : null;

                    if (!button || button.tagName !== 'A') {
                        return;
                    }

                    event.preventDefault();
                    self.handleButtonClick(button);
                });

                document.addEventListener('play', function (event) {
                    var target = event.target;
                    if (!target || (target.tagName !== 'AUDIO' && target.tagName !== 'VIDEO')) {
                        return;
                    }

                    // A DOM <audio>/<video> (e.g. mediaelementplayer) started playing.
                    // Stop the TestAudioController's own Audio() if it was active,
                    // but do NOT call _pauseOtherDomMedia here — it would fight with
                    // mediaelementplayer's internal seek→pause→play cycle and prevent
                    // seeking in other DOM players.
                    if (self.currentAudio && target !== self.currentAudio) {
                        self.stop();
                    }
                }, true);

                window.addEventListener('pagehide', function () {
                    self.stop();
                });

                this.__eventsBound = true;
                return this;
            },

            _getAudioUrl: function (button) {
                if (!button) {
                    return '';
                }
                return (
                    button.getAttribute('data-audio-src') ||
                    button.getAttribute('data-path') ||
                    button.getAttribute('data-src') ||
                    ''
                ).trim();
            },

            _setButtonState: function (button, isPlaying) {
                if (!button) {
                    return;
                }

                if (!button.hasAttribute('data-play-title')) {
                    button.setAttribute(
                        'data-play-title',
                        button.getAttribute('title') || 'Воспроизвести'
                    );
                }
                if (!button.hasAttribute('data-play-label') && button.hasAttribute('aria-label')) {
                    button.setAttribute('data-play-label', button.getAttribute('aria-label'));
                }

                var icon = button.querySelector('i');
                if (icon) {
                    if (!icon.classList.contains('fa') && !icon.classList.contains('fas')) {
                        icon.classList.add('fa');
                    }
                    icon.classList.remove('fa-music');
                    icon.classList.toggle('fa-play', !isPlaying);
                    icon.classList.toggle('fa-pause', isPlaying);
                }

                button.classList.toggle('is-playing', isPlaying);
                button.setAttribute('aria-pressed', isPlaying ? 'true' : 'false');
                button.setAttribute(
                    'title',
                    isPlaying ? 'Пауза' : (button.getAttribute('data-play-title') || 'Воспроизвести')
                );

                if (button.hasAttribute('data-play-label')) {
                    button.setAttribute(
                        'aria-label',
                        isPlaying
                            ? (button.getAttribute('data-pause-label') || 'Приостановить воспроизведение')
                            : button.getAttribute('data-play-label')
                    );
                }
            },

            _pauseOtherDomMedia: function (exceptElement) {
                var mediaList = document.querySelectorAll('audio, video');
                for (var i = 0; i < mediaList.length; i++) {
                    var media = mediaList[i];
                    if (media !== exceptElement && !media.paused) {
                        try {
                            media.pause();
                        } catch (e) {
                            // Ignore pause errors on uninitialized media elements
                        }
                    }
                }
            },

            _resetAllButtons: function () {
                var buttons = document.querySelectorAll(BUTTON_SELECTOR);
                for (var i = 0; i < buttons.length; i++) {
                    this._setButtonState(buttons[i], false);
                }
            },

            stop: function () {
                var audio = this.currentAudio;
                var button = this.currentButton;
                var cleanup = this._cleanupHandlers;

                this.currentAudio = null;
                this.currentButton = null;
                this.currentUrl = null;
                this._cleanupHandlers = null;

                if (cleanup) {
                    cleanup();
                }

                if (audio) {
                    try {
                        audio.pause();
                    } catch (e) {
                        // Ignore pause errors
                    }
                    try {
                        if (typeof audio.readyState !== 'number' || audio.readyState > 0) {
                            audio.currentTime = 0;
                        }
                    } catch (e) {
                        // Ignore InvalidStateError when metadata is not loaded yet
                    }
                }

                if (button) {
                    this._setButtonState(button, false);
                }
            },

            handleButtonClick: function (button) {
                if (!button) {
                    return;
                }

                var now = Date.now();
                if (this._hasTriggered && (now - this.lastTriggerTime) < this.debounceMs) {
                    return;
                }
                this._hasTriggered = true;
                this.lastTriggerTime = now;

                var url = this._getAudioUrl(button);
                if (!url) {
                    this.stop();
                    return;
                }

                var isSamePlayingButton =
                    this.currentButton === button &&
                    this.currentAudio !== null &&
                    !this.currentAudio.paused &&
                    !this.currentAudio.ended;

                if (isSamePlayingButton) {
                    this.stop();
                    return;
                }

                this.play(button, url);
            },

            play: function (button, url) {
                var self = this;

                this.stop();
                this._resetAllButtons();
                this._pauseOtherDomMedia(null);

                if (!url) {
                    return;
                }

                var audio = new Audio(url);
                this.currentAudio = audio;
                this.currentButton = button;
                this.currentUrl = url;

                var onEnded = function () {
                    if (self.currentAudio === audio) {
                        self.stop();
                    }
                };

                var onPause = function () {
                    if (self.currentAudio === audio) {
                        self.stop();
                    }
                };

                var onError = function () {
                    if (self.currentAudio === audio) {
                        self.stop();
                    }
                };

                audio.addEventListener('ended', onEnded);
                audio.addEventListener('pause', onPause);
                audio.addEventListener('error', onError);

                this._cleanupHandlers = function () {
                    audio.removeEventListener('ended', onEnded);
                    audio.removeEventListener('pause', onPause);
                    audio.removeEventListener('error', onError);
                };

                this._setButtonState(button, true);

                try {
                    var playPromise = audio.play();
                    if (playPromise && typeof playPromise.catch === 'function') {
                        playPromise.catch(function (err) {
                            if (self.currentAudio === audio) {
                                self.stop();
                            }
                            if (err && err.name !== 'AbortError' && err.name !== 'NotAllowedError') {
                                if (window.console && typeof window.console.warn === 'function') {
                                    window.console.warn('Audio playback error:', err);
                                }
                            }
                        });
                    }
                } catch (err) {
                    if (this.currentAudio === audio) {
                        this.stop();
                    }
                }
            }
        };

        window.TestAudioController = controller.init();
    })(window, document);

    $(".start-button").click(function(event) {
    event.preventDefault();
    $(".hidden-content").removeClass('d-none');
    //

    $(".timer-block").slideUp();


    timeout = $(".hidden-content").data('timeout') * 1000;

    setTimeout(() => {
    console.log("hide");
    $(".hidden-content").addClass('d-none');
    $(".hidden-answers").removeClass('d-none');
    }, timeout)
    });
@endpush
