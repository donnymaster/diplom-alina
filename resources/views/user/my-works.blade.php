@extends('user.layout.template')
@section('title', 'Мої роботи')
@section('content')
<div class="page__title">
    <a href="{{ route('user.index') }}">Головна</a>
    <img src="{{ asset('img/next.png') }}" alt="next">
    <a href="{{ route('user.works') }}">Мої роботи</a>
</div>

<div class="user-works block-no-padding">
    @if (isset($noWorks))
        <h1 style="text-align: center;padding: 20px 0;">{{ $noWorks }}</h1>
    @else
        <div class="header">
            <div class="header-item">
                <p>Кількість робіт на сторінці: {{$works->count()}}</p>
            </div>
            <div class="header-item">
                <form action="" method="get">
                    <label for="sort">
                        <p>Сортування</p>
                        @if (!empty($get_req))
                            <select name="value" id="sort">
                                <option value="1"
                                {{$get_req['val'] == 1 ? 'selected' : null }}
                                >навчальний рік</option>
                                <option value="2"
                                {{$get_req['val'] == 2 ? 'selected' : null }}
                                >дата запису плану</option>
                                <option value="3"
                                {{$get_req['val'] == 3 ? 'selected' : null }}
                                >назва роботи</option>
                                <option value="4"
                                {{$get_req['val'] == 4 ? 'selected' : null }}
                                >частка за планом</option>
                                <option value="5"
                                {{$get_req['val'] == 5 ? 'selected' : null }}
                                >частка за фактом</option>
                            </select>
                        @else
                        <select name="value" id="sort">
                            <option value="1">навчальний рік</option>
                            <option value="2">дата запису плану</option>
                            <option value="3">назва роботи</option>
                            <option value="4">частка за планом</option>
                            <option value="5">частка за фактом</option>
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
        </div>
        @if ($errors->any())
            <div class="wrapped-new-user-error">
                <ul class="show-errors-server">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
            @endif

            @if (session('errorSendMessage'))
                <div class="">
                    {{ session()->get('errorSendMessage') }}
                </div>
            @endif
            @if (session('successSend'))
                <div class="send-message">
                    {{ session()->get('successSend') }}
                </div>
            @endif

        <table class="main-table" style="margin-top:25px;">
            <tr>
                <th>
                    Назва роботи
                </th>
                <th>
                    Дата створення роботи
                </th>
                <th>
                    Ваша частка
                </th>
                <th>
                    Вид праці <span title="Тип виконаної роботи">*</span>
                </th>
                <th>
                    Детальніше
                </th>
                <th>
                    Редагувати <span title="Вкажіть що потрібно змінити і модератор виправить.">*</span>
                </th>
            </tr>

            @foreach ($works as $work)
                <tr>
                    <td>
                        {{ $work->title }}
                    </td>
                    <td>
                        {{ $work->created_at->format('m/d/Y') }}
                    </td>
                    <td>
                        {{ $work->user_count }}
                    </td>
                    <td>
                        {{ $work->work->indicator }}
                    </td>
                    <td>
                        <div class="show-bar">
                            <img data-work-id="{{ $work->id }}" data-modal="show" src="{{ asset('img/detail.png') }}" alt="show">
                        </div>
                    </td>
                    <td>
                        <div class="edit-bar">
                            <img data-name-work="{{ $work->title }}" data-modal="edit" src="{{ asset('img/spec-edit.png') }}" alt="edit">
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    @isset($works)
    <div class="wrapped-elements">
        {{ $works->appends(request()->query())->onEachSide(2)->links() }}
    </div>
    @endisset
    <!-- Modal window show work -->


    @if (!isset($noWorks))
        @foreach ($works as $work)
        <div class="modal-edit" modal="edit-{{ $work->id }}" data-work-id="{{ $work->id }}">
            <div class="modal-header">
                <img id="close-modal-edit" data-work-id="{{ $work->id }}" src="{{ asset('img/delete.png') }}" alt="close">
            </div>
            <div class="modal-body">
                <form action="">
                    <label for="tema">
                        <p>Назва роботи</p>
                        <h2 style="font-size: 20px; font-weight: 500;padding-bottom: 10px;
                    ">{{ $work->title }}</h2>
                    </label>
                    <label for="tema">
                        <p>Опис роботи</p>
                        <textarea class="fix-textarea text-input"
                        style="border-radius: 0"
                        >{{ $work->description }}</textarea>
                    </label>
                    <h3 class="work-title-h3">Характеристика роботи</h3>
                    <table class="main-table form-work fix-table">                  
                        <tr>
                            <td>
                            <p>Ваша частка</p>
                            </td>
                            <td>
                                {{ $work->user_count }}
                            </td>
                        </tr>
                        <tr>
                            <td><p>Дата запису плану</p></td>
                            <td>{{ $work->created_at->format('m/d/Y') }}</td>
                        </tr>
                        @isset($work->category_science)
                            <tr>
                                <td><p>Тип виконуваної роботи</p></td>
                                <td>{{ $work->category_science->category_name }}</td>
                            </tr>
                        @endisset
                    </table>
                </form>
                @if ($work->materials)
                    <p class="dop-materials">Додаткові матеріали</p>
                    <table class="main-table form-work">
                        @foreach (json_decode($work->materials) as $item)
                        <tr>
                            <td>
                            <a href="{{ URL::to($item->link) }}">{{ $item->title }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
        @endforeach
    @endif

    <!-- Modal window show work -->

    <!-- Modal window edit -->
    <div class="modal" modal="edit">
        <div class="modal-header">
            <img id="close-modal" src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">
            <form action="{{ route('user.EditWork') }}" method="POST">
                @csrf
                <label for="tema">
                    <p>Тема</p>
                    <input type="text" id="tema" required readonly name="tema" value="" class="text-input">
                </label>
                <label for="">
                    <p>Вкажіть що потрібно змінити</p>
                    <textarea name="content" class="text-input" required></textarea>
                </label>
                <div class="form-btn">
                    <input type="submit" value="Отправить" class="btn-submit-input">
                </div>
            </form>
        </div>
    </div>
    <!-- Modal window edit -->
</div>
<div class="overlay"></div>
@endsection

@section('script')
    <script defer>

        var butShowWork = document.querySelectorAll('.show-bar img');
        var showModals = document.querySelectorAll('.modal-edit');
        var closeEdit = document.querySelectorAll('#close-modal-edit');

        closeEdit.forEach(function(item){
            item.addEventListener('click', function(item){
                var idClose =  this.getAttribute('data-work-id');
                showModals.forEach(function(item){
                    if(idClose == item.getAttribute('data-work-id')){
                        item.classList.remove('show-block');
                        overlay.classList.remove('show-block');
                    }
                });
            });
        });

        butShowWork.forEach(function(item){

            item.addEventListener("click", function(event){
            var butId =  this.getAttribute('data-work-id');

            showModals.forEach(function(item){
                var modalId = item.getAttribute('data-work-id');
                if(modalId == butId){
                    item.classList.add('show-block');
                    overlay.classList.add('show-block');
                }
            });
        });
        });



        /////////////////////////////////
        var arrayLinks = document.querySelectorAll(".edit-bar img");
        var modal = document.querySelector(".modal");
        var overlay = document.querySelector(".overlay");
        var closeModal = modal.querySelector("#close-modal");
        var titleForm = modal.querySelector('input#tema');

        arrayLinks.forEach(function (item) {
            item.addEventListener("click", function (event) {
                event.preventDefault();
                var title = "Відредагувати роботу " + item.getAttribute('data-name-work');

                titleForm.value = title;

                modal.classList.add('show-block');
                overlay.classList.add('show-block');

            });
        });

        // close

        overlay.addEventListener("click", function (event) {
            modal.classList.remove('show-block');
            showModals.forEach(function(item){
                if(item.classList.contains('show-block')){
                    item.classList.remove('show-block');
                }
            });
            overlay.classList.remove('show-block');
        });

        closeModal.addEventListener("click", function (event) {
            modal.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });


    </script>
@endsection
