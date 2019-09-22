@extends('layout')


@section('body')
<br>
<div class="card">
        <div class="card-header">
          Featured
        </div>
        <div class="card-body">
          <h1 class="card-title text-center">Ferrari Drivers</h1>
          
          
        </div>
      </div>
      @foreach ($driver as $drivers)
      <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <img src="{{url('/img/avatars/f1-car.png')}}" alt="" class="img-rounded" width="170" />
                            </div>
                            <div class="col-sm-6 col-md-8">
                                
                          
                               
                           @if($driver== reset($drivers)) @endif

                            <h4>{{$drivers->name}}</h4>

                                    


                                <small><cite title="">Driver <i class="glyphicon glyphicon-map-marker">
                                </i></cite></small>
                                <p>
                                    <i class="glyphicon glyphicon-envelope"></i>email@example.com
                                    <br />
                                    
                                    <br />
                                    
                                <!-- Split button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">
                                        Social</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span><span class="sr-only">Social</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Twitter</a></li>
                                        <li><a href="">Google +</a></li>
                                        <li><a href="">Facebook</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Github</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br><br><br>
        @endforeach    
@endsection