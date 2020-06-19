@extends('layouts.app')
@section('content')

<div class="w-full">
  <form class="bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4">
    <label class="block text-gray-700 text-xl font-bold mb-2">
        League Sign Up
    </label>
    <div class="w-full px-5">
      <label class="inline-block text-gray-700 text-base font-bold mb-2">
        Select Season
      </label>
      <div class="inline-block relative">
        <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-bold text-basic border border-gray-500 py-1 pl-2 pr-6 ml-3 rounded leading-tight hover:border-blue-600 hover:bg-blue-100 focus:outline-none focus:bg-white focus:border-gray-500 active:bg-blue-700" id="season">
          <option>Season 1</option>
          <option>Season 2</option>
          <option>Season 3</option>
        </select>
        <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full max-w-xs mt-5">
    <label class="block text-gray-700 text-base font-bold mb-2">
        Driver Number
      </label>
    </div>
  </form>
</div>
<script>
  var season = document.getElementById("season").value;
  console.log(season);
</script>

@endsection