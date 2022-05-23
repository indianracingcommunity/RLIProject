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
    color: #4c51bf; 
  }
</style>
<div class="w-1/2 sm:w-auto md:w-full lg:w-full xl:w-full">
  <div class="font-semibold text-left text-blue-800 shadow-lg bg-blue-200 rounded-md px-6 py-4 profileAlert mb-4">
  <div class="text-2xl">Welcome to League Sign Ups<br></div><i class="fa fa-exclamation-circle" aria-hidden="true"></i>  Your entries are <strong>Editable</strong> until Sign ups close or <i>Thanos snaps his fingers.</i>
  </div>
  <form id="formid" class="w-1/2 sm:w-auto md:w-full lg:w-full xl:w-full bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
    @csrf
    
    <div id="restform">
      <label class="block text-gray-700 text-xl font-bold mb-2">
        Sign Up Details
      </label>
      
    <input type="hidden" name="statusCheck" id='statusCheck'>
      <div class="w-full flex items-center justify-between px-12 mt-5">
        <div class="inline-flex w-1/2">
          <div class="inline-flex items-stretch pt-2">
            <label class="inline-block text-gray-700 text-base font-bold mb-2">
              Select Season
            </label>
          </div>
          <div class="inline-flex relative">
            <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="seasonnum" name="seas" onchange="javascript:updateconstructor()">
              @foreach ($seasons as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        </div>

        <div class="flex w-1/2">
          <label class="inline-block w-auto text-gray-700 text-base font-bold">Will you be able to attend 75% of races?</label>
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
      </div>

      <div class="block w-full text-red-600 text-sm italic mt-2 px-12" id="errorseason">
        <br><br>
      </div>

      
      <div class="flex items-center justify-between px-12 w-full mt-3">
        <div class="flex w-1/2">
          <div class="inline-flex items-stretch pt-2">
            <label class="inline-block text-gray-700 text-base font-bold">
              Driver Number
            </label>
          </div>
          <div class="inline-block pl-3">
            <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-20 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="drivernum" type="number" name="drivernumber">
            <div class="block text-red-600 text-sm italic pt-2" id="errordrivernum">
              <br><br>
            </div>
          </div>
        </div>

        <div class="flex w-1/2">
          <div class="inline-flex w-auto justify-end pt-2">
            <label class="inline-block text-gray-700 text-base font-bold">
              Speed test result link
            </label>
          </div>
          <div class="inline-block w-auto pl-3">
            <input class="bg-gray-200 appearance-none required border shadow-lg border-gray-500 rounded w-64 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="speedlinkid" type="link" name="speedtest">
            <div class="block text-red-600 text-sm italic pt-2" id="errorspeed">
              Enter the link of your speed test performed at <br> "https://www.speedtest.net/"<br> Ensure that the server is set to Bangalore/Mumbai
            </div>
          </div>
        </div>
      </div>
           
      <div class="bg-purple-700 w-full h-px mt-2 rounded shadow-2xl ttSection">
      </div>

      <div class="flex-wrap w-full">
        <div class="w-full ttSection">
          <div class="flex items-center w-full px-12 mt-5">
            <div class="flex w-1/2">
              <div class="block items-stretch overflow-hidden" style="width: 8.7rem;">
                <label class="block text-gray-700 text-base font-bold capitalize">
                  Time Trial Time #1
                </label>
                <label class="block text-gray-700 text-base font-bold capitalize" id="pref1id">
                </label>
              </div>
              <div class="inline-block pl-3 pt-1">
                <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="time1" type="text" name="t1">
                <div class="block w-auto text-red-600 text-sm italic pt-2" id="errort1">
                  <br><br>
                </div>
              </div>
            </div>

            <div class="flex w-1/2 pt-2">
              <div class="inline-flex appearance-none bg-grey-lighter">
                <div class="inline-block items-stretch pt-2">
                  <label class="block text-gray-700 text-base font-bold ">
                    Evidence
                  </label>
                </div>

                <div class="flex-wrap">
                  <div class="flex">
                    <div class="inline-block pl-3" >
                      <label class="w-auto inline-block items-center px-4 py-0 bg-gray-200 appearance-none border shadow-lg cursor-pointer border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt1">
                          <svg class="inline-block w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                              <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                          </svg>
                          <span class="inline-block pt-2 text-base leading-normal">Upload</span>
                          <input type='file' name="evidencet1" accept=".png, .jpg, .jpeg" class="hidden" id="imgt1" onchange="javascript:updatelist1()"/>
                      </label>
                    </div>

                    <div id="ttevidenceid1" class="inline-block pl-2">
                      <a id="imglink1" target="_blank">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                          viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve" fill="currentColor" class="px-1 w-12 h-10 bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500">
                          
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

                    <div class="inline-flex items-center break-all w-64 h-10 pl-2 overflow-hidden">
                      <label class="text-gray-700 text-sm font-bold" id="filenamet1"></label>
                    </div>
                  </div>
                  <div class="block w-auto text-red-600 text-sm italic pt-2 pl-3" id="errorimgt1">
                    <br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="flex items-center w-full px-12 mt-5">
            <div class="flex w-1/2">
              <div class="block items-stretch overflow-hidden" style="width: 8.7rem;">
                <label class="block text-gray-700 text-base font-bold capitalize">
                  Time Trial Time #2
                </label>
                <label class="block text-gray-700 text-base font-bold capitalize" id="pref2id">
                </label>
              </div>
              <div class="inline-block pl-3 pt-1">
                <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="time2" type="text" name="t2">
                <div class="block w-auto text-red-600 text-sm italic pt-2" id="errort2">
                  <br><br>
                </div>
              </div>
            </div>

            <div class="flex w-1/2 pt-2">
              <div class="inline-flex appearance-none bg-grey-lighter">
                <div class="inline-block items-stretch pt-2">
                  <label class="block text-gray-700 text-base font-bold ">
                    Evidence
                  </label>
                </div>

                <div class="flex-wrap">
                  <div class="flex">
                    <div class="inline-block pl-3" >
                      <label class="w-auto inline-block items-center px-4 py-0 bg-gray-200 appearance-none border shadow-lg cursor-pointer border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt2">
                          <svg class="inline-block w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                              <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                          </svg>
                          <span class="inline-block pt-2 text-base leading-normal">Upload</span>
                          <input type='file' name="evidencet2" accept=".png, .jpg, .jpeg" class="hidden" id="imgt2" onchange="javascript:updatelist2()"/>
                      </label>
                    </div>

                    <div id="ttevidenceid2" class="inline-block pl-2">
                      <a id="imglink2" target="_blank">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                          viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve" fill="currentColor" class="px-1 w-12 h-10 bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500">
                          
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

                    <div class="inline-flex items-center break-all w-64 h-10 pl-2 overflow-hidden">
                      <label class="text-gray-700 text-sm font-bold" id="filenamet2"></label>
                    </div>
                  </div>
                  <div class="block w-auto text-red-600 text-sm italic pt-2 pl-3" id="errorimgt2">
                    <br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>      

          <div class="flex items-center w-full px-12 mt-5">
            <div class="flex w-1/2">
              <div class="block items-stretch overflow-hidden" style="width: 8.7rem;">
                <label class="block text-gray-700 text-base font-bold capitalize">
                  Time Trial Time #3
                </label>
                <label class="block text-gray-700 text-base font-bold capitalize" id="pref3id">
                </label>
              </div>
              <div class="inline-block pl-3 pt-1">
                <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="time3" type="text" name="t3">
                <div class="block w-auto text-red-600 text-sm italic pt-2" id="errort3">
                  <br><br>
                </div>
              </div>
            </div>

            <div class="flex w-1/2 pt-2">
              <div class="inline-flex appearance-none bg-grey-lighter">
                <div class="inline-block items-stretch pt-2">
                  <label class="block text-gray-700 text-base font-bold ">
                    Evidence
                  </label>
                </div>

                <div class="flex-wrap">
                  <div class="flex">
                    <div class="inline-block pl-3" >
                      <label class="w-auto inline-block items-center px-4 py-0 bg-gray-200 appearance-none border shadow-lg cursor-pointer border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" id="imgdivt3">
                          <svg class="inline-block w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                              <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                          </svg>
                          <span class="inline-block pt-2 text-base leading-normal">Upload</span>
                          <input type='file' name="evidencet3" accept=".png, .jpg, .jpeg" class="hidden" id="imgt3" onchange="javascript:updatelist3()"/>
                      </label>
                    </div>

                    <div id="ttevidenceid3" class="inline-block pl-2">
                      <a id="imglink3" target="_blank">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                          viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve" fill="currentColor" class="px-1 w-12 h-10 bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded text-purple-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500">
                          
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

                    <div class="inline-flex items-center break-all w-64 h-10 pl-2 overflow-hidden">
                      <label class="text-gray-700 text-sm font-bold" id="filenamet3"></label>
                    </div>
                  </div>
                  <div class="block w-auto text-red-600 text-sm italic pt-2 pl-3" id="errorimgt3">
                    <br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>      
          
        </div>

        <div class="bg-purple-700 w-full h-px mt-2 rounded shadow-2xl"> </div>

        <div class="flex mt-5 px-12 w-full">
          <label class="flex justify-center">
            <span class="flex text-gray-700 text-base font-bold">Assists</span>
          </label>
          
          
          <div class="flex px-5 w-full items-center">
            <label class="flex items-center justify-left ml-12">
              <input id="assist1" type="checkbox" class="form-checkbox text-pink-600 h-4 w-4" name="assists[]" value="traction" >
              <span class="ml-2 cursor-pointer">Traction Control</span>
            </label>
            <label class="flex items-center justify-left ml-12">
              <input id="assist2" type="checkbox" class="form-checkbox text-pink-600 h-4 w-4" name="assists[]" value="abs" >
              <span class="ml-2 cursor-pointer">Anti lock brakes</span>
            </label>
            <label class="flex items-center justify-left ml-12">
              <input id="assist3" type="checkbox" class="form-checkbox text-pink-600 h-4 w-4" name="assists[]" value="line">
              <span class="ml-2 cursor-pointer">Racing line</span>
            </label>
            <label class="flex items-center justify-left ml-12">
              <input id="assist4" type="checkbox" class="form-checkbox text-pink-600 h-4 w-4" name="assists[]" value="autogears" >
              <span class="ml-2 cursor-pointer">Auto Transmission</span>
            </label>
          </div>
        </div>
      </div>
      
      <!-- <div class="bg-purple-700 w-full h-px mt-5 rounded shadow-2xl"> </div> -->

      <div class="flex justify-between mt-12 px-12" id="preferenceid">
        <div class="inline-block">
          <label class="block text-gray-700 text-base font-bold mb-2" >
            Team preference 1
          </label>
          <div class="block relative">
            <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-5 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="preference1" name="pref1">
              
            </select>
            <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        </div>

        <div class="inline-block">
          <label class="block text-gray-700 text-base font-bold mb-2" >
            Team preference 2
          </label>
          <div class="block relative">
            <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-5 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="preference2" name="pref2">
              
            </select>
            <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        </div>

        <div class="inline-block">
          <label class="block text-gray-700 text-base font-bold mb-2" >
            Team preference 3
          </label>
          <div class="inline-block relative">
            <select class="block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-5 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" id="preference3" name="pref3">
              
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
        <button name="action" class="bg-purple-500 hover:bg-purple-600 text-white font-bold shadow-lg py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" id="submitid">
          Submit
        </button>
      </div>
    </div>
  </form>
  <script>
   $( document ).ready(function() {
                        
      $('#drivernum').keydown(function(event) {
         evt = (event) ? event : window.event;
         var charCode = (evt.which) ? evt.which : evt.keyCode;
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
         var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi; 
         var regex = new RegExp(expression); 
         var speedTestUrl = $(this).val(); 
         if (speedTestUrl.match(regex)) {  
         } else { 
            $(this).val(''); 
         } 
      });
   });

    refill = function(){
      var seasonid = document.getElementById("seasonnum").value
      for(var i=0;i<signup.length;i++){
        season_id_selected = i;
        if(seasonid == signup[i].season){
          document.getElementById("time1").value = signup[i].timetrial1;
          document.getElementById("time2").value = signup[i].timetrial2;
          document.getElementById("time3").value = signup[i].timetrial3;
          document.getElementById("drivernum").value = signup[i].drivernumber;
          document.getElementById("speedlinkid").value = signup[i].speedtest;
          document.getElementById("preference1").value = signup[i].carprefrence.split(",")[0];
          document.getElementById("preference2").value = signup[i].carprefrence.split(",")[1];
          document.getElementById("preference3").value = signup[i].carprefrence.split(",")[2];
          document.getElementById("formid").action = "/signup/update/" + signup[i].id;          //Need to be replaced with named route
          

          if (signup[i].ttevidence1 !=""){
            document.getElementById("ttevidenceid1").style.display = "inline-block";
            document.getElementById("ttevidenceid2").style.display = "inline-block";
            document.getElementById("ttevidenceid3").style.display = "inline-block";
            document.getElementById("imglink1").href = "/storage/" + signup[i].ttevidence1;
            document.getElementById("imglink2").href = "/storage/" + signup[i].ttevidence2;
            document.getElementById("imglink3").href = "/storage/" + signup[i].ttevidence3;
          }
          else{
            document.getElementById("ttevidenceid1").style.display = "none";
            document.getElementById("ttevidenceid2").style.display = "none";
            document.getElementById("ttevidenceid3").style.display = "none";
          }
          
          if(signup[i].attendance == 1){
            document.getElementById("radio3").checked = true;
            document.getElementById("radio4").checked = false;
          }
          else{
            document.getElementById("radio4").checked = true;
            document.getElementById("radio3").checked = false;
          }
          
          if (signup[i].assists != ""){
            if (PHPUnserialize.unserialize(signup[i].assists) != null){
              var assist = PHPUnserialize.unserialize(signup[i].assists);
                document.getElementById("assist1").checked = false;
                document.getElementById("assist2").checked = false;
                document.getElementById("assist3").checked = false;
                document.getElementById("assist4").checked = false;
              for(var j in assist) {
                
                if (assist[j] == document.getElementById("assist1").value)
                  document.getElementById("assist1").checked = true;
                if (assist[j] == document.getElementById("assist2").value)
                  document.getElementById("assist2").checked = true;
                
                if (assist[j] == document.getElementById("assist3").value)
                  document.getElementById("assist3").checked = true;
                
                if (assist[j] == document.getElementById("assist4").value)
                  document.getElementById("assist4").checked = true;
                
              }
              
            }
          }
          break;
        }
        else{
          document.getElementById("time1").value = "";
          document.getElementById("time2").value = "";
          document.getElementById("time3").value = "";
          document.getElementById("drivernum").value = "";
          document.getElementById("speedlinkid").value = "";
          document.getElementById("formid").action = "/signup/store";
          document.getElementById("ttevidenceid1").style.display = "none";
          document.getElementById("ttevidenceid2").style.display = "none";
          document.getElementById("ttevidenceid3").style.display = "none";
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
    
    if(signup != "")
      {
        javascript:refill();
      }
    else{
      document.getElementById("time1").value = "";
      document.getElementById("time2").value = "";
      document.getElementById("time3").value = "";
      document.getElementById("drivernum").value = "";
      document.getElementById("speedlinkid").value = "";
      document.getElementById("formid").action = "/signup/store";
      document.getElementById("ttevidenceid1").style.display = "none";
      document.getElementById("ttevidenceid2").style.display = "none";
      document.getElementById("ttevidenceid3").style.display = "none";
      document.getElementById("radio4").checked = true;
      document.getElementById("radio3").checked = false;
      document.getElementById("assist1").checked = false;
      document.getElementById("assist2").checked = false;
      document.getElementById("assist3").checked = false;
      document.getElementById("assist4").checked = false;
    }


    updateconstructor = function(){
      var seasonid = document.getElementById("seasonnum").value;
      var i = 0;
      var data = <?php echo json_encode($seasons); ?>;
      var str = "";
      
      document.getElementById("errort1").innerHTML = "<br><br>";
      document.getElementById("time1").style = "";
      document.getElementById("errort2").innerHTML = "<br><br>";
      document.getElementById("time2").style = "";
      document.getElementById("errort3").innerHTML = "<br><br>";
      document.getElementById("time3").style = "";
      document.getElementById("errorimgt1").innerHTML = "<br><br>";
      document.getElementById("imgdivt1").style = "";
      document.getElementById("errorimgt2").innerHTML = "<br><br>";
      document.getElementById("imgdivt2").style = "";
      document.getElementById("errorimgt3").innerHTML = "<br><br>";
      document.getElementById("imgdivt3").style = "";
      document.getElementById("errordrivernum").innerHTML = "<br><br>";
      document.getElementById("drivernum").style = "";
      document.getElementById("errorspeed").innerHTML = "<br><br>";
      document.getElementById("speedlinkid").style = "";
      document.getElementById("errorteam").innerHTML = "<br><br>";
      document.getElementById("preference1").style = "";
      document.getElementById("preference2").style = "";
      document.getElementById("preference3").style = "";

      for(i=0;i<data.length;i++){
        
        if(seasonid == data[i].id){
          $('.ttSection').show();
          if(data[i].status == 0.2){
            document.getElementById("preferenceid").style.display = "none";
            document.getElementById("errorteam").style.display = "none";
          }
          if(data[i].status > 1){
            var tempVal1 = data[i].status - Math.floor(data[i].status);
          }else{
            var tempVal1 = data[i].status;
          }

          if(tempVal1.toFixed(1) == 0.3){
            $('.ttSection').hide();
          }
          else{
            document.getElementById("preferenceid").style.display = "flex";
            document.getElementById("errorteam").style.display = "block";
          }
          for(j=0;j<data[i].constructors.length;j++){
            str = '<option value="' + data[i].constructors[j].id + '">' + data[i].constructors[j].name + '</option>' + str;
          }
          document.getElementById("preference1").innerHTML = str;
          document.getElementById("preference2").innerHTML = str;
          document.getElementById("preference3").innerHTML = str;
          if(data[i].tttracks.length > 0){
            document.getElementById("pref1id").innerHTML = data[i].tttracks[0].official.toLowerCase();
            document.getElementById("pref1id").style.textTransform = "capitalize";
            document.getElementById("pref2id").innerHTML = data[i].tttracks[1].official.toLowerCase();
            document.getElementById("pref2id").style.textTransform = "capitalize";
            document.getElementById("pref3id").innerHTML = data[i].tttracks[2].official.toLowerCase();
            document.getElementById("pref3id").style.textTransform = "capitalize";
          }
        }
      }
      javascript:refill();
    }
    javascript:updateconstructor();
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
      var patt = new RegExp("^([0-5]?[0-9]\:)?[0-5]?[0-9][.][0-9]{3}$");;
      var seasonid = document.getElementById("seasonnum").value;
      var res;
      var formStatus = '';
      var data = <?php echo json_encode($seasons); ?>;
      for(i=0;i<data.length;i++){ 
        if(seasonid == data[i].id){
          var formStatus = data[i].status;
        }
      }

      $('#statusCheck').val(formStatus);
      if(formStatus > 1){
        var tempVal = formStatus - Math.floor(formStatus);
      }else{
        var tempVal = formStatus;
      }
      if(tempVal.toFixed(1) != 0.3){
        res = patt.test(t1);
        if (t1 == ""){
          document.getElementById("errort1").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
          document.getElementById("time1").style.borderColor = "#f56565";
          sendform = false;
        }
        else if (res == false){
          document.getElementById("errort1").innerHTML = "Let's follow F1 format mate! <br> Time format should be 1:06.006";
          document.getElementById("time1").style.borderColor = "#f56565";
          sendform = false;
        }
        else{
          document.getElementById("errort1").innerHTML = "<br><br>";
          document.getElementById("time1").style = "";
        }
  
        res = patt.test(t2);
        if (t2 == ""){
          document.getElementById("errort2").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
          document.getElementById("time2").style.borderColor = "#f56565";
          sendform = false;
        }
        else if (res == false){
          document.getElementById("errort2").innerHTML = "Let's follow F1 format mate! <br> Time format should be 1:06.006";
          document.getElementById("time2").style.borderColor = "#f56565";
          sendform = false;
        }
        else{
          document.getElementById("errort2").innerHTML = "<br><br>";
          document.getElementById("time2").style = "";
        }
        
        res = patt.test(t3);
        if (t3 == ""){
          document.getElementById("errort3").innerHTML = "Well can't escape without filling this! <br> Mandatory Field";
          document.getElementById("time3").style.borderColor = "#f56565";
          sendform = false;
        }
        else if (res == false){
          document.getElementById("errort3").innerHTML = "Let's follow F1 format mate! <br> Time format should be 1:06.006";
          document.getElementById("time3").style.borderColor = "#f56565";
          sendform = false;
        }
        else{
          document.getElementById("errort3").innerHTML = "<br><br>";
          document.getElementById("time3").style = "";
        }
      }
      
      var seasonid = document.getElementById("seasonnum").value;
      var flag = 0;
      for(i=0;i<signup.length;i++){
        if(seasonid == signup[i].season){
          flag = 1;
          break;
        }
      }

      if(formStatus > 1){
        var tempVal3 = formStatus - Math.floor(formStatus);
      }else{
        var tempVal3 = formStatus;
      }

      if(tempVal3.toFixed(1) != 0.3){
        if (flag == 0 || (flag == 1 && imaget1 != "")){
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
          else if(document.getElementById("imgt1").files[0].size > 2097152){
            document.getElementById("errorimgt1").innerHTML = "You may have a lot of high quality pics of stuff :P <br> Please limit file sizes to 2MB";
            document.getElementById("imgdivt1").style.borderColor = "#f56565";
            sendform = false; 
          }
          else{
            document.getElementById("errorimgt1").innerHTML = "<br><br>";
            document.getElementById("imgdivt1").style = "";
          }
        }
        if (flag == 0 || (flag == 1 && imaget2 != "")){
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
          else if(document.getElementById("imgt2").files[0].size > 2097152){
            document.getElementById("errorimgt2").innerHTML = "You may have a lot of high quality pics of stuff :P <br> Please limit file sizes to 2MB";
            document.getElementById("imgdivt2").style.borderColor = "#f56565";
            sendform = false; 
          }
          else{
            document.getElementById("errorimgt2").innerHTML = "<br><br>";
            document.getElementById("imgdivt2").style = "";
          }
        }
  
        if (flag == 0 || (flag == 1 && imaget3 != "")){
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
          else if(document.getElementById("imgt3").files[0].size > 2097152){
            document.getElementById("errorimgt3").innerHTML = "You may have a lot of high quality pics of stuff :P <br> Please limit file sizes to 2MB";
            document.getElementById("imgdivt3").style.borderColor = "#f56565";
            sendform = false; 
          }
          else{
            document.getElementById("errorimgt3").innerHTML = "<br><br>";
            document.getElementById("imgdivt3").style = "";
          }
        }
      }

      if (seas == ""){
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
      else if (driverno < 1  || driverno > 999){
        document.getElementById("errordrivernum").innerHTML = "Enter driver number between 1 and 999";
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

      
      flag = 0;
      for(i=0;i<data.length;i++){ 
        if(seasonid == data[i].id){
          if(data[i].status == 0.2){
            flag = 1;
        }}}
      if ((preference1.localeCompare(preference2) == 0 || preference1.localeCompare(preference3) == 0 || preference2.localeCompare(preference3) == 0) && flag != 1){
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