<!DOCTYPE html>
<html lang="en">
<head>
  <title>IRC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="/js/jquery.js"></script>
  <script src="/js/popper.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</head>

<body class="bg-dark">

  <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse  navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav">
              <li class="nav-item  p-3">
               <a class="nav-link text-dark text font-weight-bold " href="/">Home</a>
              </li>
              <li class="nav-item p-3">
                <a class="nav-link text-dark text font-weight-bold" href="/joinus">Join Us</a>
              </li>
              <li class="nav-item p-3">
                <a class="nav-link text-dark text font-weight-bold" href="/teamsanddrivers">Teams And Drivers</a>
              </li>
              <li class="nav-item p-3">
                <a class="nav-link text-dark text font-weight-bold" href="/standings">Championship Standings</a>
              </li>
              <li class="nav-item p-3">
                <a class="nav-link text-dark text font-weight-bold" href="/report">Report</a>
              </li>
              <li class="nav-item p-3">
                <a class="nav-link text-dark text font-weight-bold" href="/aboutus">About Us</a>
              </li>
              <li class="nav-item p-3" style="">
                <a class="nav-link text-dark text font-weight-bold" href="/login">Login</a>
              </li>
          </ul>
    </div>
  </nav>

@yield('body')

</body>
</html>