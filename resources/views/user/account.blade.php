@extends('user.layout.template')
@section('title', 'Мій аккаунт')
@section('content')
<div class="page__title">
    <a href="{{ route('user.index') }}">Головна</a>
    <img src="{{ asset('img/next.png') }}" alt="">
    <a href="{{ route('user.account') }}">Мій аккаунт</a>
</div>
<div class="user-info block">
    <div class="child-item">
        <div class="title-edit">
            <h1>
                Загальна інформація
            </h1>
        </div>
        <div class="wrapped-child">
            <div class="user-group">
                <label for="userName">
                    <input type="text" readonly name="" id="userName" class="text-input" value="{{ $userName }}">
                    <p>Ім'я</p>
                </label>
                <label for="userSurname">
                    <input type="text" readonly name="" id="userSurname" class="text-input" value="{{ $surName }}">
                    <p>Прізвище</p>
                </label>
                <label for="userPatronymic">
                    <input type="text" value="ggffff" readonly name="" id="userPatronymic" class="text-input" value="{{ $patronymic }}">
                    <p>По батькові</p>
                </label>
            </div>
        </div>
    </div>

    <div class="child-item">
        <div class="title-edit">
            <h1>
                Інформація про акаунт
            </h1>
        </div>
        <div class="wrapped-child">
            <form action="{{ route('user.resetEmail') }}" method="POST">
                @csrf
                <div class="user-group">
                    <label for="userEmail">
                        <input type="email" style="width: 268px;" disabled="true" id="userEmail" class="text-input" value="{{ $email }}">
                        <p>Пошта</p>
                    </label>
                    <label for="userNewEmail">
                        <input type="email" style="width: 268px;" required name="new-email" id="userNewEmail" class="text-input">
                        <p>Нова пошта</p>
                    </label>
                    <button type="submit" class="btn-submit-input">Оновити</button>

                    @if (session('successEmail'))
                        <div class="email-reset">
                            {{ session()->get('successEmail') }}
                        </div>
                    @endif
                    @if (session('errorReset'))
                        <div class="email-error">
                            {{ session()->get('errorReset') }}
                        </div>
                    @endif

                    <ul>
                    @error('new-email')
                        <div class="email-error">{{ $message }}</div>
                    @enderror
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <!-- </div> -->

    <div class="child-item">
        <div class="title-edit">
            <h1>
                Інформація про викладача
            </h1>
        </div>
        <div class="wrapped-child">
            <div class="user-detals">
                <label for="userFaculty">
                    <input type="text" disabled="true" name="" id="userFaculty" class="text-input"value="{{ $facultyName }}">
                    <p>Факультет</p>
                </label>
                <label for="userDepartament">
                    <input type="text" disabled="true" name="" id="userDepartament" class="text-input"value="{{$departamentName}}">
                    <p>Кафедра</p>
                </label>
                <label for="userAcademicDegree">
                    <input type="text" disabled="true" name="" id="userAcademicDegree" class="text-input"value="{{$degreeName}}">
                    <p>Наукова ступінь</p>
                </label>
                <label for="userType">
                    <input type="text" disabled="true" name="" id="userType" class="text-input" value="{{$userPost}}">
                    <p>Посада</p>
                </label>
            </div>
        </div>
    </div>
    <!--  -->
    <div class="child-item">
        <div class="title-edit">
            <h1>
                Змінити пароль
            </h1>
        </div>
        <div class="wrapped-child">
            <form action="{{ route('user.resetPass') }}" method="POST">
                @csrf
                <div class="user-group">
                    <label for="userOldPassword">
                        <input type="password" required name="old-password"
                            id="userOldPassword" class="text-input">
                        <p>Поточний пароль</p>
                    </label>
                    <label for="userNewPassword">
                        <input type="password" required name="new-password" id="userNewPassword"
                            class="text-input" pattern="{8,}">
                        <p>Новий пароль</p>
                    </label>
                    <label for="userNewPasswordReplay">
                        <input type="password" required name="replay-password" id="userNewPasswordReplay"
                            class="text-input" pattern="{8,}">
                        <p>Повторіть пароль</p>
                    </label>
                    <button type="submit" class="btn-submit-input">Оновити</button>

                    @if (session('successPass'))
                        <div class="email-reset">
                            {{ session()->get('successPass') }}
                        </div>
                    @endif
                    @if (session('errorPass'))
                        <div class="email-error">
                            {{ session()->get('errorPass') }}
                        </div>
                    @endif
                    <ul>
                        @error('new-password')
                            <div class="email-error">{{ $message }}</div>
                        @enderror
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <div class="child-item">
        <div class="title-edit">
            <h1>
                <a id="showFormDeleteAccount" href="#">Видалити акаунт</a>
            </h1>
        </div>
        @if (session('successSend'))
            <div class="send-message">
                {{ session()->get('successSend') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('in-body')
    <div class="wrapped-form-delete">
        <div class="form-delete">
            <div class="exit">
                <img class="hendler-close" src={{ asset('img/window-close.png') }} alt="close">
            </div>
            <form action="{{ route('user.delete-account') }}" method="POST">
                @csrf
                <label for="contentCause">
                    <textarea required name="content-message" id="contentCause" class="text-input"></textarea>
                    <p>Причина видалення</p>
                </label>
                <button type="submit">Відправити</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script defer>
        var showForm = document.getElementById("showFormDeleteAccount");
        showForm.addEventListener("click", function (event) {
            event.preventDefault();
            FormDeleteAccount(".wrapped-form-delete", ".hendler-close");
        });
    </script>
@endsection
