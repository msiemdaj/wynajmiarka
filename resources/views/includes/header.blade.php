<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="/">Strona główna</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('ogloszenia*') && !request()->is('ogloszenia/dodaj')) ? 'active' : '' }}" href="/ogloszenia">Ogłoszenia</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('ogloszenia/dodaj*')) ? 'active' : '' }}" href="/ogloszenia/dodaj">Dodaj ogłoszenie</a>
              </li>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->routeIs('login')) ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Zaloguj') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('register')) ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Stwórz konto') }}</a>
                        </li>
                    @endif
                @else
                  <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('twojeogloszenia')) ? 'active' : '' }}" href="{{ route('twojeogloszenia') }}">Twoje ogłoszenia</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link {{ (request()->routeIs('skrzynka')) ? 'active' : '' }}" href="{{ route('skrzynka') }}">Wiadomości
                      @if($msgCount)
                      <span class="badge badge-pill badge-danger">{{$msgCount}}</span>
                      @endif
                    </a>
                  </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="/ustawienia">
                              {{ __('Ustawienia') }}
                          </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Wyloguj') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
