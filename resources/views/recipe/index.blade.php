@extends('layouts.app')
@section('content')
    <section style="margin-top: 40px" class="section text-center">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                @foreach($recipes as $recipe)
                    <div class="card" style="width: 18rem;">

                        <div class="card-body">
                            {{$recipe->title}}
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-success"
                                    onclick="window.location.href = '#';">
                                Подробнее
                            </button>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection