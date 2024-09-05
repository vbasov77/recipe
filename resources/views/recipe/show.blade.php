@extends('layouts.app', ['title' => $recipe->title])
@section('content')
    <style>
        .imgI {
            width: 50%;
            height: auto;
        }

        @media screen and (max-width: 640px) {
            .imgI {
                width: 100%;
                height: auto;
            }

            .card-body {
                padding: 0;
                margin: 20px 0 20px 0;
            }
        }
    </style>
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center text-center">
                <div class="col-lg-9">
                    <div>
                        <h1 style="margin-top: 50px">{{$recipe->title}}</h1>
                    </div>
                    <br>
                    <div>
                        <p>
                            {!!nl2br(e($recipe->description))!!}
                        </p>
                    </div>
                    <br>
                    @foreach($elements as $element)
                        @if($element->elem === 'text')
                            <div style="margin: 50px 0 50px 0">
                                {!!nl2br(e($element->v))!!}
                            </div>
                            <br>
                        @else
                            <div>
                                <img src="{{ asset('storage/images/recipe/' . $element->v)}}" class="imgI">
                            </div>
                        @endif
                    @endforeach
                    @auth
                        <button class="btn btn-success btn-sm" style="color: white; margin-top: 25px"
                                onclick="window.location.href = '{{route('view.messages',
                            ['to_user_id'=>$recipe->user_id])}}'">
                            Написать сообщение
                        </button>
                        @if(Auth::user()->isAuthor($recipe->user_id) || Auth::user()->isAdmin())
                            <div>
                                <button class="btn btn-outline-success"
                                        onclick="window.location.href = '{{route('edit.recipe', ['id'=>$recipe->id])}}';">
                                    Редактировавть
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="col-lg-9 text-left">
                    <div class="card">
                        <h5 class="card-header">Комментарии <span
                                    class="comment-count float-right badge"
                                    style="color: white; background-color: #fd7e14">{{ count($comments) }}</span>
                        </h5>
                        <div class="card-body">
                            {{-- Добавляем коммент --}}
                            @guest
                                <div style="margin: 20px 0 20px 0;">
                                    Войдите или зарегистрируйтесь, чтобы оставлять комментарии
                                </div>
                            @else
                                <div class="add-comment mb-3">
                                    @csrf
                                    <textarea class="form-control comment" placeholder="Введите комментарий"></textarea>
                                    <button data-recipe="{{ $recipe->id }}"
                                            class="btn btn-recipe btn-sm mt-2 save-comment">
                                        Добавить
                                    </button>
                                </div>
                                <hr/>
                            @endguest
                            <div class="comments">
                                @if(count($comments)>0)
                                    @foreach($comments as $comment)
                                        <div id="{{$comment->id}}" data-id="{{$comment->id}}">
                                            <blockquote class="blockquote">
                                                @auth
                                                    @if(Auth::user()->isAuthor($comment->user_id) || Auth::user()->isAdmin())
                                                        <div class="round-popup">
                                                            <button data-id="{{$comment->id}}" type="button"
                                                                    class="close"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endauth
                                                <img src="{{ asset('icons/check.svg')}}" style="width: 17px;
                                                height: auto; opacity: .7">
                                                <small class="mb-0">{{ $comment->comment_text }}</small>
                                                <br><small style="font-size: 10px"
                                                           class="mb-0 justify-content-start">{{$comment->name}} {!! $comment->created_at !!}</small>

                                            </blockquote>
                                            <hr/>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="no-comments">Нет комментариев</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Комментарии --}}

@endsection
@push('scripts')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        var userId = @json($recipe->user_id);
    </script>
    <script src="{{asset('js/comments/add_comments.js')}}" defer></script>
    <script src="{{asset('js/comments/del_comment.js')}}" defer></script>
@endpush