@extends('layouts.app')
@section('content')
    <style>
        .add {
            width: 150px;
            height: 75px;
            line-height: 75px;
            text-align: center;
            border: 1px dashed grey;
            margin: 10px 0;
        }

        .add:hover {
            cursor: pointer;
            background-color: #360581;
        }
    </style>
    <section>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center text-center">
                <div class="col-lg-10">
                    <form action="{{route("update.recipe")}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 style="margin-top: 60px">Редактирование рецепта</h3>
                        <input type="hidden" name="id" value="{{$recipe->id}}">
                        <label for="name"><b>Название</b></label><br>
                        <input type="text" placeholder="Название" class="form-control" name="name"
                               required value="{{$recipe->title}}"
                        ><br>
                        <br>
                        <label for="description"><b>Описание</b></label><br>
                        <textarea type="text" placeholder="Описание" class="form-control" name="description"
                               required>{{$recipe->description }}</textarea>
                        <br>
                        @for($i = 0; $i < $count; $i++)
                            @if($elements[$i]->elem === "text")
                                <br>
                                <textarea class="form-control" type="text" name="text[{{$i}}]"
                                          placeholder="Введите текст">{{$elements[$i]->v}}</textarea>                            @else
                                @if($elements[$i]->v !== null)
                                    <br>
                                    <div id="div{{$i}}" class="div{{$i}}" data-fileName="{{$elements[$i]->v}}">
                                        <img src="{{ asset('storage/images/recipe/' . $elements[$i]->v)}}"
                                             width="50%" height="auto">
                                        <input type="hidden" name="img[{{$i}}]" value="{{$elements[$i]->v}}">
                                        <div>
                                            <br>
                                            <button type="submit" class="btn btn-outline-danger btn-sm" id="{{$i}}">
                                                Удалить фото
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endfor

                        <div class="elem"></div>
                        <div class="add" id="addText">Добавить текст</div>
                        <div class="add" id="addImg">Добавить фото</div>

                        <br>
                        <input class="btn btn-outline-success" type="submit" value="Сохранить">
                    </form>
                    <div>
                        <br>
                        <div class="btn btn-outline-danger btn-sm deleteRecipe" type="submit">Удалить</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var recipeId = @json($recipe->id);
        var count = @json(count($elements));
        var allButtons = document.querySelectorAll('button[type="submit"]');

        if (allButtons) {
            for (var i = 0; i < allButtons.length; i++) {
                allButtons[i].addEventListener('click', e => {
                    e.preventDefault();
                    let attrId = e.target.id;
                    let id = document.getElementById('div' + attrId);
                    let fileName = id.getAttribute('data-fileName');

                    id.id = "elements" + attrId;
                    id.innerHTML = '';
                    id.classList.add("elements" + attrId);

                    deleteImgOnServer(e, recipeId, fileName);
                    addImg2(e.target.id);
                });
            }
        }

        document.getElementById('addText').addEventListener('click', event => {
            addText();
        });

        document.getElementById('addImg').addEventListener('click', event => {
            addImg();
        });

        function addText() {
            document.querySelector('.elem').insertAdjacentHTML('beforeend',
                '<br><textarea class="form-control" type="text" name="text[' + count + ']"  placeholder="Введите текст"></textarea>');
            count++;
        }

        function addImg() {
            document.querySelector('.elem').insertAdjacentHTML('beforeend',
                '<br><input class="form-control" type="file" name="img[' + count + ']" ' +
                'onchange="showPreview(event, ' + count + ');"/>' +
                '<img style="margin: 10px" width="25%" height="auto" id="preview' + count + '">');
            count++;
        }


        function deleteImgOnServer(e, id, value) {
            if (confirm('Подтвердите удаление')) {
                send('/delete-img/' + id + '/' + value);
            } else {
                alert('Удаление отменено');
            }
        }

        async function send(url) {
            let response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        }


        function addImg2(id) {
            document.querySelector('.elements' + id).insertAdjacentHTML('beforeend',
                '<br><input class="form-control" type="file" name="img[' + id + ']" ' +
                'onchange="showPreview(event, ' + id + ');"/>' +
                '<img style="margin: 10px" width="25%" height="auto" id="preview' + id + '">');
        }

        function showPreview(event, x) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("preview" + x);
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
    <script src="{{ asset('js/deletes/delete_recipe.js') }}" defer></script>
@endsection