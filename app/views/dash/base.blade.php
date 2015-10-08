@include('templates.header')
@yield('bc', '')
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#minibar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Servers</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="minibar">
      @if($page == 'DashBoard')
      <div class="navbar-form navbar-left">
        <div class="form-group">
          <input id="search" type="text" class="form-control" placeholder="Search">
        </div>
      </div>
      @endif
      <ul class="nav navbar-nav navbar-right">
        @if($page == 'DashBoard')
        @if(isset($servers[0]))
        <li><a id="dbutton" href="#"><span class="glyphicon glyphicon-eye-open"></span> Decrypt Passwords</a></li>
        <li><a id="tbutton" href="#"><span class="glyphicon glyphicon-sort"></span> Toggle Servers</a></li>
        @endif
        @endif
        <li><a href="{{route('addserver')}}"><span class="glyphicon glyphicon-plus-sign"></span> Add Server</a></li>
        <li><a id="delbuttonnav" href="#"><span class="glyphicon glyphicon-remove-circle"></span> Delete Server</span></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
@yield('body')
@include('templates/footer')