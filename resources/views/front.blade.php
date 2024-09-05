@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{asset('css/recipes/all_recipes.css')}}">
    <link rel="stylesheet" href="{{asset('css/search.css')}}">

    <section class="about-section text-center">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-8" style="margin-top: 60px">
                    <link rel="stylesheet"
                          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <form class="example" method="post" action="{{route('search')}}">
                        @csrf
                        <input id="input" type="search" value="{{session("search")}}" placeholder="Поиск...."
                               name="search" required>
                        <button type="submit"><i class="fa fa-search"></i></button>
                        <div class="form-row my_code">
                            <input type="radio" name="data" value="all" checked> Везде&ensp;
                            <input type="radio" name="data" value="name"> По заголовку&ensp;
                            <input type="radio" name="data" value="description"> По описанию&ensp;
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <center><h1 style="margin: 60px 0 40px 0">Рецепты</h1></center>
    <style>
        a.link h4 {
            text-decoration: none;
            opacity: .8;
        }

        a.link:hover h4 {
            opacity: 1;
        }

        @media screen and (max-width: 640px) {
            .form-row {
                font-size: 12px;
            }

            .col-md-9 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            img.rightM {
                width: 100%;
            }
        }

        img.rightM {
            float: right;
            opacity: .8;
        }

        .page-item.active .page-link {
            background-color: #fd5310;
            border-color: #fd5310;
        }

    </style>

    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div id="col-md" class="col-md-9">
                @if(count($recipes))
                    @foreach($recipes as $recipe)
                        @php
                            $img = null;
                                foreach (json_decode($recipe['elements']) as $key => $value)
                                {
                                if ($value -> elem === 'img') {
                                $img = $value -> v;
                                break;
                                }}
                        @endphp

                        <div class="card" style="margin-top: 25px;">
                            <div class="card-body">
                                @if(!empty($img))

                                    <img style="margin: 10px" src="{{asset("storage/images/recipe/" . $img)}}"
                                         height="150px" width="auto" class="rightM">
                                @else
                                    <img style="margin: 10px" src="{{ asset("images/no_image/no_image.jpg") }}" height="150px" width="auto"
                                         class="rightM">
                                @endif
                                <a class="link" style="text-decoration: none"
                                   href="{{route('recipe', ["id"=>$recipe['id']])}}">
                                    <h4>{{$recipe->title}}</h4></a>
                                <small><i>{{mb_substr($recipe ['description'],  0, 250, 'UTF-8') }}...</i></small>
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
    @push('scripts')
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
    @endpush
@endsection