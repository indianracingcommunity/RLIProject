@extends('layouts.app')
<style>
  td {
    padding: 1em
  }
</style>
@section('content')
<div class="container">
  <div class="font-bold text-xl">Create a report</div>
    <form action="submit" method="POST" class="my-4">
        @csrf
        <table>
          <tr>
            <td>
              <label for="against" class="font-semibold">Who are you reporting?</label>
            </td>
            <td>
              <input type="text" class="border rounded py-2 px-3 w-64" id="against" name="against" placeholder="User's Name">
            </td>
          </tr>
          <tr>
            <td>
              <label for="track" class="font-semibold">At which track did this incident take place?</label>
            </td>
            <td>
              <select class="border rounded py-2 px-3 w-64" id="track" name="track">
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
      <!-- <div class="my-2">
        <label for="against" class="font-semibold">Who are you reporting?</label>
        <input type="text" class="border rounded py-2 px-3 mx-8" id="against" name="against" placeholder="User's Name">
      </div> -->
      <!-- <div class="my-2">
        <label for="track" class="font-semibold">At which track did this incident take place?</label>
        <select class="border rounded py-2 px-3" id="track" name="track">
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
      </div> -->

     <!-- <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" id="inquali" name="inquali">
          <label class="form-check-label" for="defaultCheck1">
            Did the Incident take place in Qualifiying?
          </label>
        </div> 

      <div class="form-group">
          <label for="lap" class="font-semibold">On Which lap did the incident take place</label>
          <input type="text" class="border rounded py-2 px-3" id="lap" placeholder="Lap Number" name="lap">
        </div> -->
      <!-- <div class="form-group">
        <label for="explained">Elaborate the Issue</label>
        <textarea class="form-control" id="explained" rows="3" name="explained"></textarea>
      </div>
      <div class="form-group">
          <label for="proof">Video Proof</label>
          <input type="text" name="proof" class="form-control" id="proof" placeholder="Youtube link (For multiple videos seperate links with commas)">
        </div>
        <br>
        <input type="submit" class="btn btn-primary" value="Submit report" style="margin-left:40%"> -->
    </form>
</div>
@endsection