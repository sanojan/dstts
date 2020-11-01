<!DOCTYPE html>
<html>
@inject('app', 'Illuminate\Contracts\Foundation\Application')
@inject('urlGenerator', 'Illuminate\Routing\UrlGenerator')
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Register your Complaint</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('plugins/node-waves/waves.css')}}" rel="stylesheet" />
    
    <!-- Toastr Css -->
    @toastr_css

    <!-- date time picker -->
    <link href="{{asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
    
    <!-- Animation Css -->
    <link href="{{asset('plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

     <!-- Dropdown with search-->
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>
  
<body class="signup-page">

 <!-- Page Loader -->
<div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-light-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
 <!-- End Page Loader -->

 <div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    @if(app()->getLocale() == "en")
        ENGLISH
        @elseif(app()->getLocale() == "si")
        සිංහල
        @elseif(app()->getLocale() == "ta")
        தமிழ்
    @endif
    <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="{{ $urlGenerator->toLanguage('en') }}" class=" waves-effect waves-block">ENGLISH</a></li>
        <li><a href="{{ $urlGenerator->toLanguage('si') }}" class=" waves-effect waves-block">සිංහල</a></li>
        <li><a href="{{ $urlGenerator->toLanguage('ta') }}" class=" waves-effect waves-block">தமிழ்</a></li>
    </ul>
