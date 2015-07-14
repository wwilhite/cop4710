<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button ng-click="isCollapsed = !isCollapsed" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#/events">College Events</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div collapse="isCollapsed" class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a ng-click="isCollapsed = true" ng-show="loggedin" ng-href="#/{{homepage}}">My Homepage</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <!-- Create Account Drop down -->
        <li class="dropdown" ng-hide="loggedin">
          <a class="dropdown-toggle" href data-toggle="dropdown" role="button">Create Account <span class="caret"></span></a>
          <div class="dropdown-menu" style="padding:15px; width: 450px;" role="menu">
            <create-account></create-account>
          </div>
        </li>
        <!-- Login Drop down -->
        <li class="dropdown " ng-hide="loggedin">
          <a href class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Login <span class="caret"></span></a>
          <div class="dropdown-menu" style="padding:15px; width: 350px;" role="menu">
            <login></login>
          </div>
        </li>
        <!-- Logout button -->
        <li class="dropdown" ng-show="loggedin">
        <a href class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ firstname }} 
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="caret"></span></a>
        	<ul class="dropdown-menu" role="menu">
        		<li><a ng-click="logout(); isCollapsed = true" href="javascript:void(0)">Logout</a></li>
        	</ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>