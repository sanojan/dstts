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
            <a href="{{route('home')}}">DS-<b>TTS</b></a>
            <small>Task Tracking System - District Secretariat, Ampara</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="msg">Register a new membership</div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name with Initial">
                                
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
                                    <option value="" @if(old('gender' )== '') selected disabled @endif>Select your Gender</option>
                                    <option value="Male" @if(old('gender')=='Male') selected @endif>Male</option>
                                    <option value="Female" @if(old('gender')=='Female') selected @endif>Female</option>
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
                                <input placeholder="Date of Birth" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="dob" name="dob" value="{{ old('dob') }}">
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
                                <input type="text" class="form-control" placeholder="NIC NO" name="nic" value="{{ old('nic') }}">
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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
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
                                <input type="text" class="form-control" placeholder="Mobile No" name="mobile_no" value="{{ old('mobile_no') }}">
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
                                        <option value="" @if(old('workplace_type')=='') selected disabled @endif>Work Place Type</option>
                                        @foreach($workplacetypes as $workplacetype)
                                        <option value="{{$workplacetype->id}}" @if(old('workplace_type')=='{{$workplacetype->id}}') selected @endif>{{$workplacetype->name}} </option>
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
                                        <select class="form-control workplace_dropdown" style="width:100%;" id="workplace" name="workplace" value="{{ old('workplace') }}">
                                        <option value="" @if(old('workplace')=='') selected disabled @endif>Work Place</option>
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
                                        <option value="" @if(old('service')=='') selected disabled @endif>Select your service</option>
                                        @foreach($services as $service)
                                        <option value="{{$service->id}}" @if(old('service')=='{{$service->id}}') selected @endif>{{$service->name}} </option>
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
                                        <option value="" @if(old('class')=='') selected disabled @endif>Select your class</option>
                                        <option value="1" @if(old('class')=='1') selected @endif>class1</option>
                                        <option value="2" @if(old('class')=='2') selected @endif>class2</option>
                                        <option value="3" @if(old('class')=='3') selected @endif>class3</option>
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
                                        <option value="" @if(old('designation')=='') selected disabled @endif>Select your designation</option>
                                        @foreach($designations as $designation)
                                        <option value="{{$designation->id}}" @if(old('designation')=='{{$designation->id}}') selected @endif>{{$designation->name}} </option>
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
                                        <option value="" @if(old('branch')=='') selected disabled @endif>Select your branch</option>
                                        <option value="Administration" @if(old('branch')=='Administration') selected @endif>Administration</option>
                                        <option value="Accounts" @if(old('branch')=='Accounts') selected @endif>Accounts</option>
                                        <option value="Engineering" @if(old('branch')=='Engineering') selected @endif>Engineering</option>
                                        <option value="Field Branch" @if(old('branch')=='Field Branch') selected @endif>Field Branch</option>
                                        <option value="Internal Audit" @if(old('branch')=='Internal Audit') selected @endif>Internal Audit</option>
                                        <option value="Land" @if(old('branch')=='Land') selected @endif>Land</option>
                                        <option value="NIC Branch" @if(old('branch')=='NIC Branch') selected @endif>NIC Branch</option>
                                        <option value="Planning" @if(old('branch')=='Planning') selected @endif>Planning</option> 
                                        <option value="Registrar" @if(old('branch')=='Registrar') selected @endif>Registrar</option>
                                        <option value="Samurdhy" @if(old('branch')=='Samurdhy') selected @endif>Samurdhy</option>
                                        <option value="Social Service" @if(old('branch')=='Social Service') selected @endif>Social Service</option>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
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
                                <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
                            
                            @error('terms')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                            @enderror
                            </div>
                
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>
                    
                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{route('login')}}">You already have a membership?</a>
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
  placeholder: 'Select Designation',
  width: 'resolve'
});

$('.workplace_type_dropdown').select2({
  placeholder: 'Select Work Place Type',
  width: 'resolve'
});

$('.workplace_dropdown').select2({
  placeholder: 'Select Work Place',
  width: 'resolve'
});

$('.gender_dropdown').select2({
  placeholder: 'Select Gender',
  width: 'resolve'
});

$('.branch_dropdown').select2({
  placeholder: 'Select Branch',
  width: 'resolve'
});

$('.class_dropdown').select2({
  placeholder: 'Select Class',
  width: 'resolve'
});

$('.service_dropdown').select2({
  placeholder: 'Select Service',
  width: 'resolve'
});

</script>

<script>
    $('#workplace_type').change(function(){
  var workplaceid = $(this).val();  
  if(workplaceid){
    $.ajax({
      type:"GET",
      url:"{{url('get-workplaces-list')}}?workplace_type_id="+workplaceid,
      success:function(res){        
      if(res){
        $("#workplace").empty();
        $("#workplace").append('<option>Select Work Place</option>');
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