@extends('moderator.layout.template')
@section('title', $all_works[0]->title)

@section('lib-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" integrity="sha256-soW/iAENd5uEBh0+aUIS1m2dK4K6qTcB9MLuOnWEQhw=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="page__title">
    <a href="{{ route('moderator.index') }}">Головна</a>

</div>
<div class="user-add-work block">
    <div class="info-author">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @if (session('errorUpdate'))
            <div class="">
                {{ session()->get('errorUpdate') }}
            </div>
        @endif
        @if (session('successWork'))
            <div class="">
                {{ session()->get('successWork') }}
            </div>
        @endif
        <div class="header">
            @if ($all_works->count() == 1)
                <h2>
                    Інформація про автора
                </h2>
            @else
                <h2>
                    Інформація про авторів
                </h2>
            @endif
            <img src="{{ asset('img/no-edit.png') }}" alt="no-edit">
        </div>
        @foreach ($all_works as $work)
            <label for="user" class="reset-work-user">
                <div class="work-top-s">
                    <p>Викладач</p>
                    <div class="status-work">
                       <form action="{{ route('moderator.changeStatusWork') }}" method="POST" id="change-status-{{$work->id}}">
                           @csrf
                           <input type="text" hidden name="work_id" value="{{ $work->id }}">
                           <select name="status_work" class="status-change
                           {{ $work->status ? ' green-bg' : ' red-bg' }}
                           "
                            onchange="document.getElementById('change-status-{{$work->id}}').submit();"
                           >
                               <option
                               {{ !$work->status ? 'selected' : null }}
                               value="0">Не схвалена</option>
                               <option
                               {{ $work->status ? 'selected' : null }}
                               value="1">Схвалена</option>
                           </select>
                       </form>
                       <form action="{{ route('moderator.deleteWork') }}" method="POST">
                        @csrf
                        <input type="text" hidden name="work_id" value="{{ $work->id }}">
                        <img src="{{asset('img/delete.png')}}" alt="delete" class="btn-delete" data-work="{{$work->id}}">

                        <div class="modal modal-quest" data-work="{{$work->id}}">
                            <div class="modal-header modal-header-req" data-req-id="{{ $work->id }}">
                                <img  src="{{ asset('img/delete.png') }}" alt="close">
                            </div>
                            <div class="body-form">
                                <label for="">
                                    <p>Вкажіть причину видалення</p>
                                    <textarea required name="text-delete" style="width: 350px;resize: none;height: 150px;
                                    "></textarea>
                                </label>

                                <div class="btn-flex" style="display:flex;justify-content:flex-end">
                                    <button type="submit" class="btn-submit-input">Відправити</button>
                                </div>
                            </div>
                        </div>
                       </form>
                    </div>
                </div>
            <input type="text" id="user" class="text-input" readonly value="{{$work->employee->name . ' ' . $work->employee->surname . ' ' . $work->employee->patronymic}}">
            </label>
            <div class="wrap-el ">
                <label for="faculty" style="flex:1">
                    <p>Факультет</p>
                    <input type="text" id="faculty" class="text-input" readonly value="{{$work->departament->faculty->faculty_name}}">
                </label>
                <label for="departament" style="flex:1">
                    <p>Кафедра</p>
                    <input type="text" id="departament" class="text-input" readonly value="{{$work->departament->departament_name}}">
                </label>
                <label for="year" style="flex:0.4">
                    <p>Навчальний рік</p>
                    <input type="text" id="year" class="text-input" readonly value="{{$work->academic_year}}">
                </label>
                <label for="date-plane" style="flex:0.5">
                    <p>Дата запису плану</p>
                    <input type="text" id="date-plane" class="text-input" readonly value="{{$work->created_at->format('m/d/Y')}}">
                </label>
            <form action="{{ route("moderator.updateWorkPart") }}" id="form-update" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="date-plane" style="flex:0.3">
                    <p style="color:black">Частка</p>
                    <input min="0" max="1" step="0.1" type="number" name="user-count" id="share" class="text-input" value="{{$work->user_count}}">
                </label>
            </div>
            <div class="border-b">
                <div class="button-work">
                    @if ($work->materials)
                        <p class="dop-materials">Додаткові матеріали </p>
                        <table class="main-table form-work" style="display: inline-block; border: none; width: auto;">
                            @foreach (json_decode($work->materials) as $item)
                            <tr data-id="{{ $loop->index }}" class="file-item">
                                <td>
                                <input type="text" name="file-{{$loop->index}}" hidden value="{{$item->title . md5($item->link)}}">
                                <a href="{{ URL::to($item->link) }}">{{ $item->title }}</a>
                                </td>
                                <td class="min-h-50">
                                    <img src="{{ asset('img/delete.png') }}" alt="delete" class="img-delete btn-img" data-id="{{ $loop->index }}">
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    @else
                        <p>Матеріали відсутні</p>
                    @endif
                    <p class="add-files">
                        <p>Додати матеріали</p>
                        <input type="file" name="attachment[]" id="files-add" multiple class="file-input"/>
                    </p>
                    <div class="btn-flex" style="display:flex;justify-content:flex-end">
                        <button type="submit" id="form-send-f" class="btn-submit-input">Оновити</button>
                    </div>
                </form>

                </div>
            </div>
        @endforeach
    </div>
    <input type="text" hidden id="max_file_size" value="{{ ini_get('post_max_size') }}">
    <input type="text" hidden id="max_file_uploads" value="{{ ini_get('max_file_uploads') }}">
    <input type="text" hidden id="memory_limit" value="{{ ini_get('memory_limit') }}">

    <form action="{{ route('moderator.editWork') }}" method="POST" enctype="multipart/form-data">
        @csrf
            {{-- <div class="status">
                <h2>Статус: {{$work->status ? 'схвалено' : 'в очікуванні схвалення'}}</h2>
            </div> --}}
            {{-- <div class="change-status">
                <input type="radio" id="contactChoice2"
                name="status"
                {{ $work->status ? 'checked' : null }}
                value="yes">
                <label for="contactChoice2">Схвалити</label>

                <input type="radio" id="contactChoice3"
                name="status"
                {{ !$work->status ? 'checked' : null }}
                value="no">
                <label for="contactChoice3">Перенести в статус очікування</label>
            </div> --}}

            {{-- <div class="type-work">
                <label for="t-work">
                    <p>Тип роботи</p>
                    <select id="t-work">
                        @foreach ($type_work as $twork)
                            <option value="{{ $twork->id }}"
                        {{ $work->work->work_kind->typeWork->name_type_work == $twork->name_type_work ? 'selected' : null }}
                            >{{ $twork->name_type_work }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="k-work">
                    <p>Назва виду роботи</p>
                    <select id="k-work">
                        @foreach ($work_kinds as $wkind)
                            <option value="{{ $wkind->id }}">{{ $wkind->kind_name }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="ratio">
                    <p>Робота</p>
                    <select name="work" id="ratio">
                        @foreach ($works as $work1)
                            <option value="{{ $work1->id }}">{{ $work1->indicator }}</option>
                        @endforeach
                    </select>

                </label>
            </div> --}}
        {{-- <div class="content-work">
            <label for="work-title">
                <p>Назва роботи</p>
                <input value="{{ $work->title }}" type="text" name="work-title" required id="work-title" class="text-input">
            </label>
            <p>Опис роботи</p>
            <textarea class="text-input" name="desc-work" required>{{ $work->description }}</textarea>
        </div>
        <div class="form-buttom-group">
            <input type="file" name="attachment[]" multiple/>
            <div class="group-btnff">
                <button type="submit" class="btn-submit-input">Оновити</button>
            </div>
        </div>
        @if ($work->materials)
            <p class="dop-materials">Додаткові матеріали</p>
            <table class="main-table form-work" style="display: inline-block; border: none; width: auto;">
                @foreach (json_decode($work->materials) as $item)
                <tr>
                    <td>
                    <a href="{{ URL::to($item->link) }}">{{ $item->title }}</a>
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
    </form> --}}
</div>
<div class="overlay"></div>
@endsection


@section('scriptUser')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha256-ITwLtH5uF4UlWjZ0mdHOhPwDpLoqxzfFCZXn1wE56Ps=" crossorigin="anonymous"></script>
@endsection

@section('in-body')
<script defer>
    var works = {!! json_encode($jsonWork) !!};
    var workKinds = {!! json_encode($jsonWorkKinds) !!};
    var typeWork = {!! json_encode($jsonTypeWork) !!};
   var selectTypeWork = document.getElementById('t-work');
   var selectKindWork = document.getElementById('k-work');
   var ratio = document.getElementById('ratio');
   var points = document.getElementById('count-point');

   var btnDeletes = document.querySelectorAll('.btn-delete');
    var modalQuest = document.querySelectorAll('.modal-quest');
    var modalHeader = document.querySelectorAll('.modal-header-req');
    var overflay = document.querySelector('.overlay');

    overflay.addEventListener('click', function(){
        modalQuest.forEach(function(val){
                if(val.classList.contains('show')){
                    val.classList.remove('show');
                    overflay.classList.remove('show');
                }
            });
    });

    modalHeader.forEach(function(item){
        item.addEventListener('click', function(){
        modalQuest.forEach(function(val){
                if(val.classList.contains('show')){
                    val.classList.remove('show');
                    overflay.classList.remove('show');
                }
            });
    });
    });

   btnDeletes.forEach((item) => {
        var workId = item.getAttribute('data-work');
        item.addEventListener('click', function(){
            modalQuest.forEach(function(val){
                if(val.getAttribute('data-work') == workId){
                    val.classList.add('show');
                    overflay.classList.add('show');
                }
            });
        });
   });

//    selectTypeWork.addEventListener("change", function(){
//         setKindWork();
//    })

//    setKindWork();

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

//    selectKindWork.addEventListener('change', function(){
//         setWork();
//    });

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

   }

   //////////////////////////////////////
   //// delete item files ///////////////
   var btn_imgs = document.querySelectorAll('.btn-img');
   var file_items = document.querySelectorAll('.file-item');

   btn_imgs.forEach(item => {
    item.addEventListener('click', function(){
        btn_data = this.getAttribute('data-id');
        file_items.forEach(file => {
            if(file.getAttribute('data-id') == btn_data){

                file.remove();
            }
        });
    });
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


@section('script')
<script src="{{ asset('js/save-files.js') }}"></script>
@endsection
