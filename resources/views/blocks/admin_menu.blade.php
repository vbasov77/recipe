<li><a href="{{route('create.recipe')}}">Добавить рецепт</a>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault();
       document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>
{{--<li class="has-children">--}}
{{--    <a href="#">Добавить</a>--}}
{{--    <ul class="dropdown">--}}
{{--        <li><a href="{{route('add.article')}}">Добавить заметку</a>--}}
{{--        <li><a href="{{route('add.slider')}}">Добавить слайдер</a>--}}
{{--    </ul>--}}
{{--</li>--}}

