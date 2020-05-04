@extends('administrator.layout.template')
@section('title', $type_work_name)
@section('content')
    <div class="page__title">
        <a href="{{ route('admin.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('admin.typeWorkShow') }}">Роботи</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('admin.workGroupShow', $type_work_id) }}">{{$type_work_name}}</a>
    </div>
    <div class="user-works block-no-padding">
        <div class="header">
            <div class="header-item">
                    <p>Кількість групп: {{$groupWorks->total()}}</p>
                </div>
                @if ($groupWorks->total() != 0)
                <div class="header-item">
                    <form id="go-sort" action="" method="get">
                        <label for="sort">
                            <p>Сортування</p>
                            @if (!empty($get_req))
                                <select name="value" id="sort">
                                    <option value="1"
                                    {{$get_req['val'] == 1 ? 'selected' : null}}
                                    >назва групи</option>
                                </select>
                            @else
                            <select name="value" id="sort">
                                <option value="1">назва групи</option>
                            </select>
                            @endif
                        </label>
                </div>
                <div class="header-item">
                    <label for="sort">
                        <p>Як</p>
                        @if (!empty($get_req))
                            <select name="type-sort" id="type-sort">
                                <option {{$get_req['type'] == 'desc' ? 'selected' : null}}
                                value="desc">по спаданню</option>
                                <option {{$get_req['type'] == 'asc' ? 'selected' : null}}
                                value="asc">по зростанню</option>
                            </select>
                        @else
                        <select name="type-sort" id="type-sort">
                            <option value="desc">по спаданню</option>
                            <option value="asc">по зростанню</option>
                        </select>
                        @endif
                    </label>
                </div>
                <div class="header-item">
                        <button type="submit" class="btn-submit-input">Оновити</button>
                    </form>
                </div>
                @endif
                <div class="header-item">
                        <img src="{{ asset('img/add.png') }}" alt="add" id="add-dep">
                </div>
            </div>
            @if (session('noDelete'))
                <div class="error-make" style="text-align: center;padding: 10px;padding-bottom: 0;
                    ">
                    {{ session()->get('noDelete') }}
                </div>
            @endif
            @if ($groupWorks->total() == 0)
                <h1 style="text-align: center;padding: 20px;"
                >Групи відсутні</h1>
            @else
            <table class="main-table" style="margin-top:20px; width:100%">
                <tr>
                    <th>
                        Назва групи
                    </th>
                    <th>
                        Список робіт
                    </th>
                    <th>
                        Редагувати
                    </th>
                    <th>
                        Видалити
                    </th>
                </tr>
                @foreach ($groupWorks as $groupWork)
                    <tr>
                        <td>
                            {{ $groupWork->kind_name }}
                        </td>
                        <td>
                            <a href="{{ route('admin.worksShow', $groupWork->id) }}">
                                <img class="dep-link" src="{{ asset('img/link.png') }}" alt="dep-link">
                            </a>
                        </td>
                        <td style="padding: 0; text-align:left;">
                           {{-- <textarea readonly style="width:100%; height:200px; resize:none; border:none;">{{ $question->content }}</textarea> --}}
                           <div data-req-id="{{ $groupWork->id }}" class="show-question">
                            <img src="{{ asset('img/detail.png') }}" alt="add">
                        </div>
                        <div class="modal modal-quest" data-req-id="{{ $groupWork->id }}">
                            <div class="modal-header modal-header-req" data-req-id="{{ $groupWork->id }}">
                                <img  src="{{ asset('img/delete.png') }}" alt="close">
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.workGroupEdit') }}" method="POST">
                                    @csrf
                                    <input required type="text" name="id" hidden value="{{ $groupWork->id }}">
                                    <input required type="text" name="type_work_id" hidden value="{{ $groupWork->id }}">

                                    <label for="name">
                                        <p>Назва групи</p>
                                        <input required type="text" name="kind_name" class="text-input" value="{{ $groupWork->kind_name }}">
                                    </label>
                                    <div class="f-btn">
                                        <input type="submit" class="btn-submit-input" value="Оновити">
                                    </div>
                                </form>
                            </div>
                        </div>
                        </td>
                        <td>
                            <div data-req-id="{{ $groupWork->id }}" class="show-bar">
                                <img src="{{ asset('img/delete-user.png') }}" alt="add"
                                id="addNewUser">
                            </div>
                        </td>
                    </tr>
                @endforeach
                <!-- Form answer -->
                <div class="modal" id="modal-answer">
                    <div class="modal-header">
                        <img id="close-modal-delete" src="{{ asset('img/delete.png') }}" alt="close">
                    </div>
                    <div class="id"></div>
                    <form action="{{ route('admin.workGroupDelete') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" hidden class="feedback_id" name="kind_work_id">
                        <p style="padding: 5px;font-size: 18px;font-weight: 500; font-family:Montserrat;text-align:center;"
                        >Ви дійсно хочете видалити групу?</p>
                        <div class="f-btn" style="justify-content: space-evenly">
                            <input type="submit" class="btn-submit-input" value="Так">
                            <button class="btn-submit-input no-delete">Ні</button>
                        </div>
                    </form>
                </div>
                <!-- Form answer -->
            </table>
            @endif
            @if ($groupWorks->total() != 0)
            <div class="wrapped-elements">
                {{ $groupWorks->appends(request()->query())->links() }}
            </div>
            @endif
    </div>
    <div class="overlay"></div>




    <div class="modal new-dep-model" style="width: 500px;">
        <div class="modal-header close-dep">
            <img  src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.workGroupNew') }}" method="POST">
                @csrf
                <input hidden required type="text" name="type_work_id" value="{{$type_work_id}}">

                <label for="name">
                    <p>Назва групи</p>
                    <input style="width:100%" required type="text" name="kind_name" class="text-input">
                </label>
                <div class="f-btn">
                    <input type="submit" class="btn-submit-input" value="Добавити">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script defer>


        var newDep = document.querySelector('#add-dep');
        var ModelDep = document.querySelector('.new-dep-model');
        var closeModelDep = document.querySelector('.close-dep');
        var btnNoDelete = document.querySelectorAll('.no-delete');

        btnNoDelete.forEach(function(item){
            //item.preventDefault();
            item.addEventListener('click', function(event){
                event.preventDefault();
                formGo.classList.remove('show-block');
                overflay.classList.remove('show-block');
            });
        });


        newDep.addEventListener('click', function(){
            ModelDep.classList.add('show-block');
            overflay.classList.add('show-block');
        });

        closeModelDep.addEventListener('click', function(){
            ModelDep.classList.remove('show-block');
            overflay.classList.remove('show-block');
        });



        // form
        var changeForm = document.querySelector('#type-sort');
        var form = document.querySelector('#go-sort');
        // changeForm.addEventListener('change', function(){
        //     //form.submit();
        //     console.log('dddd');
        // });
        // // rorm
        var showQuestion = document.querySelectorAll('.show-question');
        var modalQuest = document.querySelectorAll('.modal-quest');
        var closeQ =document.querySelectorAll('.modal-header-req');

        closeQ.forEach(function(Head){
            Head.addEventListener('click', function(){
                overflay.classList.remove('show-block');
                var headId = this.getAttribute('data-req-id');
                modalQuest.forEach(function(Body){
                    if(Body.getAttribute('data-req-id') == headId ){
                        Body.classList.remove('show-block');
                    }
                });
            });
        });

        showQuestion.forEach(function(item){
            item.addEventListener('click', function(){
                var idData = this.getAttribute('data-req-id');
                modalQuest.forEach(function(second){
                    if(second.getAttribute('data-req-id') == idData){
                        second.classList.add('show-block');
                        overflay.classList.add('show-block');
                    }
                });
            });
        });


        var butns = document.querySelectorAll('.show-bar');
        var formGo = document.querySelector('#modal-answer');
        var overflay = document.querySelector('.overlay');
        var inputId = document.querySelector('.feedback_id');
        var closeModals = document.querySelectorAll('#close-modal');

        closeModals.forEach(function(itemC){
            itemC.addEventListener('click', function(){
                overflay.classList.remove('show-block');
                modalEdits.forEach(function(item){
                    if(item.classList.contains('show-block')){
                        item.classList.remove('show-block');
                    }
                });
            });
        });

        overflay.addEventListener('click', function(){
                formGo.classList.remove('show-block');
                overflay.classList.remove('show-block');
                modalEdits.forEach(function(item){
                    if(item.classList.contains('show-block')){
                        item.classList.remove('show-block');
                    }
                });
                modalQuest.forEach(function(second){
                    if(second.classList.contains('show-block')){
                        second.classList.remove('show-block');
                    }
                });
                if(ModelDep.classList.contains('show-block')){
                    ModelDep.classList.remove('show-block');
                }
        });

        formGo.querySelector('#close-modal-delete').addEventListener('click', function(){
                formGo.classList.remove('show-block');
                overflay.classList.remove('show-block');
        });

        butns.forEach(function(item){
            var idData = item.getAttribute('data-req-id');
            item.addEventListener('click', function(){
                inputId.setAttribute('value', idData);
                formGo.classList.add('show-block');
                overflay.classList.add('show-block');
            });
        });

        var btnMarts = document.querySelectorAll('.mat-bar');
        var modalEdits =  document.querySelectorAll('.modal-edit');

        btnMarts.forEach(function(itemFirst){
            itemFirst.addEventListener('click', function(){
                var dataReq = this.getAttribute('data-matr');
                modalEdits.forEach(function(itemSecond){
                    if(itemSecond.getAttribute('data-material') == dataReq){
                        itemSecond.classList.add('show-block');
                        overflay.classList.add('show-block');
                    }
                });
            });
        });

    </script>
@endsection
