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
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name_w_init" placeholder="Name with Initial" required autofocus>
                                </div>
                            </div> 
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">people</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">event</i>
                                </span>
                                <div class="form-line">
                                    <input type="date" class="form-control" name="dob" placeholder="Date of birth" required>
                                </div>
                            </div> 
                        </div>

                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">card_membership</i>
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="NIC NO" name="nic" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="E-Mail Address" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">phone_iphone</i>`
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="Mobile No" name="mobile_no">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">work</i>
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="Designation" name="designation" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">business_center</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control" id="service" name="service" required>
                                    <option value="">Select your Service </option>
                                    <option value="service2">Service 2</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">people_outline</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control" id="exampleFormControlSelect1" name="class" required>
                                    <option value="">Select your class</option>
                                    <option value="class2">Class1</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">location_city</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control" id="workplace_type" name="workplace_type" required>
                                    <option value="">Work Place Type</option>
                                    <option value="work1">work1</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">location_city</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control" id="workplace" name="workplace" required>
                                    <option value="">Work Place Name</option>
                                    <option value="work2">place1</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">share</i>
                                </span>
                                <div class="form-line">
                                <select class="form-control" id="branch" name="branch">
                                    <option value="">Select Branch</option>
                                    <option value="branch1">Test branch</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">insert_drive_file</i>
                                </span>
                                <div class="form-line">
                                <input type="text" class="form-control" placeholder="Subject" name="subject">
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">supervisor_account</i>
                                    </span>
                                    <div class="form-line">
                                    <select class="form-control" id="user_type" name="user_type" required>
                                        <option value="">User Type</option>
                                        <option value="standard">Standard</option>
                                    </select>
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password" minlength="6" placeholder="Confirm Password" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    
                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                        <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
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
</body>

</html>