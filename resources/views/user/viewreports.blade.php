@extends('layouts.app')
<style>
table {
width: 100%
}
th {
padding: 10px;
text-align: left;
}
td {
padding-left:10px;
}
</style>
@section('content')
<div class="container mx-auto px-4 md:p-0">
    <div class="md:w-2/3">
        <div class="bg-white p-4 rounded-lg border leading-none overflow-y-auto mb-4">
            <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4">
                All your Reports
            </div>
         <table class="w-full">
            <thead>
               <tr>
                    <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-8">SNo.</th>
                    <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Race</th>
                    <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Season</th>
                    <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/6">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($reports as $ie=>$value)
               <tr>
                    <td class="rounded-md border-2 border-white font-semibold">
                     <div class="py-2 text-center">
                        {{$ie + 1}}
                     </div>
                    </td>
                    <td class="rounded-md border-2 border-white font-semibold flex justify-between">
                        <div class="py-2 flex items-center flex-shrink-0 gap-4">
                            <div class="flex items-center flex-shrink-0">
                                <span class="hidden md:block">{{$value->race->circuit->name}}</span>
                            </div>
                        </div>
                        <div class="py-2 flex items-center flex-shrink-0 gap-4">
                            <div class="flex items-center flex-shrink-0">
                                <span class="hidden md:block">{{$value->race->season->name}}</span>
                            </div>
                        </div>
                    </td>
                  <td>
                  <div class="text-center">
                        <a href="{{route('report.view', ['report' => $value->id])}}" class="bg-gray-100 rounded text-gray-800 font-semibold p-2 hover:bg-indigo-100 hover:text-indigo-800"><i class="far fa-eye mr-2"></i>View</a>
                        <a href="{{route('report.edit', ['report' => $value->id])}}" class="bg-gray-100 rounded text-gray-800 font-semibold p-2 hover:bg-indigo-100 hover:text-indigo-800"><i class="far fa-eye mr-2"></i>Edit</a>
                    </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
    </div>
    </div>
</div>
<script>
   $( document ).ready(function() {
      $('.openDriver').click(function (e) {
         e.preventDefault();
         var linkId = $(this).attr('data-driverLink');
         window.open('/user/profile/view/'+linkId, '_blank');
      });
   });
</script>
@endsection
