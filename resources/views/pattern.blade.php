<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Языковая школа LINGVO</title>
    <link rel="stylesheet" href="{{asset('storage/stylesheets/foundation.min.css')}}">
    <link rel="stylesheet" href="{{asset('storage/stylesheets/main.css')}}">
    <link rel="stylesheet" href="{{ asset('storage/stylesheets/app.css') }}">
    <script src="{{asset('storage/javascripts/modernizr.foundation.js')}}"></script>
    <link rel="stylesheet" href="{{asset('storage/fonts/ligature.css')}}">
    <link href='{{asset('http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Playfair+Display:400italic')}}' rel='stylesheet' type='text/css' />
    <script src="{{asset('http://html5shiv.googlecode.com/svn/trunk/html5.js')}}"></script>
</head>
<body>
<nav>
    @yield('nav')
    <div class="twelve columns header_nav">
        <div class="row">
            <ul id="menu-header" class="nav-bar horizontal">
                <li><a href="/index">Главная</a></li>
                @foreach($query as $i)
                    <li><a href="{{ route('Course_Id', ['course' => $i->id]) }}">{{$i->category_name}}</a></li>
                @endforeach
                @can('police_admin')
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Сервисы</a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin">Админ панель</a></li>
                        <li><a href="/list/course/user">Список записей</a></li>
                        <li><form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();" style="color: black">
                                    {{ __('Выйти') }}
                                </x-dropdown-link>
                            </form></li>
                    </ul>
                </li>
                @endcan
                @can('police_user')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Сервисы</a>
                        <ul class="dropdown-menu">
                            <li><a href="/index">Список курсов</a></li>
                            <li><a href="/list">Список моих записей</a></li>
                            <li><form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();" style="color: black">
                                        {{ __('Выйти') }}
                                    </x-dropdown-link>
                                </form></li>
                        </ul>
                    </li>
                @endcan
                @if(\Illuminate\Support\Facades\Auth::user() == null)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Сервисы</a>
                        <ul class="dropdown-menu">
                            <li><a href="/login">Войти</a></li>
                            <li><a href="/register">Регистрация</a></li>
                        </ul>
                    </li>
                @endif

                @if(\Illuminate\Support\Facades\Auth::user() != null)
                    <li><span style="font-weight: bold; font-size: 20px;">{{\Illuminate\Support\Facades\Auth::user()->name}}</span></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<header>
@yield('header')
</header>

<section>
@yield('form')
</section>


<section class="section_light">
    @yield('section')
</section>

<section>
    @yield('images')
    <div class="section_dark">
        <div class="row">
            <div class="two columns">
                <img src="{{asset('storage/images/thumb1.jpg')}}" alt="desc" />
            </div>
            <div class="two columns">
                <img src="{{asset('storage/images/thumb2.jpg')}}" alt="desc" />
            </div>
            <div class="two columns">
                <img src="{{asset('storage/images/thumb3.jpg')}}" alt="desc" />
            </div>
            <div class="two columns">
                <img src="{{asset('storage/images/thumb4.jpg')}}" alt="desc" />
            </div>
            <div class="two columns">
                <img src="{{asset('storage/images/thumb5.jpg')}}" alt="desc" />
            </div>
            <div class="two columns">
                <img src="{{asset('storage/images/thumb6.jpg')}}" alt="desc" />
            </div>
        </div>
    </div>
</section>

<footer>
    @yield('footer')
    <div class="row">
        <div class="twelve columns footer">
            <a href="" class="lsf-icon" style="font-size:16px; margin-right:15px" title="twitter">Twitter</a>
            <a href="" class="lsf-icon" style="font-size:16px; margin-right:15px" title="facebook">Facebook</a>
            <a href="" class="lsf-icon" style="font-size:16px; margin-right:15px" title="pinterest">Pinterest</a>
            <a href="" class="lsf-icon" style="font-size:16px" title="instagram">Instagram</a>
        </div>
    </div>
</footer>

<script src="javascripts/foundation.min.js" type="text/javascript"></script>
<script src="javascripts/app.js" type="text/javascript"></script>
</body>
</html>
