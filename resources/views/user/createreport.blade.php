@extends('layouts.app')
<style>
  td {
    padding: 1em
  }
</style>
@section('content')
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<div class="container">
  <div class="font-bold text-xl">Create a report</div>
    <form action="submit" method="POST" class="my-4">
        @csrf
        <table>
          <tr>
            <td>
              <label for="against" class="font-semibold">Race</label>
            </td>
            <td>
              <select class="border rounded py-2 px-3 w-64" id="race" name="race">
                @for ($i =0 ; $i <count($data) ; $i++)
                <option value="{{$data[$i]['id']}}">{{$data[$i]['circuit']['name'] ." | ".$data[$i]['season']['name']}} </option>
                    
                @endfor
              </select>
            </td>
          </tr>
          <tr>
            <td>
              <label for="against" class="font-semibold">Who are you reporting?</label>
            </td>
            <td>
              <select class="border rounded py-2 px-3 w-64" id="driver" name="driver">
              </select>
            </td>
          </tr>
          
          <tr>
            <td>
              <label for="lap" class="font-semibold">On Which lap did the incident take place</label>
            </td>
            <td>
              <input type="text" class="border rounded py-2 px-3 w-64" id="lap" placeholder="Lap Number" name="lap">
            </td>
          </tr>
          <tr>
            <td>
              <label for="explained" class="font-semibold">Elaborate the Issue</label>
            </td>
            <td>
              <textarea class="border rounded py-2 px-3 w-64" id="explained" rows="3" name="explained"></textarea>
            </td>
          </tr>
          <tr>
            <td>
              <label for="proof" class="font-semibold">Video Proof</label>
            </td>
            <td>
              <input type="text" name="proof" class="border rounded py-2 px-3 w-64" id="proof" placeholder="Youtube link">
              <div class="text-xs font-semibold text-gray-600">
                For multiple videos seperate it by comma
              </div>
            </td>
          </tr>
        </table>
        <input type="submit" class="bg-orange-500 hover:bg-orange-600 cursor-pointer font-semibold px-4 py-2 rounded text-white" value="Submit report">
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type='text/javascript'>

  $(document).ready(function(){

    $('#race').change(function(){
      
       var id = $(this).val();
      
       // Empty the dropdown
       $('#driver').find('option').not(':first').remove();

       // AJAX request 
       $.ajax({
         url: '/fetch/drivers/'+id,
         type: 'get',
         dataType: 'json',
         success: function(response){
           var len = 0;
           if(response!= null){
             len = response.length;
           }
           if(len > 0){
             // Read data and create <option >
              
             for(var i=0; i<len; i++){

               var id = response[i].id;
               var name = response[i].name;

               var option = "<option value='"+id+"'>"+name+"</option>"; 

               $("#driver").append(option); 
             }
           }

         }
      });
    });

  });

  </script>
@endsection