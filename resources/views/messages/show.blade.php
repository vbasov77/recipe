@extends('layouts.app', ['title' => "Мои сообщения"])
@section('content')
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>


    <link href="{{ asset('css/messages/messages.css') }}" rel="stylesheet">
    <style>
        .rem {
            opacity: 0.5;
        }

        .rem:hover {
            opacity: 1;
        }
    </style>
    <section>
        <div class="container px-4 px-lg-5"
             style="white-space: nowrap"> {{--Запрет переноса строк при уменьшении странцы браузера--}}
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    @csrf
                    <div style="margin-top: 10px" id="framechat">
                        <div class="content">
                            <div class="header">
                                @if (!empty($userAuthor))
                                    <div class="msgImg">
                                        {{--  Ссылка на объект--}}
                                        @if(!empty($userAuthor[0]->path))
                                            <img class="imgMsg"
                                                 src="{{ asset('images/' . $userAuthor[0]->path) }}"
                                                 style="width: auto; height: 60px"
                                            >
                                        @else
                                            <img class="imgMsg"
                                                 src="{{ asset('icons/user.svg') }}"
                                                 style="width: auto; height: 60px"
                                            >
                                        @endif
                                        <div class="infoBlock">
                                            {{$userAuthor->name}}
                                        </div>
                                        @if(!empty($messages))
                                            <a style="text-decoration: none;" title="Удалить чат"
                                               onClick="return confirm('Подтвердите удаление чата!')"
                                               href="{{ route('delete.chat', ['to_user_id' => $toUser,
                                       'from_user_id' =>$userId]) }}">
                                                <img class="imgMsg rem"
                                                     src="{{ asset('icons/del_message.svg') }}"
                                                     style="width: auto; height: 25px; float: right; border: none;"
                                                >
                                            </a>
                                        @endif
                                    </div>
                                @endif

                            </div>
                            <div class="messages">
                                <ul>
                                    @if(!empty(count($messages)))
                                        @for($i = 0; $i < count($messages); $i++)
                                            <li class="sent">
                                                <div class="myClass">
                                                    <div class="messageBlock" id="{{$messages[$i]->id}}" style="
                                                     @php
                                                        if($messages[$i]->status == 0){
                                                            echo "background-color: #dad6f5; ";}
                                                    @endphp
                                                    @php
                                                        if($messages[$i]->from_user_id == $userId){
                                echo "float: right; ";
                            }
                                                    @endphp "
                                                         data-id="{{$messages[$i]->id}}"
                                                         data-notified="{{$messages[$i]->status}}">
                                                        @if($messages[$i]->from_user_id == $userId)
                                                            <div class="round-popup">
                                                                <button data-id="{{$messages[$i]->id}}"
                                                                        type="button"
                                                                        class="close"
                                                                        aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                            </div>
                                                        @endif
                                                        <big>{!!$messages[$i]->body!!}<br></big>
                                                        <small style="opacity: 0.7">{!! $messages[$i]->created_at !!}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endfor
                                    @endif
                                </ul>
                            </div>
                            @if (!empty($userAuthor))
                                <div class="message-input">
                                    <div class="wrap">
                                        <input class="form-control" type="text" placeholder="Ваше сообщение..."/>
                                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <a class="btn btn-outline-danger btn-sm"
                                       onClick="return confirm('Подтвердите удаление!')"
                                       href="{{ route('delete.chat', ['to_user_id' => $toUser,
                                                                           'from_user_id' =>$userId]) }}">Удалить
                                        чат
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (!empty($userAuthor))
        @push('scripts')
            <script src="{{ asset('js/jquery/jquery-3.5.1.js') }}"></script>
            <script>
                var to_user_id = @json($toUser);
                var from_user_id = @json($userId);
            </script>
            <script src="{{asset('js/messages/message.js')}}"></script>
        @endpush
    @endif
@endsection