@extends('moderator.layout.template')
@section('title', 'Зв\'язатися з адміністратором')
@section('lib-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" integrity="sha256-soW/iAENd5uEBh0+aUIS1m2dK4K6qTcB9MLuOnWEQhw=" crossorigin="anonymous" />
@endsection
@section('content')
<div class="page__title">
    <a href="{{ route('moderator.index') }}">Головна</a>
    <img src="{{ asset('img/next.png') }}" alt="">
    <a href="{{ route('moderator.feedback') }}">Зв'язатися з адміністратором</a>
</div>
<div class="user-feedback block">
    @if (session('successFeedback'))
    <div class="send-mes">
        <h1>{{ session()->get('successFeedback') }}</h1>
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

    <form action="{{ route('moderator.feedbackSend') }}" id="form-update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-header">
            <label for="tema">
                <p>Тема</p>
                <input id="tema" name="tema" type="text" class="text-input" required>
            </label>
            <label for="">
                <p>Одержувач</p>
                <select name="type-user" id="type-user">
                    <option value="3">Адміністратор</option>
                </select>
            </label>
        </div>
        <textarea class="text-input" name="content" required></textarea>
        <div class="form-buttom-group">
            <div class="add-files">
                <p>Додаткові матеріали</p>
                <input type="file" id="files-add" name="attachment[]" multiple/>
            </div>
                <button type="submit" id="form-send-f" class="btn-submit-input">Відправити</button>
        </div>
    </form>
</div>
<input type="text" hidden id="max_file_size" value="{{ ini_get('post_max_size') }}">
<input type="text" hidden id="max_file_uploads" value="{{ ini_get('max_file_uploads') }}">
<input type="text" hidden id="memory_limit" value="{{ ini_get('memory_limit') }}">
@endsection

@section('scriptUser')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha256-ITwLtH5uF4UlWjZ0mdHOhPwDpLoqxzfFCZXn1wE56Ps=" crossorigin="anonymous"></script>
@endsection

@section('in-body')
<script defer>


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
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha256-pEdn/pJ2tyT37axbEIPkyUUfuG1yXR0+YV+h+jphem4=" crossorigin="anonymous"></script>
<script src="{{ asset('js/save-files.js') }}"></script>
@endsection

