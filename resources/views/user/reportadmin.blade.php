
<!DOCTYPE html>
<html>
 <head>
  <title>Publish/Revert Reports</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  
  <div class="container">
   <h3 align="center">Publish/Revert Reports</h3>
   <br />
   @if (count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif
   @if ($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <form method="post" action="{{route('steward.publish')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
    <select class="form-control" style="width:350px" name="season" id="exampleFormControlSelect1">
       @foreach($seasons as $season)
        <option value="{{$season['id']}}">{{$season['name']}}</option>
       @endforeach
     </select>
     <br>
     <input type="submit" name="upload" class="btn btn-primary" value="Publish">
    </div>
   </form>
   <br />
  </div>
 </body>
</html>