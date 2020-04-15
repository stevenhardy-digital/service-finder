<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin | Help you community</title>

  <link href="{{ asset('css/app.css')}}" rel="stylesheet">
  <link href="{{ asset('css/admin.css')}}" rel="stylesheet">
  <!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"><img src="{{asset('/images/help-your-community-logo.jpg')}}"/></div>
      <div class="list-group list-group-flush">
        @if(Auth::user()->admin)
          <a href="/admin" class="list-group-item list-group-item-action bg-light">Dashboard</a>
          <a href="/admin/locations" class="list-group-item list-group-item-action bg-light">Locations</a>
          <a href="/admin/categories" class="list-group-item list-group-item-action bg-light">Categories</a>
          <a href="/admin/services" class="list-group-item list-group-item-action bg-light">Services</a>
        @else
          <a href="/dashboard" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        @endif
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a class="dropdown-item" href="https://helpyourcommunity.co.uk">
                        {{ __('View website') }}
                    </a>
                </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
</body>

</html>