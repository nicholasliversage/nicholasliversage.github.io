<nav>
  <div class="nav-wrapper blue darken-4">
    <a href="/" class="brand-logo center">
      <i class="material-icons">local_drink</i>{{ config('app.name', 'EDMS') }}
    </a>
    <a href="#" data-activates="mobile-demo" class="button-collapse">
      <i class="material-icons">menu</i>
    </a>
    <!-- Mobile View -->
    <ul class="side-nav" id="mobile-demo">
      @if(Auth::guest())
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
      @else
        <li><a href="/shared">Partilhado</a></li>
        <li><a href="/documents">Documentos</a></li>
        <li><a href="/mydocuments">Meus Documentos</a></li>
        <li><a href="/categories">Categorias</a></li>
        @hasanyrole('Root|Admin')
        <li><a href="/users">Usuarios</a></li>
        <li><a href="/departments">Departmentos</a></li>
        <li><a href="/logs">Logs</a></li>
        @hasrole('Root')
        <li><a href="/backup">Backup</a></li>
        @endhasrole
        @endhasanyrole
        <li class="divider"></li>
        <li><a href="/profile">Meu Perfil</a></li>
        <li>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
      @endif
    </ul>
    <!-- Desktop View -->
    <ul class="right hide-on-med-and-down">
      <!-- Authentication Links -->
      @if (Auth::guest()==false)
       
        <li>
          <a href="" class="datepicker"><i class="material-icons">date_range</i></a>
        </li>
        <li>
          @if($trashfull > 0)
          <a href="/trash"><i class="material-icons red-text">delete</i></a>
          @else
          <a href="/trash"><i class="material-icons">delete</i></a>
          @endif
        </li>
        
        <li>
          <a href="/requests">Pedidos<span class="new badge white-text">{{ $requests }}</span></a>
        </li>
     
        <li>
          <a class="dropdown-button" href="#!" data-activates="dropdown1">{{ Auth::user()->name }}
            <i class="material-icons right">arrow_drop_down</i>
          </a>
        </li>
      @endif
    </ul>
  </div>
</nav>
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
  <li><a href="/profile">Meu Perfil</a></li>
  <li><a href="/mydocuments">Meus Documentos</a></li>
  <li>
      <a href="{{ route('logout') }}"
          onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
          Logout
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
  </li>
</ul>
