<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        {{-- @if (Route::has('login')) --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        {{-- @endif --}}

                        {{-- @if (Route::has('register') && env('STUDENTS_CAN_CREATE_THEIR_ACCOUNT')) --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        {{-- @endif --}}
                        @else

                        {{-- Check if the user is admin --}}
                        @if (auth()->user()->is_admin)
                        <li class="nav-item <?=(Route::current()->uri() == 'account' ? 'active':'')?>">
                            <a class="nav-link" href="/files">{{ __('File Share') }}</a>
                        </li>
                        <li class="nav-item <?=(Route::current()->uri() == 'account' ? 'active':'')?>">
                            <a class="nav-link" href="/account">{{ __('Create Account') }}</a>
                        </li>
                        <li class="nav-item <?=(Route::current()->uri() == 'account/login-history' ? 'active':'')?>">
                            <a class="nav-link" href="/account/login-history">{{ __('Login History') }}</a>
                        </li>
                        @elseif (auth()->user()->is_counselor)
                        <li class="nav-item <?=(Route::current()->uri() == 'account' ? 'active':'')?>">
                            <a class="nav-link" href="/files">{{ __('Shared Files') }}</a>
                        </li>
                        <li class="nav-item <?=(Route::current()->uri() == 'counselling-requests' ? 'active':'')?>">
                            <a class="nav-link" href="/counselling-requests">{{ __('Counselling Requests') }}</a>
                        </li>
                        @elseif (auth()->user()->is_student)
                        <li class="nav-item <?=(Route::current()->uri() == 'appointments' ? 'active':'')?>">
                            <a class="nav-link" href="/appointments">{{ __('Appointments') }}</a>
                        </li>
                        <li class="nav-item <?=(Route::current()->uri() == 'counselors' ? 'active':'')?>">
                            <a class="nav-link" href="/counselors">{{ __('Counselors') }}</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-capitalize" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->fname . ' ' . Auth::user()->lname }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item <?=(Route::current()->uri() == 'profile' ? 'active':'')?>"
                                    href="/profile">
                                    Profile
                                </a>

                                {{-- Logout --}}
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(url()->current() === 'http://counselling-system-for-students.test')
        <main class="pb-4">
            @else
            <main class="py-4">
                @endif
                @include('inc.messages')
                @yield('content')
            </main>
    </div>
    {{-- CKeditor files --}}
    <script src="/ckeditor5/ckeditor.js"></script>
    <script src="/ckeditor5/ckeditor.js.map"></script>
    <script>
        const watchdog = new CKSource.EditorWatchdog();

		window.watchdog = watchdog;

		watchdog.setCreator( ( element, config ) => {
			return CKSource.Editor
				.create( element, config )
				.then( editor => {




					return editor;
				} )
		} );

		watchdog.setDestructor( editor => {



			return editor.destroy();
		} );

		watchdog.on( 'error', handleError );

		watchdog
			.create( document.querySelector( '.editor' ), {

				toolbar: {
					items: [
						'heading',
						'|',
						'underline',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'undo',
						'redo',
						'-',
						'alignment',
						'fontBackgroundColor',
						'fontColor',
						'fontFamily',
						'fontSize',
						'highlight',
						'horizontalLine',
						'subscript',
						'superscript',
						'strikethrough',
						'insertTable',
						'blockQuote'
					],
					shouldNotGroupWhenFull: true
				},
				language: 'en',
				licenseKey: '',



			} )
			.catch( handleError );

		function handleError( error ) {
			console.error( 'Oops, something went wrong!' );
			console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
			console.warn( 'Build id: 8uo7e3v0si9i-uk35tb5rkyg' );
			console.error( error );
		}

    </script>
</body>

</html>
