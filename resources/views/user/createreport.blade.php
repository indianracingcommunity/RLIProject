@extends('layouts.app')
<style>
  td {
    padding-top: 1em
  }
</style>
@section('content')

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<div class="container flex w-screen">
  <div class="mx-auto p-4 border rounded-lg w-2/3  m-24">
    <div class="font-semibold text-lg tracking-widest uppercase pb-4 flex justify-center">Create a report</div>
    <form action="{{route('report.submit')}}" method="POST" class="my-4">
      @csrf
       {{-- {!! dd($data) !!}  --}}
      <table class="w-full">
        <tr>
          <td>
            <label for="against" class="font-semibold">Race</label>
          </td>
          <td>
            <select class="border border-black rounded py-2 px-3 w-full" id="race" name="race">
              @for ($i =0 ; $i <count($data) ; $i++) <option value="{{$data[$i]['id']}}">{{$data[$i]['circuit']['name'] ." - ".$data[$i]['season']['name']}} </option>
                @endfor
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="against" class="font-semibold">Who do you want to report?</label>
          </td>
          <td class="flex justify-around">
            <span>
              <input type="radio" name="report_type" id="report_type_1"> Driver
            </span>
            <span>
              <input type="radio" name="report_type" id="report_type_2"> Game
            </span>
          </td>
        </tr>
        <tr class="hidden" id="report_drivers">
          <td>
            <label for="against" class="font-semibold">Who are you reporting?</label>
          </td>
          <td>
            <select class="border border-black rounded py-2 px-3 w-full" id="driver" name="driver[]">
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <label for="lap" class="font-semibold">Lap Number</label>
          </td>
          <td>
            <input type="number" class="border border-black rounded py-2 px-3 w-full" id="lap" placeholder="Lap Number" name="lap" min=0>
          </td>
        </tr>
        <tr>
          <td>
            <label for="explained" class="font-semibold">Elaborate the Issue</label>
          </td>
          <td>
            <textarea class="border border-black rounded py-2 px-3 w-full" id="explained" rows="3" name="explained"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="proof" class="font-semibold">Video Proof</label>
          </td>
          <td>
            <input type="text" name="proof" class="border border-black rounded py-2 px-3 w-full" id="proof" placeholder="Youtube link">
            <div class="text-xs font-semibold text-gray-600">
              For multiple videos seperate it by comma
            </div>
          </td>
        </tr>
      </table>
      <div class="flex">
        <input type="submit" class="bg-orange-500 hover:bg-orange-600 cursor-pointer font-semibold px-4 py-2 rounded text-white mx-auto my-6" value="Submit report">
      </div>
    </form>
  </div>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type='text/javascript'>
  $(document).ready(function() {

    $('#race').change(function() {

      var id = $(this).val();

      // Empty the dropdown
      $('#driver').find('option').not(':first').remove();

      // AJAX request 
      $.ajax({
        url: '/fetch/drivers/' + id,            //Need to replace with Named Route
        type: 'get',
        dataType: 'json',
        success: function(response) {
          var len = 0;
          if (response != null) {
            len = response.length;
          }
          if (len > 0) {
            // Read data and create <option >

            for (var i = 0; i < len; i++) {

              var id = response[i].id;
              var name = response[i].name;

              var option = "<option value='" + id + "'>" + name + "</option>";

              $("#driver").append(option);
            }
          }

        }
      });
    });

    $("#report_type_1").change(function() {
      $("#report_drivers").show('slow/400/fast', function() {});
    })
    $("#report_type_2").change(function() {
      $("#report_drivers").hide('slow/400/fast', function() {});
    })

  });
</script>
@endsection