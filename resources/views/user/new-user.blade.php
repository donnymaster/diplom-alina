<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=cyrillic"
    rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap&subset=cyrillic-ext" rel="stylesheet">
       <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/icon.ico') }}" type="image/x-icon">
    <title>Заявка на реєстрацію</title>
</head>
<body class="new-user">
    <div class="form-register">
        <h1>Заявка на реєстрацію</h1>
    <form action="/register" method="POST">
        @csrf
            <div class="group-text">
            <input type="text" required placeholder="Ім'я" name="name">
            <input type="text" required placeholder="Прізвище" name="surname">
            <input type="text" required placeholder="По батькові" name="patronymic">
            <input type="email" required placeholder="Пошта" name="email">
        </div>
            <div class="group-label">
                    <label for="faculty_id">Факультет</label>
                        <select id="faculty_id" name="faculty" style="max-width: 266px;">
                            @foreach ($facultes as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                            @endforeach
                        </select>
            </div>

            <div class="group-label">
                <label for="departament_id">Кафедра</label>
                <select id="departament_id" name="departament">
                </select>
            </div>

            <div class="group-label">
                <label for="degree_id">Наукова&nbsp;ступінь</label>
            <select id="degree" name="degree">
                @foreach ($degrees as $degree)
                    <option value="{{ $degree->id }}">{{ $degree->degree_name }}</option>
                @endforeach
            </select>
            </div>
           <div class="group-label">
            <label for="post_id">Посада</label>
            <select id="post" name="post">
                @foreach ($posts as $post)
                    <option value="{{ $post->id }}">{{ $post->post_name }}</option>
                @endforeach
            </select>
           </div>

            <div class="submit">
                <input type="submit" class="btn-submit-input" value="Відправити">
            </div>
        </form>
        <div class="new-user-error">
        </div>
            @if (session('success'))
                <div class="success-user">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session('errorAdd'))
                <div class="errorAdd">
                    {{ session()->get('errorAdd') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="wrapped-new-user-error">
                    <ul class="show-errors-server">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    </div>
    <script defer>
        (
            function(){
                var departaments = {!! json_encode($allDep) !!};
                var departament = document.querySelector('#departament_id');
                var faculty = document.querySelector('#faculty_id');

                insertDepartaments(departaments, departament, Number(faculty.value));

                faculty.addEventListener('change', function(){
                    insertDepartaments(departaments, departament, Number(faculty.value));
                });


                function insertDepartaments(dep, departament, value){
                    var arrayItems = [];
                    var readyElements = [];

                    for(var iter = 0; iter < dep.original.length; iter++){

                        if(dep.original[iter].faculty_id === value){
                            arrayItems.push(dep.original[iter]);
                        }
                    }

                    for(var elIter = 0; elIter < arrayItems.length; elIter++){
                        var option = document.createElement('option');
                        option.value = arrayItems[elIter].id;
                        option.innerHTML = arrayItems[elIter].departament_name;
                        readyElements.push(option);
                    }

                    while (departament.firstChild) {
                        departament.removeChild(departament.firstChild);
                    }

                    readyElements.forEach(function(item){
                        departament.append(item);
                    });
                }
            }

        )()
    </script>
</body>
</html>
