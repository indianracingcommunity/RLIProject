<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Indian Racing Community</title>
      <link rel="icon" href="{{url('/img/IRC_logo/logo_square.png')}}">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <script src="/js/jquery.js"></script>
      <script src="/js/popper.min.js"></script>
      <script src="/js/bootstrap.min.js"></script>
   </head>
   <body class="bg-light">
      <nav class="navbar navbar-expand-md fixed-top navbar-dark" style="background: red;">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
               <li style="height: 80px; width: 80px;" class="nav-item rounded-lg text-center visible-xs p-3 bg-dark">
                  <a href="/"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"></a>
               </li>
               <li class="nav-item p-3">
                  <a class="nav-link text-light text font-weight-bold" href="/joinus"><i class='fas fa-handshake' style='color:white'></i>  Join Us</a>
               </li>
               <li class="nav-item p-3">
                  <a class="nav-link text-light text font-weight-bold" href="/standings"><i class='fas fa-trophy' style='color:springgreen'></i>  Championship Standings</a>
               </li>
               <li class="nav-item p-3">
                  <a class="nav-link text-light text font-weight-bold" href="/report"><i class='far fa-edit'></i>  Report</a>
               </li>
               <li class="nav-item p-3">
                  <a class="nav-link text-light text font-weight-bold" href="/aboutus"><i class='far fa-address-card'></i>  About Us</a>
               </li>
               <li class="nav-item p-3">
                  <a class="nav-link text-light text font-weight-bold" href="/login"><i class='far fa-user'></i>  Login</a>
               </li>
            </ul>
         </div>
      </nav>
      @yield('body')
   </body>
</html>