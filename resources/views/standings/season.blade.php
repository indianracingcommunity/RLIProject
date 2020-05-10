@extends('layouts.app')
<style>
tr:nth-child(even) td {
  background-color: #EDF2F7;
  margin:5px;
}
table {
  width: 100%
}
th {
  padding: 10px;
  text-align: left;
}
tr:hover, td:hover {background-color: #E2E8F0;}
td {
  padding-left:10px;
  padding-top:5px;
  padding-bottom: 5px;
}
.card1 {
  background:linear-gradient(45deg,#f09819,#edde5d);

}

.card2 {
  /* background:linear-gradient(45.34deg, #EA52F8 5.66%, #0066FF 94.35%); */
  background-color: #2f4353;
background-image: linear-gradient(315deg, #d2ccc4 0%,#2f4353 74%);

}
.card3 {
  /* background:linear-gradient(45deg, #191654, #43C6AC);
   */
  background: #B79891;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #94716B, #B79891);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #94716B, #B79891); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */



}
</style>

@section('content')
<div class="container mx-auto flex">
  <div class="w-1/4">
  <div class="text-4xl font-bold text-gray-800">
    <i class="fas fa-chess-king text-purple-600"></i> Tier 1
  </div>
  <div class="text-2xl font-semibold text-gray-700">
    Season 4
  </div>
  <div class="bg-gray-100 rounded-md px-4 py-2 my-4">
    <div class="text-sm font-semibold my-2">
      Constructor Standings
    </div>
    <table>
      <thead>
      <tr>
        <th class="rounded-md bg-gray-300 border-2 border-white">Teams</th>
        <th  class="rounded-md bg-gray-300 border-2 border-white">Points</th>
      </tr>
      </thead>
      <tbody>
      @for ($i = 0 ; $i < 10; $i++)
        <tr class="cursor-pointer">
          <td class="font-semibold rounded-lg border border-white">
            Haass
          </td>
          <td class="font-semibold rounded-lg border border-white">
            123
          </td>
        </tr>
      @endfor 
      </tbody>
    </table>
  
  </div>
  <div class="border rounded-md p-3">
    <div class="text-xl font-semibold text-gray-600">
      Next Race
    </div>
    <div class="text-4xl font-semibold text-purple-700">
      Great Britain
    </div>
    <div class="mb-4">
      <img src="https://www.formula1.com/content/dam/fom-website/2018-redesign-assets/Circuit%20maps%2016x9/Great_Britain_Circuit.png.transform/9col/image.png" alt="">
    </div>
    <div class="flex justify-between font-semibold">
      <div>
        Circuit Length
      </div>
      <div class="text-lg text-blue-700">
        5.891 km
      </div>
    </div>
    <div class="flex justify-between font-semibold">
      <div>
        Number of laps
      </div>
      <div class="text-lg text-blue-700">
       30
      </div>
    </div>
  </div>
  </div>
  <div class="w-3/4 mx-5">
    <div class="flex mb-6">
      <div class="card1 mr-8 text-white p-4 rounded-md hover:shadow-lg w-1/6">
        <div class="text-4xl font-bold">
          1st
        </div>
        <div class="text-sm font-semibold">
          Ferrari
        </div>
        <div class="font-semibold">
          MaranelloBaby
        </div>
      </div>

      <div class="card2 mr-8 text-white p-4 rounded-md hover:shadow-lg w-1/6">
        <div class="text-4xl font-bold">
          2nd
        </div>
        <div class="text-sm font-semibold">
          Haas
        </div>
        <div class="font-semibold">
          GeneralPepe
        </div>
      </div>

      <div class="card3 mr-8 text-white p-4 rounded-md hover:shadow-lg w-1/6">
        <div class="text-4xl font-bold">
          3rd
        </div>
        <div class="text-sm font-semibold">
          Ferrari
        </div>
        <div class="font-semibold">
          dawn29
        </div>
      </div>
    </div>


    <div class="text-sm font-semibold">
    Drivers' Standings
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="rounded-md bg-gray-300 border-2 border-white">Position</th>
          <th class="rounded-md bg-gray-300 border-2 border-white">Driver</th>
          <th class="rounded-md bg-gray-300 border-2 border-white">Team</th>
          <th class="rounded-md bg-gray-300 border-2 border-white">Points</th>
        </tr>
      </thead>
      <tbody>
        @for ($i = 0 ; $i < $count; $i++)
          <tr class="cursor-pointer">
            <td class="font-semibold rounded-lg border border-white">{{$i+1}}</td>
            <td class="font-semibold rounded-lg border border-white">{{$res[$i]['name']}}</td>
            <td class="font-semibold rounded-lg border border-white">
              <span class="border-l-4 px-2 border-red-600">
                Ferrari
              </span>
            </td>
            <td class="font-semibold rounded-lg border border-white">{{$res[$i]['points']}}</td>
          </tr> 
        @endfor
      </tbody>
    </table>
  </div>
  
@endsection


        

     