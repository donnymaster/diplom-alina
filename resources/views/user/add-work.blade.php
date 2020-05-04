@extends('user.layout.template')
@section('title', 'Нова робота')
@section('content')
@section('lib-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" integrity="sha256-soW/iAENd5uEBh0+aUIS1m2dK4K6qTcB9MLuOnWEQhw=" crossorigin="anonymous" />
@endsection
<div class="page__title">
    <a href="{{ route('user.index') }}">Головна</a>
    <img src="{{ asset('/img/next.png') }}" alt="next">
    <a href="{{ route('user.addWork') }}">Нова робота</a>
</div>

<div class="user-add-work block">
    <div class="info-author">

        @if ($errors->any())
            <div class="wrapped-new-user-error">
                <ul class="show-errors-server">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('notAddWork'))
            <div class="wrapped-new-user-error">
                <p class="red">Ви не можете додати роботу тому що:</p>
                <ul>
                    @foreach (session()->get('notAddWork') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('errorMake'))
            <div class="error-make">
                {{ session()->get('errorMake') }}
            </div>
        @endif

        @if (session('successWork'))
            <div class="good-new-work">
                {{ session()->get('successWork') }}
            </div>
        @endif

        <div class="header">
            <h2>
                Інформація про автора
            </h2>
            <img src="{{ asset('img/no-edit.png') }}" alt="no-edit">
        </div>
        <div class="work-add-tt d-f">
            <label for="user" class="g-m g-6">
                <p>Викладач</p>
                <input type="text" id="user" class="text-input" readonly value="{{$employee}}">
            </label>
            <label for="date-plane" class="g-m">
                <p>Дата запису плану</p>
                <input type="text" id="date-plane" class="text-input" readonly value="{{$date}}" style="width:100%">
            </label>
            <label for="year" class="g-m">
                <p>Навчальний рік</p>
                <input type="text" id="year" class="text-input" readonly value="{{$year}}" style="width:100%">
            </label>
        </div>
    </div>
    <form action="{{ route('user.CreateWork') }}" id="form-update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="type-work">
            <div class="item-type-work" style="margin-right:25px">
                <label for="t-work">
                    <p class="p-t-b-10">Тип роботи</p>
                    <select id="t-work" class="text-input">
                        @foreach ($type_work as $twork)
                            <option value="{{ $twork->id }}">{{ $twork->name_type_work }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="k-work">
                    <p class="p-t-b-10">Назва виду роботи</p>
                    <select id="k-work" class="text-input" style="max-width:400px">
                        @foreach ($work_kinds as $wkind)
                            <option value="{{ $wkind->id }}">{{ $wkind->kind_name }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="ratio">
                    <p class="p-t-b-10">Работа</p>
                    <select name="work" id="ratio" class="text-input" style="max-width:400px">
                        @foreach ($works as $work)
                            <option value="{{ $work->id }}">{{ $work->indicator }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="item-type-work">
                <div class="categoty-type-work">

                    <label for="">
                        <p class="p-t-b-10">Категорія роботи</p>
                        <select class="category_work text-input" name="category_work" id="" class="text-input">
                            @isset($type_work[0]->category_name->category_work)
                                @forelse ($type_work[0]->category_name->category_work as $category)
                                    <option value="">{{ $category->category_name }}</option>
                                @empty

                                @endforelse
                            @endisset
                        </select>
                    </label>
                </div>
            </div>
        </div>

        <div class="config-work">
            <div class="title">
                <h2>Характеристика роботи</h2>
            </div>
                <div>
                    <p class="p-t-b-10">Ваша частка в роботі</p>
                    <input value="0" min="0" max="1" step="0.1" type="number" name="user-count" required id="norma-1-plane" class="text-input">
                </div>
            <div class="group-label">
                    <label for="faculty_id">
                        <p class="p-t-b-10">Факультет</p>
                        <select id="faculty_id" name="faculty" class="text-input">
                            @foreach ($facultes as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                            @endforeach
                        </select>
                    </label>
            </div>

            <div class="group-label">
                <label for="departament_id">
                    <p class="p-t-b-10">Кафедра</p>
                    <select id="departament_id" name="departament" class="text-input">
                    </select>
                </label>
            </div>

        </div>
        <div class="content-work">
            <label for="work-title">
                <p>Назва роботи</p>
                <input type="text" name="work-title" required id="work-title" class="text-input">
            </label>
            <p>Опис роботи</p>
            <textarea class="text-input" name="desc-work" required></textarea>
        </div>
        <div class="form-buttom-group">
            <div class="add-files">
                <p>Додаткові матеріали <span title="Ви можете додати 20 файлів, розмір кожного файлу не повинен перевищувати 2GB" class="red">*</span></p>
                <input type="file" id="files-add" name="attachment[]" multiple class="file-input"/>
            </div>
            <button type="submit" id="form-send-f" class="btn-submit-input">Відправити</button>
        </div>
    </form>
</div>
<input type="text" hidden id="max_file_size" value="{{ ini_get('post_max_size') }}">
<input type="text" hidden id="max_file_uploads" value="{{ ini_get('max_file_uploads') }}">
<input type="text" hidden id="memory_limit" value="{{ ini_get('memory_limit') }}">
@endsection

@section('in-body')
    <script defer>
       var works = {!! json_encode($jsonWork) !!};
       var workKinds = {!! json_encode($jsonWorkKinds) !!};
       var typeWork = {!! json_encode($jsonTypeWork) !!};
       var selectTypeWork = document.getElementById('t-work');
       var type_work_options = selectTypeWork.querySelectorAll('option');
       var selectKindWork = document.getElementById('k-work');
       var ratio = document.getElementById('ratio');
       var points = document.getElementById('count-point');
       var category_work = document.querySelector('.category_work');
       var isCategoryWork = null;

       selectTypeWork.addEventListener("change", function(event){
            var nameWork = "", _this = this;
            type_work_options.forEach(function(item, index){
                if(index == _this.selectedIndex){
                    nameWork = item.label;
                }
            });
            setCategoryWork(nameWork);
            setKindWork();
       });


       function startSetCategory(){
        var nameWork = "", _this = this;
            type_work_options.forEach(function(item, index){
                if(index == _this.selectedIndex){
                    nameWork = item.label;
                }
            });
            setCategoryWork(nameWork);
       }

       // function set category type work
       function setCategoryWork(nameWork){
        typeWork.original.forEach(function(item){
                if(item.category_name != null){
                    if(item.name_type_work == nameWork){
                        isCategoryWork = item.category_name.category_work;
                    }
                }
            });
            // console.log(isCategoryWork);
            if(isCategoryWork != null){
                    while (category_work.firstChild) {
                        category_work.removeChild(category_work.firstChild);
                }
                for(var iter = 0; iter < isCategoryWork.length; iter++){
                    var buff_option = document.createElement('option');
                    buff_option.value = isCategoryWork[iter].id;
                    buff_option.innerText = isCategoryWork[iter].category_name;
                    category_work.append(buff_option);
                }
                isCategoryWork = null;
            }else{
                while (category_work.firstChild) {
                    category_work.removeChild(category_work.firstChild);
            }
                var no_option = document.createElement('option');
                no_option.innerText = "відсутні";
                category_work.append(no_option);
            }
       }

       setKindWork();

       function setKindWork(){
            // clear
            while (selectKindWork.firstChild) {
                selectKindWork.removeChild(selectKindWork.firstChild);
            }
            // get items type_work->kinds_works
            for(var iter = 0; iter < workKinds.original.length; iter++){
                var option = document.createElement('option');
                if(workKinds.original[iter].type_work_id == +selectTypeWork.value){
                    option.value = workKinds.original[iter].id;
                    option.innerHTML = workKinds.original[iter].kind_name;
                    selectKindWork.append(option);
                }
            }
            setWork();
       }

       selectKindWork.addEventListener('change', function(){
            setWork();
       });

       function setWork(){
            // clear
            while (ratio.firstChild) {
                ratio.removeChild(ratio.firstChild);
            }
            // get items kinds_works->works
            for(var iterator = 0; iterator < works.original.length; iterator++){
                var opt = document.createElement('option');
                if(works.original[iterator].works_kinds_id == +selectKindWork.value){
                    opt.value = works.original[iterator].id;
                    opt.innerHTML = works.original[iterator].indicator;
                    ratio.append(opt);
                }
            }
            startSetCategory.bind(selectTypeWork)();
       }


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

        // js for files
        var file_input = document.querySelector('.file-input');

        file_input.addEventListener('change', function(){
            var files = this.files;

        });
    // handler input files

    var save = new SaveFiles(document.querySelector('#max_file_uploads').value, // максимальное количество файлов
                document.querySelector('#max_file_size').value, // максимально возможный размер файла в гб
                document.querySelector('#memory_limit').value, // общая сумма размеров файлов
                    document.querySelector('#files-add'),
                    document.querySelector('#form-send-f'),
                    document.querySelector('#form-update'));
    save.init();

    </script>
@endsection

@section('scriptUser')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha256-ITwLtH5uF4UlWjZ0mdHOhPwDpLoqxzfFCZXn1wE56Ps=" crossorigin="anonymous"></script>
@endsection

@section('script')
<script src="{{ asset('js/save-files.js') }}"></script>
@endsection

