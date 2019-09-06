@extends('layouts.app')
@section('content')
    
@auth
<h1 class="text-center my-5"> Add a Driver  </h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                     <ul class="list-group">
                    @foreach ($errors ->all() as $error)
                         <li class="list-group-item">
                        {{$error}}
                         </li>
                            @endforeach  
                    
                    </ul> 
                    @endif
              
                    </div>
                        <form action="/store-data" method="POST">
                            @csrf
                                <div class="form-group">
                                    
                                <input type="text" class="form-control" name="name" placeholder="Name">
                                                       
                                </div>   
                                <div class="form-group">
                                  <input type="text" class="form-control" name="steamid" placeholder="Steam ID">
                                </div>   
                                <div class="form-group">
                                  <input type="text" class="form-control" name="discord" placeholder="Discord ID">
                                </div> 
                                
                                <div class="form-group">
                                        <input type="text" class="form-control" name="drivernumber" placeholder="Driver Number">
                                      </div> 

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="team" placeholder="Team Name">
                                      </div> 

                                      <div class="form-group">
                                        <input type="text" class="form-control" name="teammate" placeholder="Team Mate">
                                      </div> 
                                        
                                
                                <div class="form-group text-center">
                                    <button class="btn btn-success" type="submit">Add Driver</button>
                                </div>
                                </form>  
                </div>
            </div>
        </div>
         
        </div>
    </div>
    @endauth
    @guest 
            
    <div class="card-header body">
        You need to be an admin to View this page 
    </div>

@endguest
    
@endsection