</div>
    <div class="signup-box">
        <div class="logo">
            <a href="{{route('complaints.create', app()->getLocale())}}">{{__('Submit Your Complaint')}}</a>
            <small>{{ __('District Secretariat - Ampara') }}</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST" enctype="multipart/form-data" action="{{ route('complaints.store', app()->getLocale()) }}">
                    @csrf

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__('Name with Initial')}}">
                                
                                </div>
                                @error('name')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">people</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control gender_dropdown" id="gender" name="gender">
                                    <option value="" @if(old('gender' )== '') selected disabled @endif>{{_('Select your Gender')}}</option>
                                    <option value="Male" @if(old('gender')=='Male') selected @endif>{{__('Male')}}</option>
                                    <option value="Female" @if(old('gender')=='Female') selected @endif>{{__('Female')}}</option>
                                </select>
                                </div>
                                @error('gender')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                        

                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">event</i>
                                </span>
                                <div class="form-line">
                                <input placeholder="{{__('Date of Birth')}}" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="dob" name="dob" value="{{ old('dob') }}">
                                </div>
                                @error('dob')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div> 
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">card_membership</i>
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="{{__('NIC NO')}}" name="nic" value="{{ old('nic') }}">
                                </div>
                                @error('nic')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-line">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{__('Email Address')}}">
                                </div>
                                @error('email')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">phone_iphone</i>
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="{{__('Mobile No')}}" name="mobile_no" value="{{ old('mobile_no') }}">
                                </div>
                                @error('mobile_no')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="input-group">
                            <span class="input-group-addon">
                                    <i class="material-icons">location_on</i>
                                    </span>
                                    <div class="form-line">
                                        <select class="form-control dsdivision_dropdown" style="width:100%;" id="dsdivision" name="dsdivision">
                                        <option value="" @if(old('dsdivision')=='') selected disabled @endif>{{__('Select Your DS Division')}}</option>
                                        @foreach($dsdivisions as $dsdivision)
                                        <option value="{{$dsdivision->name}}" {{ old('dsdivision') == $dsdivision->name ? "selected" :""}}>{{$dsdivision->name}} </option>
                                        @endforeach
                                        </select>
                                    </div>
                                    @error('dsdivision')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                            <span class="input-group-addon">
                                    <i class="material-icons">location_on</i>
                                </span>
                                    <div class="form-line">
                                        <select class="form-control gndivision_dropdown" style="width:100%;" id="gndivision" name="gndivision" value="{{ old('gndivision') }}">
                                        @if(old('gndivision'))
                                        <option value="{{ old('gndivision') }}" selected>{{ old('gndivision')}}</option>
                                        @else
                                        <option value="" selected>Select your GN Division</option>
                                        @endif
                                        </select>
                                    </div>
                                    @error('gndivision')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">location_city</i>
                                </span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="permanant_address" name="permanant_address" value="{{ old('permanant_address') }}" placeholder="{{__('Permanant Address')}}">
                                    </div>
                                    
                                    @error('permanant_address')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">location_city</i>
                                </span>
                                    <div class="form-line">
                                    <input type="text" class="form-control" id="temporary_address" name="temporary_address" value="{{ old('temporary_address') }}" placeholder="{{__('Temporary Address')}}">
                                    </div>
                                    @error('temporary_address')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                    <div class="col-sm-12">
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">work</i>`
                                </span>
                                    <div class="form-line">
                                        <select class="form-control comp_officer_dropdown" style="width:100%;" id="comp_officer" name="comp_officer" value="{{ old('comp_officer') }}">
                                        <option value="" @if(old('comp_officer')=='') selected disabled @endif>{{__('Select the officer you want to  send complaint')}}</option>
                                        @foreach($comp_officers as $comp_officer)
                                        <option value="{{$comp_officer->id}}" {{ old('comp_officer') == $comp_officer->id ? "selected" :""}}>{{$comp_officer->name}} - {{$comp_officer->designation}} ({{$comp_officer->workplace}})</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    
                                    @error('comp_officer')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>

                        </div>
                    </div>

                    <div class="row clearfix">

                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">note</i>
                                </span>
                                <div class="form-line">
                                <textarea rows="3" class="form-control no-resize" id="complaint_content" name="complaint_content" placeholder="{{__('Complaint content')}}">{{ old('complaint_content') }}</textarea>
                                </div>
                                @error('complaint_content')   
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons"></i>
                                    </span>
                                    <label class="form-label">{{__('Complaint Scanned Copy (Optional)')}}</label>
                                    <input type="file" name="complaint_scanned_copy" class="form-control"> 
                                    @error('complaint_scanned_copy')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                 
                    <button class="btn btn-block btn-lg bg-purple waves-effect" type="submit">{{__('SUBMIT')}}</button>
                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{route('login', app()->getLocale())}}">{{__('You already submit a complaint?')}}</a>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Toastr Plugin Js -->
    @toastr_js

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('plugins/node-waves/waves.js')}}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{asset('plugins/jquery-validation/jquery.validate.js')}}"></script>
    
    <!-- date time picker Js -->
    <script src="{{asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    
    <!-- Custom Js -->
    <script src="{{asset('js/admin.js')}}"></script>
    
    <script src="{{asset('js/pages/examples/sign-up.js')}}"></script>
    <!-- Dropdown with search-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">



$('.comp_officer_dropdown').select2({
  placeholder: '{{__('Select Officer to send complaint')}}',
  width: 'resolve'
});

$('.gender_dropdown').select2({
  placeholder: '{{__('Select your Gender')}}',
  width: 'resolve'
});

$('.dsdivision_dropdown').select2({
  placeholder: '{{__('Select your DS Division')}}',
  width: 'resolve'
});

$('.gndivision_dropdown').select2({
  placeholder: '{{__('Select your GN Division')}}',
  width: 'resolve'
});


</script>

<script>
    $('#dsdivision').change(function(){
  var dsdiv_name = $(this).val();  
  if(dsdiv_name){
    $.ajax({
      type:"GET",
      url:"{{url('app()->getLocale()/get-gndivision-list')}}?ds_name="+dsdiv_name,
      success:function(res){        
      if(res){
        $("#gndivision").empty();
        $("#gndivision").append('<option>{{__('Select your GN Division')}}</option>');
        $.each(res,function(key,value){
          $("#gndivision").append('<option value="'+value+'">'+value+'</option>');
        });
      
      }else{
        $("#gndivision").empty();
      }
      }
    });
  }else{
    $("#gndivision").empty();
  }   
  });
</script>

</body>

</html>