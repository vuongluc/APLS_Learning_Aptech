<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>APLS</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  
  <script src="{{asset('js/jquery.slim.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>  
  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="#">APLS</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{route('classtypes.index') }}">ClassType
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('status.index')}}">Status</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('modules.index')}}">Module</a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link" href="{{route('studentss.index')}}">Student</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{route('teachers.index')}}">Teacher</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('classes.index')}}">Classes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('enrolls.index')}}">Enroll</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('evaluate.index')}}">Evaluate</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('chart.index')}}">Chart</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
    @yield('content')
  </div>

  <!-- Bootstrap core JavaScript -->
<script>
  let path = window.location.pathname.split("/")[1];

  var tager = $('nav div div ul li.nav-item a[href="' +"http://127.0.0.1:8000/"+ path +'" ]');

  tager.addClass('active');

</script>
  


</body>

</html>
