
@extends('layouts.app')
<style>
  td {
    padding-top: 1em
  }
</style>

@section('content')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.4/dist/flowbite.min.css" />
    
</head>
<tbody>
<div class="container flex w-screen">
    <div class="mx-auto p-4 border rounded-lg w-2/3  m-24"> 
    <div class="w-full flex my-4 justify-center">
      <a href="{{route('report.create')}}"><input type="button" class="bg-green-600 hover:bg-green-700 cursor-pointer font-semibold px-4 py-2 rounded text-white mx-auto my-6" value="Create New Report"></a>
    </div>
      
    
  
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg divide-gray-500">
        
        <table class="w-full text-md text-left text-black-500 dark:text-black-400 ">
            <thead class="font-semibold text-md text-black-700 uppercase bg-black-50 dark:bg-black-700 dark:text-black-400">
                
                    <td class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Report</td>
                    <td class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center" >Status</td>
                    <td class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center" style="width: 20%">Action</td>

                
            </thead>
            
        @for ($i =0 ; $i <count($reports) ; $i++) 
        
        <tr class="w-full font-semibold p-0 font-bold tracking-wide rounded-lg border border-white hover:underline cursor-pointer openDriver">
            <td>
                @if ($reports[$i]['reported_against']['id'] == $driver['id'] )
                    {{($i+1).".  Race  :  ".$reports[$i]['race']['circuit']['name']."   R".$reports[$i]['race']['circuit']['id']." |    Reporting: ".$reports[$i]['reported_against']['name']}}
                    
                @elseif ($reports[$i]['reporting_driver']['id'] == $driver['id'])
                    {{($i+1).".  Race  :  ".$reports[$i]['race']['circuit']['name']."   R".$reports[$i]['race']['circuit']['id']." |    Reported By: ".$reports[$i]['reporting_driver']['name']}}
                    
                @endif
                   
                
                
            </td>
            <td class="text-center">
                @if ($reports[$i]['resolved'] == 0)
                    Pending
                @elseif ($reports[$i]['resolved'] == 1)
                    Pending
                @elseif ($reports[$i]['resolved'] == 2)
                    Resolved
                @elseif ($reports[$i]['resolved'] == 3)
                    Published
                @endif
            </td>
            
            <td style="width: 20%" class="text-center">
                
                @if ($reports[$i]['resolved'] == 0 && $reports[$i]['reporting_driver']['id'] == $driver['id'])
                <button id="dropdownRightButton" data-dropdown-toggle="dropdownRight" data-dropdown-placement="right" class="mr-3 mb-3 md:mb-0 w-full text-white bg-purple-500 hover:bg-purple-600 focus:ring-4 focus:outline-none focus:purple-300 font-medium rounded text-md px-4 py-2.5 text-center inline-flex items-center dark:bg-purple-500 dark:hover:bg-purple-600 dark:focus:ring-purple-800" type="button">Select Action <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></button>

<!-- Dropdown menu -->
<div id="dropdownRight" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 text-center">
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRightButton">
      <li>
        <a href="{{route('report.create')}}" class="block px-4 py-2 hover:bg-purple-100 dark:hover:bg-purple-600 dark:hover:text-white">View</a>
      </li>
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-purple-100 dark:hover:bg-purple-600 dark:hover:text-white">Edit/Delete</a>
      </li>
      
      
    </ul>
</div>
                @else
                <button type="button" class="bg-purple-500 hover:bg-purple-600 cursor-pointer font-semibold px-4 py-2 rounded text-white mx-auto my-0 w-full">View</button>
                @endif
            </td>

            
            
             {{-- <td style="width:15%">
                 <div>
                <button type="button" class="bg-purple-500 hover:bg-purple-600 cursor-pointer font-semibold px-4 py-2 rounded text-white mx-auto my-0 w-full">View</button>
                
                @if ($reports[$i]['resolved'] == 0 && $reports[$i]['reporting_driver']['id'] == $driver['id']) 
                
                <button type="button" class="bg-blue-500 hover:bg-blue-600 cursor-pointer font-semibold px-4 py-2 rounded text-white mx-auto my-0 w-full">Edit/Delete</button>
                
                @endif
                
            </div>
              
            </td> --}}
          
        </tr>
        
        @endfor
            
            
    </div>    
                
            
        
    </table>

</div>
</tbody>
<script src="https://unpkg.com/flowbite@1.4.4/dist/flowbite.js"></script>
@endsection