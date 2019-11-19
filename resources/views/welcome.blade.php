@extends('layout')


@section('body')
<div class="col bg-dark pt-md-5 embed-responsive container">
    <br>
    <div class=" pt-4 text-center">
        <h1 class="display-3 font-weight-bold  font-italic text-white">INDIAN RACING COMMUNITY</h1>
    </div><hr class=" m-3 bg-info">

   <div id="demo" class="carousel slide pt-3" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>

        <div class="carousel-inner">
            <div class="carousel-item col active">
                 <div class="col-12 col">
                    <div class="card bg-secondary" style="width:1300px" >
                        <div class="card-body text-center">
                            <h2 class="display-4">Latest Race Results  Belgium GP</h2>
                            <h5 class="card-text"><strong>Race Winner : theKC66</strong></h5>
                            <h6 class="card-text">2nd Place : Freeman</h6>
                            <p class="card-text">3rd Place : kapilace6</p>
                            <a href="standings" class="btn btn-dark">Go to Standings</a>
                            <hr>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="carousel-item col">
                <div class="col-12 col ">
                    <div class="card bg-info" style="width:1300px" >
                        <div class="card-body text-center">
                            <h2 class="display-4">Want to be a part of this Community?</h2>
                            <h5 class="card-text"><strong>Only for Indians*</strong></h5>
                            <h6 class="card-text">Click on the button below to get the steps on how to join our community!</h6>
                            <a href="joinus" class="btn btn-dark">Join Us</a>
                            <a href="aboutus" class="btn btn-dark">About Us</a>
                            <hr>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="carousel-item col">
                <div class="col-12 col">
                    <div class="card bg-warning" style="width:1300px" >
                        <div class="card-body text-center">
                            <h2 class="display-4">Current Championship Standings</h2>
                            <h5 class="card-text"><strong>1st : theKC66</strong></h5>
                            <h6 class="card-text">2nd Place : Freeman</h6>
                            <p class="card-text">3rd Place : kapilace6</p>
                            <a href="standings" class="btn btn-dark">Go to Standings</a>
                            <hr>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
  
  <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@widgetbot/crate@3" async defer>
    new Crate({
      server: '641545840619683841',
      channel: '641545909565390869',
      shard: 'https://disweb.dashflo.net'
    })
  </script>
@endsection
