@extends('layouts.app')
<style>
  td{
    padding:5px
  }
</style>
@section('content')
@auth
<h1 class="my-5 text-xl font-bold text-blue-700"> All Users </h1>
<table class="font-semibold">
  @foreach($user as $user)
  <tr>
    <td>
      <img src="{{$user->avatar}}" alt="" style="width:30px" class="rounded">
    </td>
    <td class="text-gray-800">
      {{$user->name}}
    </td>
    <td>
      <a href="/home/admin/user/{{$user->id}}" class="bg-blue-100 rounded py-2 px-4 text-blue-800 cursor-pointer hover:text-blue-900 hover:bg-blue-200 ">View Details</a>
    </td>
    <td>
      <a href="/home/admin/user-allot/{{$user->id}}" class="bg-yellow-100 rounded py-2 px-4 text-yellow-800 cursor-pointer hover:text-yellow-900 hover:bg-yellow-200 ">Allot Driver</a> 
    </td>
  </tr>
  @endforeach
          
</table>
</div>
@endauth     
@endsection

