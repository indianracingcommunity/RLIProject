@extends('layouts.app')
@section('content')
<style>
  input[type="radio"] + label span {
    transition: background .2s,
    transform .2s;
  }

  input[type="radio"] + label span:hover,
  input[type="radio"] + label:hover span{
    transform: scale(1.2);
  } 

  input[type="radio"]:checked + label span {
    background-color: #4c51bf; 
    box-shadow: 0px 0px 0px 2px white inset;
  }

  input[type="radio"]:checked + label{
    color: #4c51bf; 
  }
</style>
<div class="w-full">
  <form class="bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4" method="POST" action="/testform" enctype="multipart/form-data" onsubmit="return validate()">
    @csrf
    <div id="restform">
      <label class="block text-gray-700 text-xl font-bold mb-2">
        League Sign Up
      </label>
      
   
      <div class="w-full pl-3 ml-20 mt-5">
        <label class="inline-block text-gray-700 text-base font-bold mb-2">
          Select Season
        </label>
        <div class="inline-block relative">
          <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="seasonnum" name="seas">
            <option>Season 1</option>
            <option>Season 2</option>
            <option>Season 3</option>
            <option>Season 4</option>
            <option>Season 5</option>
          </select>
          <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
          </div>
        </div>
        <label class="inline-block w-72 text-gray-700 text-base font-bold mb-2 mt-5 ml-64">Will you be able to attend 75% of races?</label>
        <div class="inline-block">
          <div class="inline-flex items-center mr-4 ml-4">
            <input id="radio3" type="radio" name="attendance" class="hidden" value="YES"/>
            <label for="radio3" class="flex items-center cursor-pointer">
            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
            YES</label>
          </div>

          <div class="inline-flex items-center mr-10 pr-2">
            <input id="radio4" type="radio" name="attendance" class="hidden" value="NO" checked/>
            <label for="radio4" class="flex items-center cursor-pointer">
            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
            NO</label>
          </div>
        </div>
      </div>
      <div class="block w-full text-red-600 text-sm italic mt-2 pl-48 ml-4" id="errorseason">
        <br><br>
      </div>

      <div class="w-full mt-3">
        <label class="inline-block text-gray-700 text-base font-bold ml-20">
          Driver Number
        </label>
        <div class="inline-block pl-3">
          <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-20 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="drivernum" type="number" name="drivernumber">
        </div>

        <label class="inline-block text-gray-700 text-base font-bold ml-64 pl-5">
          Speed test result link
        </label>
        <div class="inline-block pl-3">
          <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-64 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="speedlinkid" type="link" name="speedtest">
        </div>
      </div>

      <div class="text-red-600 text-sm italic mt-2 pl-48 ml-4">
        <div class="inline-block w-1/3" id="errordrivernum">
        <br><br>
        </div>
        <div class="inline-block w-5/12 ml-16 pl-2" id="errorspeed">
          Enter the link of your speed test performed at "https://www.speedtest.net/"<br> Ensure that the server is set to Bangalore/Mumbai
        </div>
      </div>
      
      <div class="bg-purple-700 w-full h-px mt-2 rounded shadow-2xl">
      </div>
      
      <div class="w-full mt-5">
        <label class="inline-block text-gray-700 text-base font-bold ml-10">
          Time Trial Time 1
        </label>
        <div class="inline-block pl-3">
          <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="time1" type="text" name="t1">
        </div>
        <div class="inline-block appearance-none bg-grey-lighter">
          <label class="inline-block text-gray-700 text-base font-bold ml-64 mr-3">
            Evidence
          </label>
          <div class="inline-block" >
            <label class="w-auto inline-block items-center px-4 py-0 bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt1">
                <svg class="inline-block w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="inline-block mt-2 text-base leading-normal">Upload</span>
                <input type='file' name="evidencet1" accept=".png, .jpg, .jpeg" class="hidden" id="imgt1" onchange="javascript:updatelist1()"/>
            </label>
          </div>
        </div>
        <label class="inline-block text-gray-700 text-sm font-bold ml-3" id="filenamet1"></label>
      </div>

      <div class="block w-auto text-red-600 text-sm italic mt-2 pl-48 ml-4">
        <div class="inline-block w-1/3" id="errort1">
          <br><br>
        </div> 
        <div class="inline-block w-5/12 pl-2" id="errorimgt1">
          <br><br>
        </div> 
      </div>

      <div class="inline-block w-auto">
        <div class="inline-block mt-5">
          <label class="inline-block text-gray-700 text-base font-bold ml-10">
            Time Trial Time 2
          </label>
          <div class="inline-block pl-3">
            <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="time2" type="text" name="t2">
          </div>
        </div>
        
        <div class="inline-block appearance-none bg-grey-lighter">
          <label class="inline-block text-gray-700 text-base font-bold ml-64 mr-3">
            Evidence
          </label>
          
          <div class="inline-block" >
            <label class="w-auto inline-block items-center px-4 py-0 bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt2">
                <svg class="inline-block w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="inline-block mt-2 text-base leading-normal">Upload</span>
                <input type='file' name="evidencet2" accept=".png, .jpg, .jpeg" class="hidden" id="imgt2" onchange="javascript:updatelist2()"/>
            </label>
          </div>
        </div>
        <label class="inline-block text-gray-700 text-sm font-bold ml-3" id="filenamet2"></label>
      </div>

      <div class="block w-auto text-red-600 text-sm italic mt-2 pl-48 ml-4">
        <div class="inline-block w-1/3" id="errort2">
          <br><br>
        </div> 
        <div class="inline-block w-5/12 pl-2" id="errorimgt2">
          <br><br>
        </div> 
      </div>

      <div class="w-full mt-5">
        <label class="inline-block text-gray-700 text-base font-bold ml-10">
          Time Trial Time 3
        </label>
        <div class="inline-block pl-3">
          <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="time3" type="text" name="t3">
        </div>

        <div class="inline-block appearance-none bg-grey-lighter">
          <label class="inline-block text-gray-700 text-base font-bold ml-64 mr-3">
            Evidence
          </label>
          <div class="inline-block" >
            <label class="w-auto inline-block items-center px-4 py-0 bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt3">
                <svg class="inline-block w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="inline-block mt-2 text-base leading-normal">Upload</span>
                <input type='file' name="evidencet3" accept=".png, .jpg, .jpeg" class="hidden" id="imgt3" onchange="javascript:updatelist3()"/>
            </label>
          </div>
        </div>
        <label class="inline-block text-gray-700 text-sm font-bold ml-3" id="filenamet3"></label> 
      </div>

      <div class="block w-auto text-red-600 text-sm italic mt-2 pl-48 ml-4">
        <div class="inline-block w-1/3" id="errort3">
          <br><br>
        </div> 
        <div class="inline-block w-5/12 pl-2" id="errorimgt3">
          <br><br>
        </div> 
      </div>
      
      <div class="flex justify-between mt-5 mr-20">
        <div class="inline-block pl-3 ml-5">
          <label class="inline-block text-gray-700 text-base font-bold mb-2">
            Team preference 1
          </label>
          <div class="inline-block relative">
            <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="preference1" name="pref1">
              <option>Mercedes</option>
              <option>Haas</option>
              <option>McLaren</option>
              <option>Alfa Romeo</option>
              <option>Red Bull</option>
              <option>Renault</option>
              <option>Ferrari</option>
              <option>AlphaTauri</option>
              <option>Williams</option>
              <option>Racing Point</option>
            </select>
            <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        </div>

        <div class="inline-block pl-3 ml-10">
          <label class="inline-block text-gray-700 text-base font-bold mb-2">
            Team preference 2
          </label>
          <div class="inline-block relative">
            <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="preference2" name="pref2">
              <option>Mercedes</option>
              <option>Haas</option>
              <option>McLaren</option>
              <option>Alfa Romeo</option>
              <option>Red Bull</option>
              <option>Renault</option>
              <option>Ferrari</option>
              <option>AlphaTauri</option>
              <option>Williams</option>
              <option>Racing Point</option>
            </select>
            <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        </div>

        <div class="inline-block pl-3 ml-10">
          <label class="inline-block text-gray-700 text-base font-bold mb-2">
            Team preference 3
          </label>
          <div class="inline-block relative">
            <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="preference3" name="pref3">
              <option>Mercedes</option>
              <option>Haas</option>
              <option>McLaren</option>
              <option>Alfa Romeo</option>
              <option>Red Bull</option>
              <option>Renault</option>
              <option>Ferrari</option>
              <option>AlphaTauri</option>
              <option>Williams</option>
              <option>Racing Point</option>
            </select>
            <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        </div>
      </div>
      
      <div class="block w-full text-red-600 text-sm italic mt-2 text-center ml-4" id="errorteam">
        <br><br>
      </div>

      
      <div class="flex w-full mt-5 content-center items-center justify-center">
        <button class="bg-purple-500 hover:bg-purple-600 text-white font-bold shadow-lg py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Submit
        </button>
      </div>
    </div>
  </form>
  <script>
    updatelist1 = function(){
      document.getElementById("filenamet1").innerHTML = document.getElementById("imgt1").files[0].name;
    }
    updatelist2 = function(){
      document.getElementById("filenamet2").innerHTML = document.getElementById("imgt2").files[0].name;
    }
    updatelist3 = function(){
      document.getElementById("filenamet3").innerHTML = document.getElementById("imgt3").files[0].name;
    }
    function formyesFunction(){
      document.getElementById("restform").style.display = "block"
      document.getElementById("errorgameavail").innerHTML = "<br>"
    }
    function formnoFunction(){
      document.getElementById("restform").style.display = "none"
      document.getElementById("errorgameavail").innerHTML = "Unless you are planning to borrow your friend's game, <br> feel free to browse for other content!"
    }
    function validate(){
      var sendform = true;
      var t1 = document.getElementById("time1").value;
      var t2 = document.getElementById("time2").value;
      var t3 = document.getElementById("time3").value;
      var seas = document.getElementById("seasonnum").value;
      var driverno = document.getElementById("drivernum").value;
      var preference1 = document.getElementById("preference1").value;
      var preference2 = document.getElementById("preference2").value;
      var preference3 = document.getElementById("preference3").value;
      var imaget2 = document.getElementById("imgt2").value;
      var imaget1 = document.getElementById("imgt1").value;
      var imaget3 = document.getElementById("imgt3").value;
      var speedlink = document.getElementById("speedlinkid").value;
      
      if (t1 == ""){
        document.getElementById("errort1").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
        document.getElementById("time1").style.borderColor = "#f56565";
        sendform = false;
      }
      else if ((t1.length != 8) || ((t1.charAt(1).localeCompare(':')) == 1) || ((t1.charAt(4).localeCompare('.')) == 1)){
        document.getElementById("errort1").innerHTML = "Let's follow F1 format mate! <br> Time format should be 1:06.006";
        document.getElementById("time1").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errort1").innerHTML = "<br><br>";
        document.getElementById("time1").style = "";
      }

      if (t2 == ""){
        document.getElementById("errort2").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
        document.getElementById("time2").style.borderColor = "#f56565";
        sendform = false;
      }
      else if ((t2.length != 8) || ((t2.charAt(1).localeCompare(':')) == 1) || ((t2.charAt(4).localeCompare('.')) == 1)){
        document.getElementById("errort2").innerHTML = "Let's follow F1 format mate! <br> Time format should be 1:06.006";
        document.getElementById("time2").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errort2").innerHTML = "<br><br>";
        document.getElementById("time2").style = "";
      }
      
      if (t3 == ""){
        document.getElementById("errort3").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
        document.getElementById("time3").style.borderColor = "#f56565";
        sendform = false;
      }
      else if ((t3.length != 8) || ((t3.charAt(1).localeCompare(':')) == 1) || ((t3.charAt(4).localeCompare('.')) == 1)){
        document.getElementById("errort3").innerHTML = "Let's follow F1 format mate! <br> Time format should be 1:06.006";
        document.getElementById("time3").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errort3").innerHTML = "<br><br>";
        document.getElementById("time3").style = "";
      }
      

      if (imaget1 == ""){
        document.getElementById("errorimgt1").innerHTML = "FBI needs your image for verification! <br> Mandatory Field";
        document.getElementById("imgdivt1").style.borderColor = "#f56565";
        sendform = false; 
      }
      else if(document.getElementById("imgt1").files[0].type != "image/png" && document.getElementById("imgt1").files[0].type != "image/jpg" && document.getElementById("imgt1").files[0].type != "image/jpeg"){
        document.getElementById("errorimgt1").innerHTML = "Sorry our PC won't be able to open that! <br> Format should be .jpg, .jpeg or .png";
        document.getElementById("imgdivt1").style.borderColor = "#f56565";
        sendform = false; 
      }
      else if(document.getElementById("imgt1").files[0].size > 3000000){
        document.getElementById("errorimgt1").innerHTML = "You may have a lot of high quality pics of stuff :P <br> Please limit file sizes to 3MB";
        document.getElementById("imgdivt1").style.borderColor = "#f56565";
        sendform = false; 
      }
      else{
        document.getElementById("errorimgt1").innerHTML = "<br><br>";
        document.getElementById("imgdivt1").style = "";
      }

      if (imaget2 == ""){
        document.getElementById("errorimgt2").innerHTML = "FBI needs your image for verification! <br> Mandatory Field";
        document.getElementById("imgdivt2").style.borderColor = "#f56565";
        sendform = false; 
      }
      else if(document.getElementById("imgt2").files[0].type != "image/png" && document.getElementById("imgt2").files[0].type != "image/jpg" && document.getElementById("imgt2").files[0].type != "image/jpeg"){
        document.getElementById("errorimgt2").innerHTML = "Sorry our PC won't be able to open that! <br> Format should be .jpg, .jpeg or .png";
        document.getElementById("imgdivt2").style.borderColor = "#f56565";
        sendform = false; 
      }
      else if(document.getElementById("imgt2").files[0].size > 3000000){
        document.getElementById("errorimgt2").innerHTML = "You may have a lot of high quality pics of stuff :P <br> Please limit file sizes to 3MB";
        document.getElementById("imgdivt2").style.borderColor = "#f56565";
        sendform = false; 
      }
      else{
        document.getElementById("errorimgt2").innerHTML = "<br><br>";
        document.getElementById("imgdivt2").style = "";
      }
      
      if (imaget3 == ""){
        document.getElementById("errorimgt3").innerHTML = "FBI needs your image for verification! <br> Mandatory Field";
        document.getElementById("imgdivt3").style.borderColor = "#f56565";
        sendform = false; 
      }
      else if(document.getElementById("imgt3").files[0].type != "image/png" && document.getElementById("imgt3").files[0].type != "image/jpg" && document.getElementById("imgt3").files[0].type != "image/jpeg"){
        document.getElementById("errorimgt3").innerHTML = "Sorry our PC won't be able to open that! <br> Format should be .jpg, .jpeg or .png";
        document.getElementById("imgdivt3").style.borderColor = "#f56565";
        sendform = false; 
      }
      else if(document.getElementById("imgt3").files[0].size > 3000000){
        document.getElementById("errorimgt3").innerHTML = "You may have a lot of high quality pics of stuff :P <br> Please limit file sizes to 3MB";
        document.getElementById("imgdivt3").style.borderColor = "#f56565";
        sendform = false; 
      }
      else{
        document.getElementById("errorimgt3").innerHTML = "<br><br>";
        document.getElementById("imgdivt3").style = "";
      }


      if (seas.charAt(7) < 5){
        document.getElementById("errorseason").innerHTML = "It is fun to go in the past but we dont have time machine! <br> Select Season 5 or later";
        document.getElementById("seasonnum").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errorseason").innerHTML = "<br><br>";
        document.getElementById("seasonnum").style = "";
      }

      if (driverno == ""){
        document.getElementById("errordrivernum").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
        document.getElementById("drivernum").style.borderColor = "#f56565";
        sendform = false;
      }
      else if (driverno < 1  || driverno > 99){
        document.getElementById("errordrivernum").innerHTML = "Expecting too much from Codemasters <br> Enter driver number between 1 and 99";
        document.getElementById("drivernum").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errordrivernum").innerHTML = "<br><br>";
        document.getElementById("drivernum").style = "";
      }
      
      if (speedlink == ""){
        document.getElementById("errorspeed").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
        document.getElementById("speedlinkid").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errorspeed").innerHTML = "<br><br>";
        document.getElementById("speedlinkid").style = "";
      }

      if (preference1.localeCompare(preference2) == 0 || preference1.localeCompare(preference3) == 0 || preference2.localeCompare(preference3) == 0){
        document.getElementById("errorteam").innerHTML = "We know you love your supporting team but sometimes world is not fair! <br> Enter different preference 1, preference 2 and preference 3";
        document.getElementById("preference1").style.borderColor = "#f56565";
        document.getElementById("preference2").style.borderColor = "#f56565";
        document.getElementById("preference3").style.borderColor = "#f56565";
        sendform = false;
      }
      else{
        document.getElementById("errorteam").innerHTML = "<br><br>";
        document.getElementById("preference1").style = "";
        document.getElementById("preference2").style = "";
        document.getElementById("preference3").style = "";
      }

      return sendform;
    }
  </script>
</div>

@endsection