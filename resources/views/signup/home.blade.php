<script src="/php-unserialize.js"></script>
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
    font-weight: 700;
    color: #4c51bf; 
  }

  input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    background-color: #fff;
    margin: 0;
    font: inherit;
    color: currentColor;
    width: 1rem;
    height: 1rem;
    border: 0.125rem solid currentColor;
    border-radius: 0.2rem;

    display: grid;
    place-content: center;
  }

  input[type="checkbox"]::before {
    content: "";
    width: 0.5rem;
    height: 0.5rem;
    transform: scale(0);
    transition: 120ms transform ease-in-out;
    box-shadow: inset 1rem 1rem blue;
    border-radius: 0.1rem;
    background-color: CanvasText;
  }

  input[type="checkbox"]:checked::before {
    transform: scale(1);
  }

</style>

<div class="flex flex-col items-center justify-center gap-8 xl:gap-6 p-5 md:px-16 xl:px-24">
  <div class="flex flex-col items-center justify-center gap-1 text-sm text-blue-800 bg-blue-200 p-3 w-full rounded-md profileAlert">
    <p id="headingText" class="text-xl font-bold">Welcome to League Sign Ups!</p>

    <div class="flex flex-row items-start justify-center gap-2 mx-4 break-words">
      <i class="fa fa-exclamation-circle my-1" aria-hidden="true"></i>
      <p id="supportText">Your entries are editable until sign ups close or <i>Thanos snaps his fingers</i>.</p>
    </div>
  </div>

  <form id="formid" class="w-full" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
    @csrf
    <div id="restform">
      <input type="hidden" name="statusCheck" id='statusCheck' /> 
      
      <div class="flex flex-col items-center justify-center px-8 md:px-10 py-2 rounded-md border gap-6 w-full">
        <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
          <i class="far fa-user-circle"></i>
          Signup details
        </div>

        <div class="flex flex-col items-center justify-center gap-12 lg:gap-16 xl:gap-20 w-full">
          <div class="flex flex-col gap-12">
            <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center gap-12 xl:gap-32 lg:ml-6 xl:ml-2 w-full">
              <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center lg:justify-start gap-1 lg:gap-3 w-full lg:w-1/3 xl:w-2/5">
                <label class="font-semibold text-gray-800">
                  Select season:
                </label>
    
                <div class="flex flex-col items-start justify-center gap-1 w-full lg:w-1/2 xl:w-40">
                  <select id="seasonnum" name="seas" onchange="javascript:updateconstructor()" class="bg-gray-200 w-full px-2 py-1 font-semibold leading-tight border shadow-inner border-gray-500 rounded-md cursor-pointer hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 text-center">
                    @foreach ($seasons as $value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
    
                  <div class="hidden text-red-600 text-sm italic text-sm px-1 break-words" id="errorseason">
                    It is fun to go in the past but we dont have a time machine! Select season 5 or later.
                  </div>
                </div>
              </div>
      
              <div class="flex flex-col lg:flex-row items-center justify-center lg:justify-start gap-3 lg:w-2/3">
                <label class="font-semibold text-gray-800 text-center">
                  Will you be able to attend atleast 75% of races?
                </label>
      
                <div class="flex flex-row items-center justify-center gap-8 lg:gap-4">
                  <div class="flex flex-row items-center justify-center gap-1">
                    <input id="radio3" type="radio" name="attendance" class="hidden cursor-pointer" value="YES"/>
                    
                    <label for="radio3" class="flex items-center font-medium tracking-wider cursor-pointer">
                      <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                      Yes
                    </label>
                  </div>
    
                  <div class="flex flex-row items-center justify-center gap-1">
                    <input id="radio4" type="radio" name="attendance" class="hidden cursor-pointer" value="NO" checked/>
    
                    <label for="radio4" class="flex items-center font-medium tracking-wider cursor-pointer">
                      <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                      No
                    </label>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center gap-12 xl:gap-32 lg:ml-6 xl:ml-2 w-full">
              <div class="flex flex-col items-center justify-center gap-1 w-full lg:w-1/3 xl:w-2/5">
                <div class="flex flex-row items-center lg:items-start justify-center lg:justify-start gap-3 w-full">
                  <label class="font-semibold text-gray-800">
                    Enter driver number:
                  </label>
    
                  <input class="appearance-none border shadow-inner border-gray-500 rounded-md w-20 py-1 px-2 text-gray-700 leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500 text-center" id="drivernum" type="number" name="drivernumber">
                </div>
    
                <div class="hidden text-red-600 text-sm italic text-sm px-5 lg:px-0 break-words" id="errordrivernum">
                  Well can't escape without filling this mandatory field!
                </div>
              </div>
    
              <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center lg:justify-start gap-1 lg:gap-3 w-full lg:w-2/3">
                <label class="font-semibold text-gray-800 lg:w-auto xl:w-2/3">
                  Internet speed test link:
                </label>
    
                <div class="flex flex-col items-start justify-center gap-1 w-full lg:w-1/2 xl:w-full">
                  <input class="w-full text-center appearance-none border shadow-inner border-gray-500 rounded-md w-20 py-1 px-2 text-gray-700 leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="speedlinkid" type="link" name="speedtest" placeholder="https://www.speedtest.net/result/">
    
                  <div class="hidden text-blue-600 text-sm italic text-sm px-1 break-words" id="errorspeed">
                    Ensure you perform the speed test on one of the popular platforms. The server should be set to Bangalore/Mumbai.
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="flex flex-col items-center justify-center gap-3 lg:gap-4 xl:gap-6 w-full">
            <!-- <label class="font-semibold text-gray-800">
              Select your assists
            </label> -->

            <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
              <i class="fa fa-cog"></i>
              assist preferences
            </div>

            <div class="grid md:grid-cols-2 navXl:flex navXl:flex-row navXl:items-center navXl:justify-center gap-3 w-full">
              <label class="flex flex-row items-center justify-start gap-3 px-5 md:px-8 py-1 rounded-md bg-gray-200 cursor-pointer">
                <input class="cursor-pointer" id="assist1" type="checkbox" name="assists[]" value="traction">
                <span>Traction control</span>
              </label>

              <label class="flex flex-row items-center justify-start gap-3 px-5 md:px-8 py-1 rounded-md bg-gray-200 cursor-pointer">
                <input class="cursor-pointer" id="assist2" type="checkbox" name="assists[]" value="abs">
                <span>Anti-lock brakes (ABS)</span>
              </label>

              <label class="flex flex-row items-center justify-start gap-3 px-5 md:px-8 py-1 rounded-md bg-gray-200 cursor-pointer">
                <input class="cursor-pointer" id="assist3" type="checkbox" name="assists[]" value="line">
                <span>Racing line</span>
              </label>

              <label class="flex flex-row items-center justify-start gap-3 px-5 md:px-8 py-1 rounded-md bg-gray-200 cursor-pointer">
                <input class="cursor-pointer" id="assist4" type="checkbox" name="assists[]" value="autogears">
                <span>Automatic gears</span>
              </label>
            </div>
          </div>

          <div class="flex flex-col items-center justify-center gap-3 lg:gap-4 xl:gap-6 w-full" id="preferenceid">
            <!-- <label class="font-semibold text-gray-800 text-center">
              Choose your team preferences
            </label> -->

            <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
              <i class="fa fa-users"></i>
              team preferences
            </div>
            
            <div class="flex flex-col lg:flex-row items-center justify-center gap-5 lg:gap-10 xl:gap-16 w-full">
              <div class="flex flex-col items-center justify-center gap-1 w-full">
                <label class="font-semibold text-gray-600">
                  Preference 1
                </label>
      
                <select class="bg-gray-200 w-full px-2 py-1 font-semibold leading-tight border shadow-inner border-gray-500 rounded-md cursor-pointer hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 text-center" id="preference1" name="pref1">
                </select>
              </div>

              <div class="flex flex-col items-center justify-center gap-1 w-full">
                <label class="font-semibold text-gray-600">
                  Preference 2
                </label>
      
                <select class="bg-gray-200 w-full px-2 py-1 leading-tight border shadow-inner border-gray-500 rounded-md cursor-pointer hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 text-center" id="preference2" name="pref2">
                </select>
              </div>

              <div class="flex flex-col items-center justify-center gap-1 w-full">
                <label class="font-semibold text-gray-600">
                  Preference 3
                </label>
      
                <select class="bg-gray-200 w-full px-2 py-1 leading-tight border shadow-inner border-gray-500 rounded-md cursor-pointer hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 text-center" id="preference3" name="pref3">
                </select>
              </div>
            </div>

            <div class="hidden text-red-600 text-sm italic text-sm px-1 break-words" id="errorteam">
              We know you love supporting your team but the world is not fair! Choose a different preference 1, 2 or 3.
            </div>
          </div>

          <div class="flex flex-col items-center justify-center gap-3 lg:gap-4 xl:gap-6 w-full ttSection">
            <!-- <label class="font-semibold text-gray-800 text-center">
              Enter your time trial times
            </label> -->

            <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
              <i class="fas fa-stopwatch"></i>
              time trial data
            </div>

            <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center gap-8 lg:gap-4 w-full">
              <div class="flex flex-col items-center justify-center gap-2 w-full">
                <div class="flex flex-col item-center justify-center">    
                  <label class="font-semibold text-center capitalize" id="pref1id"></label>
                </div>
                
                <div class="flex flex-col items-center justify-center gap-1 w-full">
                  <!-- <div class="flex flex-row items-center justify-center w-full">
                    <label class="w-2/5 font-semibold text-gray-600 text-center">
                      Track #1:
                    </label>
  
                  </div> -->
                  <input class="w-2/3 md:w-3/5 lg:w-2/3 appearance-none border shadow-inner border-gray-500 rounded-md py-1 px-2 text-gray-700 leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500 text-center" id="time1" type="text" name="t1" placeholder="1:06.006">

                  <div class="hidden text-red-600 text-sm italic text-sm px-5 break-words" id="errort1">
                    Well, you can't escape without filling this mandatory field!
                  </div>
                </div>
                
                <div id="uploadWrapper1" class="flex flex-row items-center justify-center pt-1 gap-2 w-full">
                  <label id="uploadLabel1" class="w-2/3 flex flex-row items-center justify-center gap-2 py-1 appearance-none border shadow-inner cursor-pointer border-gray-500 rounded-md text-purple-700 leading-tight hover:border-purple-100 hover:bg-purple-700 hover:text-white focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt1">
                    <svg class="inline-block w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>

                    <span class="font-semibold text-sm text-center">Upload #1</span>

                    <input type='file' name="evidencet1" accept=".png, .jpg, .jpeg" class="hidden" id="imgt1" onchange="javascript:updatelist1()"/>
                  </label>
                  
                  <div id="ttevidenceid1" class="hidden cursor-pointer">
                    <a id="imglink1" target="_blank" class="flex w-full">
                      <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve" fill="currentColor" class="px-2 h-8 appearance-none border shadow-inner border-gray-500 rounded-md text-purple-700 leading-tight hover:border-purple-100 hover:bg-purple-700 hover:text-white focus:outline-none focus:bg-white focus:border-purple-500">

                        <path d="M426.667,68.267H51.2c-28.277,0-51.2,22.923-51.2,51.2V358.4c0,28.277,22.923,51.2,51.2,51.2h375.467
                          c28.277,0,51.2-22.923,51.2-51.2V119.467C477.867,91.19,454.944,68.267,426.667,68.267z M443.733,358.4
                          c0,9.426-7.641,17.067-17.067,17.067H51.2c-9.426,0-17.067-7.641-17.067-17.067v-10.001l68.267-68.267l56.201,56.201
                          c6.664,6.663,17.468,6.663,24.132,0l141.534-141.534l119.467,119.467V358.4z M443.733,266.001L336.333,158.601
                          c-6.664-6.663-17.468-6.663-24.132,0L170.667,300.134l-56.201-56.201c-6.664-6.663-17.468-6.663-24.132,0l-56.201,56.201V119.467
                          c0-9.426,7.641-17.067,17.067-17.067h375.467c9.426,0,17.067,7.641,17.067,17.067V266.001z"/>

                        <path d="M153.6,136.533c-28.277,0-51.2,22.923-51.2,51.2c0,28.277,22.923,51.2,51.2,51.2s51.2-22.923,51.2-51.2
                          C204.8,159.456,181.877,136.533,153.6,136.533z M153.6,204.8c-9.426,0-17.067-7.641-17.067-17.067
                          c0-9.426,7.641-17.067,17.067-17.067s17.067,7.641,17.067,17.067C170.667,197.159,163.026,204.8,153.6,204.8z"/>
                      </svg>
                    </a>
                  </div>  
                </div>
                
                <label class="hidden text-blue-600 text-sm font-semibold break-words px-1" id="filenamet1"></label>
                
                <div class="hidden text-red-600 text-sm italic text-sm px-5 break-words" id="errorimgt1">
                  FBI needs your image for verification! This is a mandatory Field.
                </div>
              </div>
              
              <div class="flex flex-col items-center justify-center gap-2 w-full">
                <div class="flex flex-col item-center justify-center">
                  <label class="font-semibold text-center capitalize" id="pref2id"></label>
                </div>
                
                <div class="flex flex-col items-center justify-center gap-1 w-full">
                  <!-- <div class="flex flex-row items-center justify-center w-full">
                    <label class="w-2/5 font-semibold text-gray-600 text-center">
                      Track #2:
                    </label>
                    
                  </div> -->

                  <input class="w-2/3 md:w-3/5 lg:w-2/3 appearance-none border shadow-inner border-gray-500 rounded-md py-1 px-2 text-gray-700 leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500 text-center" id="time2" type="text" name="t2" placeholder="1:06.006">

                  <div class="hidden text-red-600 text-sm italic text-sm px-5 break-words" id="errort2">
                    Well, you can't escape without filling this mandatory field!
                  </div>
                </div>
                
                <div id="uploadWrapper2" class="flex flex-row items-center justify-center pt-1 gap-2 w-full">
                  <label id="uploadLabel2" class="w-2/3 flex flex-row items-center justify-center gap-2 py-1 appearance-none border shadow-inner cursor-pointer border-gray-500 rounded-md text-purple-700 leading-tight hover:border-purple-100 hover:bg-purple-700 hover:text-white focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt2">
                    <svg class="inline-block w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>

                    <span class="font-semibold text-sm text-center">Upload #2</span>

                    <input type='file' name="evidencet2" accept=".png, .jpg, .jpeg" class="hidden" id="imgt2" onchange="javascript:updatelist2()"/>
                  </label>
                  
                  <div id="ttevidenceid2" class="hidden cursor-pointer">
                    <a id="imglink2" target="_blank" class="flex w-full">
                      <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve" fill="currentColor" class="px-2 h-8 appearance-none border shadow-inner border-gray-500 rounded-md text-purple-700 leading-tight hover:border-purple-100 hover:bg-purple-700 hover:text-white focus:outline-none focus:bg-white focus:border-purple-500">

                        <path d="M426.667,68.267H51.2c-28.277,0-51.2,22.923-51.2,51.2V358.4c0,28.277,22.923,51.2,51.2,51.2h375.467
                          c28.277,0,51.2-22.923,51.2-51.2V119.467C477.867,91.19,454.944,68.267,426.667,68.267z M443.733,358.4
                          c0,9.426-7.641,17.067-17.067,17.067H51.2c-9.426,0-17.067-7.641-17.067-17.067v-10.001l68.267-68.267l56.201,56.201
                          c6.664,6.663,17.468,6.663,24.132,0l141.534-141.534l119.467,119.467V358.4z M443.733,266.001L336.333,158.601
                          c-6.664-6.663-17.468-6.663-24.132,0L170.667,300.134l-56.201-56.201c-6.664-6.663-17.468-6.663-24.132,0l-56.201,56.201V119.467
                          c0-9.426,7.641-17.067,17.067-17.067h375.467c9.426,0,17.067,7.641,17.067,17.067V266.001z"/>

                        <path d="M153.6,136.533c-28.277,0-51.2,22.923-51.2,51.2c0,28.277,22.923,51.2,51.2,51.2s51.2-22.923,51.2-51.2
                          C204.8,159.456,181.877,136.533,153.6,136.533z M153.6,204.8c-9.426,0-17.067-7.641-17.067-17.067
                          c0-9.426,7.641-17.067,17.067-17.067s17.067,7.641,17.067,17.067C170.667,197.159,163.026,204.8,153.6,204.8z"/>
                      </svg>
                    </a>
                  </div>
                </div>

                <label class="hidden text-blue-600 text-sm font-semibold break-words px-1" id="filenamet2"></label>

                <div class="hidden text-red-600 text-sm italic text-sm px-5 break-words" id="errorimgt2">
                  FBI needs your image for verification! This is a mandatory Field.
                </div>
              </div>

              <div class="flex flex-col items-center justify-center gap-2 w-full">
                <div class="flex flex-col item-center justify-center">
                  <label class="font-semibold text-center capitalize" id="pref3id"></label>
                </div>
                
                <div class="flex flex-col items-center justify-center gap-1 w-full">
                  <!-- <div class="flex flex-row items-center justify-center w-full">
                    <label class="w-2/5 font-semibold text-gray-600 text-center">
                      Track #3:
                    </label>
                    
                  </div> -->
                  <input class="w-2/3 md:w-3/5 lg:w-2/3 appearance-none border shadow-inner border-gray-500 rounded-md py-1 px-2 text-gray-700 leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500 text-center" id="time3" type="text" name="t3" placeholder="1:06.006">

                  <div class="hidden text-red-600 text-sm italic text-sm px-5 break-words" id="errort3">
                    Well, you can't escape without filling this mandatory field!
                  </div>
                </div>
                
                <div id="uploadWrapper3" class="flex flex-row items-center justify-center pt-1 gap-2 w-full">
                  <label id="uploadLabel3" class="w-2/3 flex flex-row items-center justify-center gap-2 py-1 appearance-none border shadow-inner cursor-pointer border-gray-500 rounded-md text-purple-700 leading-tight hover:border-purple-100 hover:bg-purple-700 hover:text-white focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt3">
                    <svg class="inline-block w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>

                    <span class="font-semibold text-sm text-center">Upload #3</span>

                    <input type='file' name="evidencet3" accept=".png, .jpg, .jpeg" class="hidden" id="imgt3" onchange="javascript:updatelist3()"/>
                  </label>
                  
                  <div id="ttevidenceid3" class="hidden cursor-pointer">
                    <a id="imglink3" target="_blank" class="flex w-full">
                      <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve" fill="currentColor" class="px-2 h-8 appearance-none border shadow-inner border-gray-500 rounded-md text-purple-700 leading-tight hover:border-purple-100 hover:bg-purple-700 hover:text-white focus:outline-none focus:bg-white focus:border-purple-500">

                        <path d="M426.667,68.267H51.2c-28.277,0-51.2,22.923-51.2,51.2V358.4c0,28.277,22.923,51.2,51.2,51.2h375.467
                          c28.277,0,51.2-22.923,51.2-51.2V119.467C477.867,91.19,454.944,68.267,426.667,68.267z M443.733,358.4
                          c0,9.426-7.641,17.067-17.067,17.067H51.2c-9.426,0-17.067-7.641-17.067-17.067v-10.001l68.267-68.267l56.201,56.201
                          c6.664,6.663,17.468,6.663,24.132,0l141.534-141.534l119.467,119.467V358.4z M443.733,266.001L336.333,158.601
                          c-6.664-6.663-17.468-6.663-24.132,0L170.667,300.134l-56.201-56.201c-6.664-6.663-17.468-6.663-24.132,0l-56.201,56.201V119.467
                          c0-9.426,7.641-17.067,17.067-17.067h375.467c9.426,0,17.067,7.641,17.067,17.067V266.001z"/>

                        <path d="M153.6,136.533c-28.277,0-51.2,22.923-51.2,51.2c0,28.277,22.923,51.2,51.2,51.2s51.2-22.923,51.2-51.2
                          C204.8,159.456,181.877,136.533,153.6,136.533z M153.6,204.8c-9.426,0-17.067-7.641-17.067-17.067
                          c0-9.426,7.641-17.067,17.067-17.067s17.067,7.641,17.067,17.067C170.667,197.159,163.026,204.8,153.6,204.8z"/>
                      </svg>
                    </a>
                  </div>
                </div>

                <label class="hidden text-blue-600 text-sm font-semibold break-words px-1" id="filenamet3"></label>

                <div class="hidden text-red-600 text-sm italic text-sm px-5 break-words" id="errorimgt3">
                  FBI needs your image for verification! This is a mandatory Field.
                </div>
              </div>
            </div>
          </div>
        </div>

        <button name="action" class="bg-purple-500 mt-4 mb-2 hover:bg-purple-800 text-white font-bold shadow-inner py-2 px-10 rounded-md focus:outline-none focus:shadow-outline" type="submit" id="submitid">
          Submit
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function() {        
    $('#drivernum').keydown(function(event) {
      let evt = (event) ? event : window.event;
      let charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 47 && charCode < 58 ) || (charCode > 95 && charCode < 106) || charCode == 9 || charCode == 8) {
        return true;
      }
      return false;
    });
    
    $('#drivernum').change(function(event) {
      if($(this).val() < 0 ){
        $(this).val('');
      }
    });

    $('#speedlinkid').change(function(event) {
      let speedTestUrl = $(this).val(); 

      if(!checkSpeedtestLinkFormat(speedTestUrl) && speedTestUrl != '') {
        $('#errorspeed').removeClass('text-blue-600');
        $('#errorspeed').addClass('text-red-600');
        $('#errorspeed').html('Please provide a valid speed test link.');

        $('#speedlinkid').removeClass('border-gray-500');
        $('#speedlinkid').addClass('border-red-500');

        $('#errorspeed').show("fast");
      } else if(speedTestUrl == '') {
        $('#errorspeed').removeClass('text-red-600');
        $('#errorspeed').addClass('text-blue-600');
        $('#errorspeed').html('Ensure you perform the speed test on one of the popular platforms. The server should be set to Bangalore/Mumbai.');

        $('#speedlinkid').removeClass('border-red-500');
        $('#speedlinkid').addClass('border-gray-500');

        $('#errorspeed').show("fast");
      } else {
        $('#speedlinkid').removeClass('border-red-500');
        $('#speedlinkid').addClass('border-gray-500');

        $('#errorspeed').hide("fast");

        $('#errorspeed').removeClass('text-red-600');
        $('#errorspeed').addClass('text-blue-600');
        $('#errorspeed').html('Ensure you perform the speed test on one of the popular platforms. The server should be set to Bangalore/Mumbai.');
      }
    });
  });

  function checkSpeedtestLinkFormat(speedtestStr) {
    let expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi; 
    let regex = new RegExp(expression);

    return speedtestStr.match(regex);
  }

  refill = function() {
    var seasonid = document.getElementById("seasonnum").value;

    for(var i = 0; i < signup.length; i++) {
      season_id_selected = i;

      if(seasonid == signup[i].season) {
        document.getElementById("time1").value = signup[i].timetrial1;
        document.getElementById("time2").value = signup[i].timetrial2;
        document.getElementById("time3").value = signup[i].timetrial3;
        document.getElementById("drivernum").value = signup[i].drivernumber;

        $('#speedlinkid').val(signup[i].speedtest);
        $('#errorspeed').hide();

        document.getElementById("preference1").value = signup[i].carprefrence.split(",")[0];
        document.getElementById("preference2").value = signup[i].carprefrence.split(",")[1];
        document.getElementById("preference3").value = signup[i].carprefrence.split(",")[2];
        document.getElementById("formid").action = "/signup/update/" + signup[i].id;          //Need to be replaced with named route
        
        if (signup[i].ttevidence1 !="") {
          $('#ttevidenceid1').show('fast');
          $('#ttevidenceid2').show('fast');
          $('#ttevidenceid3').show('fast');

          document.getElementById("imglink1").href = "/storage/" + signup[i].ttevidence1;
          document.getElementById("imglink2").href = "/storage/" + signup[i].ttevidence2;
          document.getElementById("imglink3").href = "/storage/" + signup[i].ttevidence3;
          
          $('#uploadWrapper1').addClass("px-1 md:px-0");
          $('#uploadLabel1').removeClass('w-2/3');
          $('#uploadLabel1').addClass('w-1/2');
          $('#uploadWrapper2').addClass("px-1 md:px-0");
          $('#uploadLabel2').removeClass('w-2/3');
          $('#uploadLabel2').addClass('w-1/2');
          $('#uploadWrapper3').addClass("px-1 md:px-0");
          $('#uploadLabel3').removeClass('w-2/3');
          $('#uploadLabel3').addClass('w-1/2');
        }
        else {
          $('#ttevidenceid1').hide('fast');
          $('#ttevidenceid2').hide('fast');
          $('#ttevidenceid3').hide('fast');

          $('#uploadWrapper1').removeClass("px-1 md:px-0");
          $('#uploadLabel1').removeClass('w-1/2');
          $('#uploadLabel1').addClass('w-2/3');
          $('#uploadWrapper2').removeClass("px-1 md:px-0");
          $('#uploadLabel2').removeClass('w-1/2');
          $('#uploadLabel2').addClass('w-2/3');
          $('#uploadWrapper3').removeClass("px-1 md:px-0");
          $('#uploadLabel3').removeClass('w-1/2');
          $('#uploadLabel3').addClass('w-2/3');
        }
        
        if(signup[i].attendance == 1) {
          document.getElementById("radio3").checked = true;
          document.getElementById("radio4").checked = false;
        }
        else {
          document.getElementById("radio4").checked = true;
          document.getElementById("radio3").checked = false;
        }
        
        if(signup[i].assists != "") {
          if(PHPUnserialize.unserialize(signup[i].assists) != null) {
            var assist = PHPUnserialize.unserialize(signup[i].assists);
            document.getElementById("assist1").checked = false;
            document.getElementById("assist2").checked = false;
            document.getElementById("assist3").checked = false;
            document.getElementById("assist4").checked = false;

            for(var j in assist) {
              if(assist[j] == document.getElementById("assist1").value)
                document.getElementById("assist1").checked = true;
              
              if(assist[j] == document.getElementById("assist2").value)
                document.getElementById("assist2").checked = true;
              
              if(assist[j] == document.getElementById("assist3").value)
                document.getElementById("assist3").checked = true;
              
              if(assist[j] == document.getElementById("assist4").value)
                document.getElementById("assist4").checked = true;
            }
          }
        }
        
        break;
      }
      else {
        document.getElementById("time1").value = "";
        document.getElementById("time2").value = "";
        document.getElementById("time3").value = "";
        document.getElementById("drivernum").value = "";

        $('#speedlinkid').val('');
        $('#errorspeed').show();

        document.getElementById("formid").action = "/signup/store";
        document.getElementById("radio4").checked = true;
        document.getElementById("radio3").checked = false;
        document.getElementById("assist1").checked = false;
        document.getElementById("assist2").checked = false;
        document.getElementById("assist3").checked = false;
        document.getElementById("assist4").checked = false;
      }
    }
  }
    
  var signup = <?php echo json_encode($signup); ?>;
  var season_id_selected = 0;
  
  if(signup != "") {
    javascript:refill();
  }
  else {
    document.getElementById("time1").value = "";
    document.getElementById("time2").value = "";
    document.getElementById("time3").value = "";
    document.getElementById("drivernum").value = "";

    $('#speedlinkid').val('');
    $('#errorspeed').show();

    document.getElementById("formid").action = "/signup/store";
    $('#ttevidenceid1').hide('fast');
    $('#ttevidenceid2').hide('fast');
    $('#ttevidenceid3').hide('fast');
    document.getElementById("radio4").checked = true;
    document.getElementById("radio3").checked = false;
    document.getElementById("assist1").checked = false;
    document.getElementById("assist2").checked = false;
    document.getElementById("assist3").checked = false;
    document.getElementById("assist4").checked = false;

    $('#uploadWrapper1').removeClass("px-1 md:px-0");
    $('#uploadLabel1').removeClass('w-1/2');
    $('#uploadLabel1').addClass('w-2/3');
    $('#uploadWrapper2').removeClass("px-1 md:px-0");
    $('#uploadLabel2').removeClass('w-1/2');
    $('#uploadLabel2').addClass('w-2/3');
    $('#uploadWrapper3').removeClass("px-1 md:px-0");
    $('#uploadLabel3').removeClass('w-1/2');
    $('#uploadLabel3').addClass('w-2/3');
  }


  updateconstructor = function(){
    var seasonid = document.getElementById("seasonnum").value;
    var i = 0;
    var data = <?php echo json_encode($seasons); ?>;
    // data = [];
    var str = "";
    
    if(data.length === 0) {
      $('#restform').hide('fast');
      $('#headingText').html('Signups are closed!');
      $('#supportText').html('Hey, sorry! We are not currently accepting new signups for any <i>ongoing seasons</i>.');
    }
    
    $('#errordrivernum').hide('fast');
    $('#errordrivernum').html("Well, you can't escape without filling this mandatory field!");
    $('#drivernum').addClass('border-gray-500');
    $('#drivernum').removeClass('border-red-500');
    
    let speedLink = document.getElementById("speedlinkid").value;
    if(speedLink == '') {
      $('#errorspeed').html('Ensure you perform the speed test on one of the popular platforms. The server should be set to Bangalore/Mumbai.');
      
      $('#errorspeed').removeClass('text-red-600');
      $('#errorspeed').addClass('text-blue-600');
      
      $('#errorspeed').show("fast");
      
      $('#speedlinkid').removeClass('border-red-500');
      $('#speedlinkid').addClass('border-gray-500');
    } else {
      $('#speedlinkid').removeClass('border-red-500');
      $('#speedlinkid').addClass('border-gray-500');

      $('#errorspeed').hide("fast");

      $('#errorspeed').removeClass('text-red-600');
      $('#errorspeed').addClass('text-blue-600');
      $('#errorspeed').html('Ensure you perform the speed test on one of the popular platforms. The server should be set to Bangalore/Mumbai.');
    }

    $('#errorteam').hide('fast');
    $('#preference1').addClass('border-gray-500');
    $('#preference1').removeClass('border-red-500');
    $('#preference2').addClass('border-gray-500');
    $('#preference2').removeClass('border-red-500');
    $('#preference3').addClass('border-gray-500');
    $('#preference3').removeClass('border-red-500');

    $('#errort1').hide('fast');
    $('#errort1').html("Well, you can't escape without filling this mandatory field!");
    $('#time1').removeClass('border-red-500');
    $('#time1').addClass('border-gray-500');

    $('#errort2').hide('fast');
    $('#errort2').html("Well, you can't escape without filling this mandatory field!");
    $('#time2').removeClass('border-red-500');
    $('#time2').addClass('border-gray-500');

    $('#errort3').hide('fast');
    $('#errort3').html("Well, you can't escape without filling this mandatory field!");
    $('#time3').removeClass('border-red-500');
    $('#time3').addClass('border-gray-500');
  
    $('#errorimgt1').hide('fast');
    $('#errorimgt1').html("FBI needs your image for verification! This is a mandatory Field.");
    $('#imgdivt1').removeClass('border-red-500');
    $('#imgdivt1').addClass('border-gray-500');

    $('#errorimgt2').hide('fast');
    $('#errorimgt2').html("FBI needs your image for verification! This is a mandatory Field.");
    $('#imgdivt2').removeClass('border-red-500');
    $('#imgdivt2').addClass('border-gray-500');

    $('#errorimgt3').hide('fast');
    $('#errorimgt3').html("FBI needs your image for verification! This is a mandatory Field.");
    $('#imgdivt3').removeClass('border-red-500');
    $('#imgdivt3').addClass('border-gray-500');

    $('#filenamet1').hide('fast');
    $('#filenamet2').hide('fast');
    $('#filenamet3').hide('fast');

    for(i = 0; i < data.length; i++){
      if(seasonid == data[i].id) {
        $('.ttSection').show();

        if(data[i].status == 0.2) {
          $('#preferenceid').hide('fast');

          $('#errorteam').hide('fast');
          $('#preference1').addClass('border-gray-500');
          $('#preference1').removeClass('border-red-500');
          $('#preference2').addClass('border-gray-500');
          $('#preference2').removeClass('border-red-500');
          $('#preference3').addClass('border-gray-500');
          $('#preference3').removeClass('border-red-500');
        }

        if(data[i].status > 1) {
          var tempVal1 = data[i].status - Math.floor(data[i].status);
        } else {
          var tempVal1 = data[i].status;
        }

        if(tempVal1.toFixed(1) == 0.3) {
          $('.ttSection').hide();
        } else {
          $('#preferenceid').show('fast');
        }

        for(j = 0; j < data[i].constructors.length; j++) {
          str = '<option value="' + data[i].constructors[j].id + '">' + data[i].constructors[j].name + '</option>' + str;
        }

        document.getElementById("preference1").innerHTML = str;
        document.getElementById("preference2").innerHTML = str;
        document.getElementById("preference3").innerHTML = str;
        
        if(data[i].tttracks.length > 0) {
          document.getElementById("pref1id").innerHTML = data[i].tttracks[0].official.toLowerCase();
          document.getElementById("pref2id").innerHTML = data[i].tttracks[1].official.toLowerCase();
          document.getElementById("pref3id").innerHTML = data[i].tttracks[2].official.toLowerCase();
        }
      }
    }
    
    javascript:refill();
  }
  javascript:updateconstructor();

  updatelist1 = function() {
    $('#filenamet1').show('fast');
    $('#filenamet1').html(document.getElementById("imgt1").files[0].name);
  }

  updatelist2 = function() {
    $('#filenamet2').show('fast');
    $('#filenamet2').html(document.getElementById("imgt2").files[0].name);
  }

  updatelist3 = function() {
    $('#filenamet3').show('fast');
    $('#filenamet3').html(document.getElementById("imgt3").files[0].name);
  }

  // function formyesFunction() {
  //   document.getElementById("restform").style.display = "block"
  //   document.getElementById("errorgameavail").innerHTML = "<br>"
  // }

  // function formnoFunction() {
  //   document.getElementById("restform").style.display = "none"
  //   document.getElementById("errorgameavail").innerHTML = "Unless you are planning to borrow your friend's game, <br> feel free to browse for other content!"
  // }

  function validate() {
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
    var patt = new RegExp("^([0-5]?[0-9]\:)?[0-5]?[0-9][.][0-9]{3}$");
    var seasonid = document.getElementById("seasonnum").value;
    var res;
    var formStatus = '';
    var data = <?php echo json_encode($seasons); ?>;

    for(i = 0; i < data.length; i++) { 
      if(seasonid == data[i].id) {
        var formStatus = data[i].status;
      }
    }

    $('#statusCheck').val(formStatus);
    
    if(formStatus > 1) {
      var tempVal = formStatus - Math.floor(formStatus);
    } else {
      var tempVal = formStatus;
    }

    if(tempVal.toFixed(1) != 0.3) {
      res = patt.test(t1);
      if(t1 == "") {
        $('#errort1').html("Well, you can't escape without filling this mandatory field!");
        $('#errort1').show('fast');

        $('#time1').removeClass('border-gray-500');
        $('#time1').addClass('border-red-500');

        sendform = false;
      } else if (res == false) {
        $('#errort1').html("Let's follow F1 format, mate! Please enter time in the format - 1:06.006");
        $('#errort1').show('fast');

        $('#time1').removeClass('border-gray-500');
        $('#time1').addClass('border-red-500');

        sendform = false;
      } else {
        $('#errort1').hide('fast');
        $('#errort1').html("Well, you can't escape without filling this mandatory field!");

        $('#time1').removeClass('border-red-500');
        $('#time1').addClass('border-gray-500');
      }

      res = patt.test(t2);
      if(t2 == "") {
        $('#errort2').html("Well, you can't escape without filling this mandatory field!");
        $('#errort2').show('fast');

        $('#time2').removeClass('border-gray-500');
        $('#time2').addClass('border-red-500');

        sendform = false;
      } else if (res == false) {
        $('#errort2').html("Let's follow F1 format, mate! Please enter time in the format - 1:06.006");
        $('#errort2').show('fast');

        $('#time2').removeClass('border-gray-500');
        $('#time2').addClass('border-red-500');

        sendform = false;
      } else {
        $('#errort2').hide('fast');
        $('#errort2').html("Well, you can't escape without filling this mandatory field!");

        $('#time2').removeClass('border-red-500');
        $('#time2').addClass('border-gray-500');
      }

      res = patt.test(t3);
      if(t3 == "") {
        $('#errort3').html("Well, you can't escape without filling this mandatory field!");
        $('#errort3').show('fast');

        $('#time3').removeClass('border-gray-500');
        $('#time3').addClass('border-red-500');

        sendform = false;
      } else if (res == false) {
        $('#errort3').html("Let's follow F1 format, mate! Please enter time in the format - 1:06.006");
        $('#errort3').show('fast');

        $('#time3').removeClass('border-gray-500');
        $('#time3').addClass('border-red-500');

        sendform = false;
      } else {
        $('#errort3').hide('fast');
        $('#errort3').html("Well, you can't escape without filling this mandatory field!");

        $('#time3').removeClass('border-red-500');
        $('#time3').addClass('border-gray-500');
      }
    }
      
    var seasonid = document.getElementById("seasonnum").value;
    var flag = 0;

    for(i = 0; i < signup.length; i++){
      if(seasonid == signup[i].season) {
        flag = 1;
        break;
      }
    }

    if(formStatus > 1) {
      var tempVal3 = formStatus - Math.floor(formStatus);
    } else {
      var tempVal3 = formStatus;
    }

    if(tempVal3.toFixed(1) != 0.3) {
      if(flag == 0 || (flag == 1 && imaget1 != "")) {
        if(imaget1 == "") {
          $('#errorimgt1').html("FBI needs your image for verification! This is a mandatory Field.");
          $('#errorimgt1').show('fast');

          $('#imgdivt1').removeClass('border-gray-500');
          $('#imgdivt1').addClass('border-red-500');

          sendform = false; 
        } else if(
          document.getElementById("imgt1").files[0].type != "image/png" && 
          document.getElementById("imgt1").files[0].type != "image/jpg" && 
          document.getElementById("imgt1").files[0].type != "image/jpeg"
        ) {
          $('#errorimgt1').html("Sorry! Our PC won't be able to open that. Please upload image in .jpg, .jpeg or .png format.");
          $('#errorimgt1').show('fast');

          $('#imgdivt1').removeClass('border-gray-500');
          $('#imgdivt1').addClass('border-red-500');

          sendform = false; 
        } else if(document.getElementById("imgt1").files[0].size > 2097152) {
          $('#errorimgt1').html("Please upload image of size less than 2MB.");
          $('#errorimgt1').show('fast');

          $('#imgdivt1').removeClass('border-gray-500');
          $('#imgdivt1').addClass('border-red-500');
          
          sendform = false;
        } else {
          $('#errorimgt1').hide('fast');
          $('#errorimgt1').html("FBI needs your image for verification! This is a mandatory Field.");

          $('#imgdivt1').removeClass('border-red-500');
          $('#imgdivt1').addClass('border-gray-500');
        }
      }

      if(flag == 0 || (flag == 1 && imaget2 != "")) {
        if(imaget2 == "") {
          $('#errorimgt2').html("FBI needs your image for verification! This is a mandatory Field.");
          $('#errorimgt2').show('fast');

          $('#imgdivt2').removeClass('border-gray-500');
          $('#imgdivt2').addClass('border-red-500');

          sendform = false; 
        } else if(
          document.getElementById("imgt2").files[0].type != "image/png" && 
          document.getElementById("imgt2").files[0].type != "image/jpg" && 
          document.getElementById("imgt2").files[0].type != "image/jpeg"
        ) {
          $('#errorimgt2').html("Sorry! Our PC won't be able to open that. Please upload image in .jpg, .jpeg or .png format.");
          $('#errorimgt2').show('fast');

          $('#imgdivt2').removeClass('border-gray-500');
          $('#imgdivt2').addClass('border-red-500');

          sendform = false; 
        } else if(document.getElementById("imgt2").files[0].size > 2097152) {
          $('#errorimgt2').html("Please upload image of size less than 2MB.");
          $('#errorimgt2').show('fast');

          $('#imgdivt2').removeClass('border-gray-500');
          $('#imgdivt2').addClass('border-red-500');
          
          sendform = false;
        } else {
          $('#errorimgt2').hide('fast');
          $('#errorimgt2').html("FBI needs your image for verification! This is a mandatory Field.");

          $('#imgdivt2').removeClass('border-red-500');
          $('#imgdivt2').addClass('border-gray-500');
        }
      }

      if(flag == 0 || (flag == 1 && imaget3 != "")) {
        if(imaget3 == "") {
          $('#errorimgt3').html("FBI needs your image for verification! This is a mandatory Field.");
          $('#errorimgt3').show('fast');

          $('#imgdivt3').removeClass('border-gray-500');
          $('#imgdivt3').addClass('border-red-500');

          sendform = false; 
        } else if(
          document.getElementById("imgt3").files[0].type != "image/png" && 
          document.getElementById("imgt3").files[0].type != "image/jpg" && 
          document.getElementById("imgt3").files[0].type != "image/jpeg"
        ) {
          $('#errorimgt3').html("Sorry! Our PC won't be able to open that. Please upload image in .jpg, .jpeg or .png format.");
          $('#errorimgt3').show('fast');

          $('#imgdivt3').removeClass('border-gray-500');
          $('#imgdivt3').addClass('border-red-500');

          sendform = false; 
        } else if(document.getElementById("imgt3").files[0].size > 2097152) {
          $('#errorimgt3').html("Please upload image of size less than 2MB.");
          $('#errorimgt3').show('fast');

          $('#imgdivt3').removeClass('border-gray-500');
          $('#imgdivt3').addClass('border-red-500');
          
          sendform = false;
        } else {
          $('#errorimgt3').hide('fast');
          $('#errorimgt3').html("FBI needs your image for verification! This is a mandatory Field.");

          $('#imgdivt3').removeClass('border-red-500');
          $('#imgdivt3').addClass('border-gray-500');
        }
      }
    }

    if (seas == "") {
      $('#seasonnum').removeClass('border-gray-500');
      $('#seasonnum').addClass('border-red-500');
      
      $('#errorseason').show('fast');

      sendform = false;
    } else {
      $('#seasonnum').removeClass('border-red-500');
      $('#seasonnum').addClass('border-gray-500');

      $('#errorseason').hide('fast');
    }

    if (driverno == "") {
      $('#errordrivernum').html("Well, you can't escape without filling this mandatory field!");
      $('#errordrivernum').show('fast');

      $('#drivernum').removeClass('border-gray-500');
      $('#drivernum').addClass('border-red-500');
      
      sendform = false;
    } else if (driverno < 1  || driverno > 999){
      $('#errordrivernum').html('Enter a number between 1 and 999.');
      $('#errordrivernum').show('fast');

      $('#drivernum').removeClass('border-gray-500');
      $('#drivernum').addClass('border-red-500');

      sendform = false;
    } else {
      $('#drivernum').addClass('border-gray-500');
      $('#drivernum').removeClass('border-red-500');

      $('#errordrivernum').hide('fast');
      $('#errordrivernum').html("Well, you can't escape without filling this mandatory field!");
    }
    
    if(!checkSpeedtestLinkFormat(speedlink) && speedlink != '') {
      $('#errorspeed').html("Well, you can't escape without filling this mandatory field!");
      
      sendform = false;
    } else if(speedlink == '') {
      $('#speedlinkid').addClass('border-red-500');
      $('#speedlinkid').removeClass('border-gray-500');

      $('#errorspeed').addClass('text-red-600');
      $('#errorspeed').removeClass('text-blue-600');

      $('#errorspeed').html("Well, you can't escape without filling this mandatory field!");

      sendform = false;
    } else{
      $('#speedlinkid').removeClass('border-red-500');
      $('#speedlinkid').addClass('border-gray-500');

      $('#errorspeed').hide("fast");

      $('#errorspeed').removeClass('text-red-600');
      $('#errorspeed').addClass('text-blue-600');
      $('#errorspeed').html('Ensure you perform the speed test on one of the popular platforms. The server should be set to Bangalore/Mumbai.');
    }
      
    flag = 0;
    for(i = 0; i < data.length; i++) { 
      if(seasonid == data[i].id) {
        if(data[i].status == 0.2) {
          flag = 1;
        }
      }
    }
      
    if(
      (
        preference1.localeCompare(preference2) == 0 || 
        preference1.localeCompare(preference3) == 0 || 
        preference2.localeCompare(preference3) == 0
      ) && flag != 1
    ) {
      $('#errorteam').show('fast');

      $('#preference1').removeClass('border-gray-500');
      $('#preference1').addClass('border-red-500');

      $('#preference2').removeClass('border-gray-500');
      $('#preference2').addClass('border-red-500');

      $('#preference3').removeClass('border-gray-500');
      $('#preference3').addClass('border-red-500');

      sendform = false;
    } else {
      $('#errorteam').hide('fast');

      $('#preference1').addClass('border-gray-500');
      $('#preference1').removeClass('border-red-500');

      $('#preference2').addClass('border-gray-500');
      $('#preference2').removeClass('border-red-500');

      $('#preference3').addClass('border-gray-500');
      $('#preference3').removeClass('border-red-500');
    }

    return sendform;
  }
</script>
@endsection
