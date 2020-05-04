<div class="sidebar show">
    <div class="logo">
        <a href="/" class="project-logo">
            <img src="{{ asset('img/logo.png') }}" alt="1">
        </a>
    </div>
    <div class="btn-hide">
        <img src="{{ asset('img/hide.png') }}" alt="1">
    </div>
    <menu class="menu">
        <ul>
            <li>
            <a href="{{ route('user.addWork') }}">
                    <img src="{{ asset('img/icon1.png') }}" alt="1">
                    <p>Розмістити роботу</p>
                </a>
            </li>
            <li>
            <a href="{{ route('user.works') }}">
                    <img src="{{ asset('img/icon2.png') }}" alt="1">
                    <p>Мої роботи</p>
                </a>
            </li>
            <li>
            <a href="{{ route('user.feedback') }}">
                    <img src="{{ asset('img/icon3.png') }}" alt="1">
                    <p>Зв'язок з модератором</p>
                </a>
            </li>
        </ul>
    </menu>
    <menu class="mini-menu">
        <div class="wrapped-menu-menu">
        <ul>
            <li>
                <a href="{{ route('user.addWork') }}">
                    <img src="{{ asset('img/icon1.png') }}" alt="">
                </a>
            </li>
            <li>
                <a href="{{ route('user.works') }}">
                    <img src="{{ asset('img/icon2.png') }}" alt="">
                </a>
            </li>
            <li>
                <a href="{{ route('user.feedback') }}">
                    <img src="{{ asset('img/icon3.png') }}" alt="">
                </a>
            </li>
        </ul>
    </div>
    </menu>
</div>
