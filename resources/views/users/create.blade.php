@extends('inc.layout')

@section('sidebar')
         
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">{{__('MAIN NAVIGATION')}}</li>
                    <li >
                        <a href="{{route('home', app()->getLocale())}}">
                            <i class="material-icons">dashboard</i>
                            <span>{{__('Dashboard')}}</span>
                        </a>
                    </li>
                    @if(count(Auth::user()->subjects) > 0)
                        @foreach(Auth::user()->subjects as $subject)
                            @if($subject->subject_code == "letters")
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">email</i>
                                        <span>{{__('Letters')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                                <li>
                                                    <a href="{{route('letters.index', app()->getLocale())}}">{{__('View Letter')}}</a>
                                                </li>
                                                @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('user'))
                                                <li >
                                                    <a href="{{route('letters.create', app()->getLocale())}}">{{__('Add Letter')}}</a>
                                                </li>
                                                @endif
                                    </ul>
                                </li>
                            @endif
                        

                            @if($subject->subject_code == "files")
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">folder</i>
                                        <span>{{__('Files')}}</span>
                                        
                                    </a>
                                    <ul class="ml-menu">
                                        
                                                <li>
                                                    <a href="{{route('files.index', app()->getLocale())}}">{{__('View File(s)')}}</a>
                                                </li>
                                                @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head'))
                                                <li >
                                                    <a href="{{route('files.create', app()->getLocale())}}">{{__('Create File')}}</a>
                                                </li>
                                                @endif
                                            
                                    </ul>
                                </li>
                            @endif

                            @if($subject->subject_code == "tasks")
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">playlist_add_check</i>
                                        <span>{{__('Tasks')}}</span>
                                        @if($new_tasks > 0)
                                        <span class="badge bg-red">{{$new_tasks}} {{__('New')}}</span>
                                        @endif
                                    </a>
                                    <ul class="ml-menu">
                                        
                                                <li>
                                                    <a href="{{route('tasks.index', app()->getLocale())}}">{{__('View Task(s)')}}</a>
                                                </li>
                                                
                                                @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin'))
                                                <li >
                                                    <a href="{{route('tasks.create', app()->getLocale())}}">{{__('Assign Task')}}</a>
                                                </li>
                                                @endif
                                            
                                    </ul>
                                </li>
                            @endif

                            @if($subject->subject_code == "complaints")
                                <li class="">
                                    <a href="{{route('complaints.index', app()->getLocale())}}">
                                        <i class="material-icons">warning</i>
                                        <span>{{__('Complaints')}}</span>
                                        @if($new_complaints > 0)
                                        <span class="badge bg-red">{{$new_complaints}} {{__('New')}}</span>
                                        @endif
                                    </a>
                                </li>
                                
                            @endif

                            @if($subject->subject_code == "travelpass")
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">transfer_within_a_station</i>
                                        <span>{{__('Travel Pass')}}</span>
                                        @if(Gate::allows('admin'))
                                        @if($new_travelpasses > 0)
                                        <span class="badge bg-red">{{$new_travelpasses}} {{__('New')}}</span>
                                        @endif
                                        @elseif(Gate::allows('user'))
                                        @if($new_approved_travelpasses > 0)
                                        <span class="badge bg-red">{{$new_approved_travelpasses}} {{__('New')}}</span>
                                        @endif
                                        @endif
                                    </a>
                                    <ul class="ml-menu">
                                        <li>
                                            <a href="{{route('travelpasses.index', app()->getLocale())}}">{{__('View Travel Pass Entries')}}</a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{route('travelpasses.create', app()->getLocale())}}">{{__('Add New Request')}}</a>
                                        </li>    

                                        <li>
                                            <a href="{{route('sellers.index', app()->getLocale())}}">{{__('View Wholesale Sellers List')}}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if($subject->subject_code == "users")
                                <li class="active">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">group</i>
                                        <span>{{__('Users')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                        
                                        <li  class="active">
                                            <a href="{{route('users.create', app()->getLocale())}}">Create User</a>
                                        </li>
                                       
                                        
                                        <li>
                                            <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
                                        </li>
                                       
                                    </ul>
                                </li>
                            @endif
                            @if($subject->subject_code == "fuel")
                                <li class="">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">local_gas_station</i>
                                        <span>{{__('Fuel Supply')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin'))
                                            <li>
                                                <a href="{{route('vehicles.index', app()->getLocale())}}">Vehicles List</a>
                                            </li>
                                            <li>
                                                <a href="{{route('fuelstations.index', app()->getLocale())}}">Fuel Sheds List</a>
                                            </li>
                                        @endif
                                            <li>
                                                <a href="#">Duty Schedule</a>
                                            </li>
                                
                                    </ul>
                                </li>
                            @endif
                    @endforeach 
                    @endif
                    
                   
                    @if(Gate::allows('sys_admin'))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>{{__('System Data')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="#">Designation</a>
                                    </li>
                                    <li>
                                        <a href="#">Work Place</a>
                                    </li>
                                    <li>
                                        <a href="#">Services</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="#">
                            <i class="material-icons">help</i>
                            <span>{{__('Help')}}</span>
                        </a>
                    </li>
                    <li >
                        <a href="{{route('about', app()->getLocale())}}">
                            <i class="material-icons">group</i>
                            <span>{{__('About Us')}}</span>
                        </a>
                    </li>
                    <li >
                        <a href="{{route('contact', app()->getLocale())}}">
                            <i class="material-icons">contact_phone</i>
                            <span>{{__('Contact Us')}}</span>
                        </a>
                    </li>
                    
                </ul>
            </div>
@endsection

@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>{{__('CREATE USER')}}</h2>
            </div>
            <div class="card">
                
                <div class="body">
                    <form action="{{ route('users.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="user_add_form">
                    @csrf
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus >
                                        <label class="form-label">{{__('Name with Initial')}}</label>
                                    </div>
                                    @error('name')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control gender_dropdown" id="gender" name="gender">
                                        <option value="" @if(old('gender' )== '') selected disabled @endif>{{_('Select the Gender')}}</option>
                                        <option value="Male" @if(old('gender')=='Male') selected @endif>{{__('Male')}}</option>
                                        <option value="Female" @if(old('gender')=='Female') selected @endif>{{__('Female')}}</option>
                                    </select>
                                    <label class="form-label">{{__('Select the Gender')}}</label> 
                                    </div>
                                    @error('gender')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="dob" name="dob" value="{{ old('dob') }}">
                                        <label class="form-label">{{__('Date of Birth')}}</label>
                                    </div>
                                    @error('dob')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>   
                        </div>
                        
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" name="nic" value="{{ old('nic') }}">
                                        <label class="form-label">{{__('NIC NO')}}</label>
                                    </div>
                                    @error('nic')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >
                                    <label class="form-label">{{__('Email Address')}}</label> 
                                    </div>
                                    @error('email')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" name="mobile_no" value="{{ old('mobile_no') }}">
                                        <label class="form-label">{{__('Mobile No')}}</label>
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
                            <div class="col-md-4">
                            @if(Gate::allows('sys_admin'))
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control" style="width:100%;" id="workplace_type" name="workplace_type" value="{{ old('workplace_type') }}">
                                        <option value="" @if(old('workplace_type')=='') selected disabled @endif>Select Your Work Place Type</option>
                                        @foreach($workplacetypes as $workplacetype)
                                        <option value="{{$workplacetype->id}}" {{ old('workplace_type') == $workplacetype->id ? "selected" :""}}>{{$workplacetype->name}} </option>
                                        @endforeach
                                        </select>
                                        <label class="form-label">{{__('Select the Work Place Type')}}</label>
                                    </div>
                                    @error('workplace_type')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            @endif
                            </div>

                            <div class="col-md-4">

                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control" style="width:100%;" id="workplace" name="workplace">
                                        @if(old('workplace'))

                                        @php
                                        $workplace = \App\Workplace::find(old('workplace'));
                                        @endphp
                                        <option value="{{ old('workplace') }}" selected>{{ $workplace->name}}</option>
                                        @else
                                        <option value=""></option>
                                        @endif
                                        @if(Gate::denies('sys_admin'))
                                            <option value="{{Auth::user()->workplace->id}}" selected>{{Auth::user()->workplace->name}}</option>
                                        @endif
                                        </select>
                                    <label class="form-label">{{__('Select the workplace')}}</label> 
                                    </div>
                                    @error('workplace')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control service_dropdown" id="service" name="service" >
                                        <option value="" @if(old('service')=='') selected disabled @endif>{{__('Select the service')}}</option>
                                        @foreach($services as $service)
                                        <option value="{{$service->name}}" {{ old('service') == $service->name ? "selected" : ""}}>{{$service->name}} </option>
                                        @endforeach
                                    </select>
                                        <label class="form-label">{{__('Select the service')}}</label>
                                    </div>
                                    @error('service')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>   
                        </div>

                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control class_dropdown" id="class" name="class" >
                                        <option value="" @if(old('class')=='') selected disabled @endif>Select the service class</option>
                                        <option value="1" @if(old('class')=='1') selected @endif>{{__('Class I')}}</option>
                                        <option value="2" @if(old('class')=='2') selected @endif>{{__('Class II')}}</option>
                                        <option value="3" @if(old('class')=='3') selected @endif>{{__('Class III')}}</option>
                                    </select>
                                        <label class="form-label">{{__('Select the Service Class')}}</label>
                                    </div>
                                    @error('class')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control designation_dropdown" style="width:100%;" id="designation" name="designation" value="{{ old('designation') }}">
                                        <option value="" @if(old('designation')=='') selected disabled @endif>{{__('Select the Designation')}}</option>
                                        @foreach($designations as $designation)
                                        <option value="{{$designation->name}}" {{ old('designation') == $designation->name ? "selected" : ""}}>{{$designation->name}} </option>
                                        @endforeach
                                        </select>
                                    <label class="form-label">{{__('Select the Designation')}}</label> 
                                    </div>
                                    @error('designation')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
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
                                        <label class="form-label">{{__('Select the Branch')}}</label>
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
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <label class="form-label">{{__('Password')}}</label>
                                    </div>
                                    @error('password')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" >
                                    <label class="form-label">{{__('Confirm Password')}}</label> 
                                    </div>
                                    @error('password_confirmation')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control service_dropdown" id="user_type" name="user_type" >
                                        <option value="" @if(old('user_type')=='') selected disabled @endif>{{__('Select User Type')}}</option>
                                        <option value="user" @if(old('user_type')=='user') selected @endif >{{__('User')}}</option>
                                        <option value="branch_head" @if(old('user_type')=='branch_head') selected @endif >{{__('Branch Head')}}</option>
                                        <option value="divi_admin" @if(old('user_type')=='divi_admin') selected @endif >{{__('Division Admin')}}</option>
                                        @if(Gate::allows('sys_admin'))
                                        <option value="dist_admin" @if(old('user_type')=='dist_admin') selected @endif >{{__('District Admin')}}</option>
                                        <option value="sys_admin" @if(old('user_type')=='sys_admin') selected @endif >{{__('System Admin')}}</option>
                                        @endif
                                    </select>
                                        <label class="form-label">{{__('Select User Type')}}</label>
                                    </div>
                                    @error('user_type')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>   
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <div class="form-line">
                                    <select class="form-control service_dropdown" id="account_status" name="account_status" >
                                        <option value="0" @if(old('account_status')=='0') selected @endif>{{__('Disable')}}</option>
                                        <option value="1" @if(old('account_status')=='1') selected @endif >{{__('Enable')}}</option>
                                    </select>
                                    </div>
                                        <label class="form-label">{{__('Select Account Status')}}</label>
                                    </div>
                                    @error('user_type')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                            
                            </div> 
                            <div class="col-md-4">
                                
                            </div>   
                        </div>
                        
                        <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect" style="margin-right:10px">Create</button> -->
                        <button type="submit" class="btn btn-primary waves-effect" style="margin-right:10px">
                            <i class="material-icons">note_add</i>
                            <span>{{__('CREATE')}}</span>
                        </button>
                        
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
    $('#workplace_type').change(function(){
        var workplaceid = $(this).val();  
        if(workplaceid){
            $.ajax({
            type:"GET",
            url:"{{url('app()->getLocale()/get-workplaces-list')}}?workplace_type_id="+workplaceid,
            success:function(res){        
            if(res){
                $("#workplace").empty();
                $("#workplace").append('<option disabled selected>{{__('Select Your Work Place')}}</option>');
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
</section>



@endsection

