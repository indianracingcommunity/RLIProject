@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create A report</div>

                <div class="card-body">
                  <h1 class="text-center my-5">  Report </h1>
                  <form action="submit" method="POST">
                      @csrf
                    <div class="form-group">
                      <label for="against">Who Are you Reporting?</label>
                      <input type="text" class="form-control" id="against" name="against" placeholder="User's Name">
                    </div>
                    <div class="form-group">
                      <label for="track">At which track did this incident take place</label>
                      <select class="form-control" id="track" name="track">
                        <option>Australia</option>
                        <option>Bahrain</option>
                        <option>China</option>
                        <option>Baku</option>
                        <option>Spain</option>
                        <option>Monaco</option>
                        <option>Canada</option>
                        <option>France</option>
                        <option>Silverstone</option>
                        <option>Germany</option>
                        <option>Belgium</option>
                        <option>Italy</option>
                        <option>Singapore</option>
                        <option>Russia</option>
                        <option>Japan</option>
                        <option>Mexico</option>
                        <option>USA</option>
                        <option>Brazil</option>
                        <option>Abu Dhabi</option>

                        
                      </select>
                    </div>
              
                {{--       <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="inquali" name="inquali">
                        <label class="form-check-label" for="defaultCheck1">
                          Did the Incident take place in Qualifiying?
                        </label>
                      </div>    --}}
                   <br>
                    <div class="form-group">
                        <label for="lap">On Which lap did the incident take place</label>
                        <input type="text" class="form-control" id="lap" placeholder="Lap Number" name="lap">
                      </div>
                    <div class="form-group">
                      <label for="explained">Elaborate the Issue</label>
                      <textarea class="form-control" id="explained" rows="3" name="explained"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="proof">Video Proof</label>
                        <input type="text" name="proof" class="form-control" id="proof" placeholder="Youtube link (For multiple videos seperate links with commas)">
                      </div>
                      <br>
                      <input type="submit" class="btn btn-primary" value="Submit report" style="margin-left:40%">
                  </form>
            
         


                </div>
            </div>
        </div>
    </div>
</div>
@endsection