<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign Up | DS-TTS</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('plugins/node-waves/waves.css')}}" rel="stylesheet" />
    
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
    <div class="signup-box">
        <div class="logo">
            <a href="{{route('home', app()->getLocale())}}">DS-<b>TTS</b></a>
            <small>{{ __('Task Tracking System - District Secretariat, Ampara') }}</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST" action="{{ route('register', app()->getLocale()) }}">
                    @csrf
                    <div class="msg">{{__('Register a new membership')}}</div>
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
                                    <i class="material-icons">location_city</i>
                                </span>
                                    <div class="form-line">
                                        <select class="form-control workplace_type_dropdown" style="width:100%;" id="workplace_type" name="workplace_type" value="{{ old('workplace_type') }}">
                                        <option value="" @if(old('workplace_type')=='') selected disabled @endif>Select Your Work Place Type</option>
                                        @foreach($workplacetypes as $workplacetype)
                                        <option value="{{$workplacetype->id}}" {{ old('workplace_type') == $workplacetype->id ? "selected" :""}}>{{$workplacetype->name}} </option>
                                        @endforeach
                                        </select>
                                    </div>
                                    
                                    @error('workplace_type')
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
                                        <select class="form-control workplace_dropdown" style="width:100%;" id="workplace" name="workplace">
                                        @if(old('workplace'))

                                        @php
                                        $workplace = \App\Workplace::find(old('workplace'));
                                        @endphp
                                        <option value="{{ old('workplace') }}" selected>{{ $workplace->name}}</option>
                                        @else
                                        <option value="" selected>Select your workplace</option>
                                        @endif
                                        </select>
                                    </div>
                                    @error('workplace')
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
                                    <i class="material-icons">business_center</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control service_dropdown" id="service" name="service" >
                                        <option value="" @if(old('service')=='') selected disabled @endif>{{__('Select your service')}}</option>
                                        @foreach($services as $service)
                                        <option value="{{$service->name}}" {{ old('service') == $service->name ? "selected" : ""}}>{{$service->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('service')   
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">people_outline</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control class_dropdown" id="class" name="class" >
                                        <option value="" @if(old('class')=='') selected disabled @endif>Select your service class</option>
                                        <option value="1" @if(old('class')=='1') selected @endif>{{__('Class I')}}</option>
                                        <option value="2" @if(old('class')=='2') selected @endif>{{__('Class II')}}</option>
                                        <option value="3" @if(old('class')=='3') selected @endif>{{__('Class III')}}</option>
                                    </select>
                                </div>
                                @error('class')   
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
                                    <i class="material-icons">work</i>`
                                </span>
                                    <div class="form-line">
                                        <select class="form-control designation_dropdown" style="width:100%;" id="designation" name="designation" value="{{ old('designation') }}">
                                        <option value="" @if(old('designation')=='') selected disabled @endif>{{__('Select your designation')}}</option>
                                        @foreach($designations as $designation)
                                        <option value="{{$designation->name}}" {{ old('designation') == $designation->name ? "selected" : ""}}>{{$designation->name}} </option>
                                        @endforeach
                                        </select>
                                    </div>
                                    
                                    @error('designation')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">share</i>
                                </span>
                                <div class="form-line">
                                    <select class="form-control branch_dropdown" id="branch" name="branch" >
                                        <option value="" @if(old('branch')=='') selected disabled @endif>{{__('Select your branch')}}</option>
                                        <option value="Administration" @if(old('branch')=='Administration') selected @endif>{{__('Administration Division')}}</option>
                                        <option value="Accounts" @if(old('branch')=='Accounts') selected @endif>{{__('Accounts Division')}}</option>
                                        <option value="Engineering" @if(old('branch')=='Engineering') selected @endif>{{__('Engineering Division')}}</option>
                                        <option value="Field Branch" @if(old('branch')=='Field Branch') selected @endif>{{__('Field Division')}}</option>
                                        <option value="Internal Audit" @if(old('branch')=='Internal Audit') selected @endif>{{__('Internal Audit Division')}}</option>
                                        <option value="Land" @if(old('branch')=='Land') selected @endif>{{__('Land Division')}}</option>
                                        <option value="NIC Branch" @if(old('branch')=='NIC Branch') selected @endif>{{__('NIC Division')}}</option>
                                        <option value="Planning" @if(old('branch')=='Planning') selected @endif>{{__('Planning Division')}}</option> 
                                        <option value="Registrar" @if(old('branch')=='Registrar') selected @endif>{{__('Registrar Division')}}</option>
                                        <option value="Samurdhy" @if(old('branch')=='Samurdhy') selected @endif>{{__('Samurdhy Division')}}</option>
                                        <option value="Social Service" @if(old('branch')=='Social Service') selected @endif>{{__('Social Service Division')}}</option>
                                        <option value="Rural Development Division" @if(old('branch')=='Rural Development Division') selected @endif>{{__('Rural Development Division')}}</option>
                                        <option value="Business Development Service Division" @if(old('branch')=='Business Development Service Division') selected @endif>{{__('Business Development Service Division')}}</option>
                                        <option value="Agriculture Division" @if(old('branch')=='Agriculture Division') selected @endif>{{__('Agriculture Division')}}</option>
                                        <option value="ICT Division" @if(old('branch')=='ICT Division') selected @endif>{{__('ICT Division')}}</option>
                                        <option value="Women and Child Division" @if(old('branch')=='Women and Child Division') selected @endif>{{__('Women and Child Division')}}</option>
                                        <option value="Vidatha Resource Center" @if(old('branch')=='Vidatha Resource Center') selected @endif>{{__('Vidatha Resource Center')}}</option>
                                        <option value="Multipurpose Development Task Force" @if(old('branch')=='Multipurpose Development Task Force') selected @endif>{{__('Multipurpose Development Task Force')}}</option>
                                        <option value="Grama Niladhari Division" @if(old('branch')=='Grama Niladhari Division') selected @endif>{{__('Grama Niladhari Division')}}</option>
                                        <option value="Productivity Division" @if(old('branch')=='Productivity Division') selected @endif>{{__('Productivity Division')}}</option>

                                        

                                    </select>
                                </div>
                                @error('branch')
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
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{__('Password')}}">
                                </div>
                                @error('password')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{__('Confirm Password')}}">
                                </div>
                                @error('password_confirmation')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                                
                            </div>
                        </div>
                    </div>

                    
                        
                            <div class="form-group">
                                <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                                <label for="terms">{{__('I read and agree to the')}} <a href="#">{{__('terms of usage')}}</a>.</label>
                            
                            @error('terms')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                            @enderror
                            </div>
                
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">{{__('SIGN UP')}}</button>
                    
                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{route('login', app()->getLocale())}}">{{__('You already have a membership?')}}</a>
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
$('.designation_dropdown').select2({
  placeholder: '{{__('Select your designation')}}',
  width: 'resolve'
});

$('.workplace_type_dropdown').select2({
  placeholder: '{{__('Select Your Work Place Type')}}',
  width: 'resolve'
});

$('.workplace_dropdown').select2({
  placeholder: '{{__('Select Your Work Place')}}',
  width: 'resolve'
});

$('.gender_dropdown').select2({
  placeholder: '{{__('Select your Gender')}}',
  width: 'resolve'
});

$('.branch_dropdown').select2({
  placeholder: '{{__('Select your branch')}}',
  width: 'resolve'
});

$('.class_dropdown').select2({
  placeholder: '{{__('Select your service class')}}',
  width: 'resolve'
});

$('.service_dropdown').select2({
  placeholder: '{{__('Select your service')}}',
  width: 'resolve'
});

</script>

<script>
$('#workplace_type').change(function(){
  var workplaceid = $(this).val();  
  if(workplaceid){
    $.ajax({
      type:"GET",
      url:"{{url('en/get-workplaces-list')}}?workplace_type_id="+workplaceid,
      success:function(res){        
      if(res){
        $("#workplace").empty();
        $("#workplace").append('<option>{{__('Select Your Work Place')}}</option>');
        $.each(res,function(key,value){
          $("#workplace").append('<option value="'+key+'">'+value+'</option>');
        });
      
      }else{
        $("#workplace").empty();
      }
      }
    });
  }else{
    $("#workplace").empty();
  }   
  });
</script>

</body>

</html>