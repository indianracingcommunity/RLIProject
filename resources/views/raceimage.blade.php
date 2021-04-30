
<!DOCTYPE html>
<html>
 <head>
  <title>File Uploading in Laravel</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  
  <div class="container">
   <h3 align="center">Race Results Upload</h3>
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
   <img src="/images/{{ Session::get('path') }}" width="300" />
   @endif
   <form method="post" action="{{url('/parse/f1/race')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
    <select class="form-control" style="width:350px" name="season" id="exampleFormControlSelect1">
       @foreach($seasons as $season)
        <option value="{{$season['id']}}">{{$season['name']}}</option>
       @endforeach
     </select>
     <br>
     <label for="exampleFormControlSelect1">Round Select</label>
     <input type="number" name="round" style="width:100px" class="form-control" aria-label="Text input with dropdown button">
     <br>
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Select File for Upload</label></td>
       <td width="30"><input type="file" name="photo" /></td>
       <td width="30%" align="left"><input type="submit" name="upload" class="btn btn-primary" value="Upload"></td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">jpg, jpeg, png</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>
   <br />
  </div>
 </body>
</html>