@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{asset('css/recipes/all_recipes.css')}}">
    <link rel="stylesheet" href="{{asset('css/search.css')}}">

    <style>
        @media screen and (max-width: 640px) {
            img.rightM {
                width: 100%;
            }
        }

        img.rightM {
            float: right;
            opacity: .8;
        }
    </style>

    <!-------------------------------------------------------------    Форма поиска-->
    <section class="about-section text-center">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-9" style="margin-top: 60px">
                    <link rel="stylesheet"
                          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <form class="example" method="post" action="{{route('search')}}">
                        @csrf
                        <input id="input" type="search" value="{{session("search")}}"
                               placeholder="Поиск...." name="search" required>
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div id="col-md" class="col-md-9">
                    <h1 style="margin: 50px 0 50px 0; text-align: center">Результаты поиска</h1>
                    @if(count($recipes))
                        @foreach($recipes as $recipe)
                            @php
                                $img = null;
                                    foreach (json_decode($recipe->elements) as $key => $value)
                                    {
                                    if ($value -> elem === 'img') {
                                    $img = $value -> v;
                                    break;
                                    }}
                            @endphp

                            <div class="card" style="margin-top: 25px;">
                                <div class="card-body">
                                    @if(!empty($img))
                                        <img src="{{asset("storage/images/recipe/" . $img)}}"
                                             height="150px" width="auto" class="rightM">
                                    @else
                                        <img src="{{ asset("images/no_image/no_image.jpg") }}" height="150px"
                                             width="auto" class="rightM">
                                    @endif
                                    <a class="link" style="text-decoration: none"
                                       href="{{route('recipe', ["id"=>$recipe->id])}}">
                                        <h4>{{$recipe->title}}</h4></a>
                                    <small><i>{{$recipe -> description}}</i></small>
                                    <br>
                                </div>
                            </div>
                        @endforeach
                    @else
                        Нет материала
                    @endif

                </div>
            </div>
        </div>
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        const inputEl = document.querySelector('#input');
        inputEl.addEventListener('focus', event => { //Покрасит рамку
            event.target.style.outline = "1px solid #f57106";

        });
        inputEl.addEventListener('blur', event => { //Покрасит рамку
            event.target.style.removeProperty('outline')
        });

        document.getElementById('input').addEventListener('input', (e) => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/delete_session',
                method: 'delete',
            });
        });
    </script>
    <script>
        $(window).resize(function () {
            var width = $('body').innerWidth();
            if (width < 600) {
                $('.col-md').removeClass('col-md-9').addClass('col-md-12');
            }
        });
    </script>

@endsection
