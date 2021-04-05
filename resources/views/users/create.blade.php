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
                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>{{__('Letters')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="{{route('letters.index', app()->getLocale())}}">{{__('View Letter')}}</a>
                                    </li>
                                    <li >
                                        <a href="{{route('letters.create', app()->getLocale())}}">{{__('Add Letter')}}</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    
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
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
                                    <li >
                                        <a href="{{route('tasks.create', app()->getLocale())}}">{{__('Assign Task')}}</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
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
                    
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">group</i>
                            <span>{{__('Users')}}</span>
                        </a>
                        @if(Gate::allows('sys_admin'))
                        <ul class="ml-menu">
                                    
                                    <li>
                                        <a href="{{route('users.create', app()->getLocale())}}">Create User</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
                                    </li>
                        </ul>
                        @endif
                    </li>
                   
                    @if(Gate::allows('sys_admin'))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>{{__('System Data')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="pages/widgets/cards/basic.html">Designation</a>
                                    </li>
                                    <li>
                                        <a href="pages/widgets/cards/colored.html">Work Place</a>
                                    </li>
                                    <li>
                                        <a href="pages/widgets/cards/colored.html">Services</a>
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
                        <a href="#">
                            <i class="material-icons">group</i>
                            <span>{{__('About Us')}}</span>
                        </a>
                    </li>
                    <li >
                        <a href="#">
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
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control workplace_type_dropdown" style="width:100%;" id="workplace_type" onchange="getworkplace();" name="workplace_type" value="{{ old('workplace_type') }}">
                                        <option value="" @if(old('workplace_type')=='') selected disabled @endif >Select the Work Place Type</option>
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control workplace_dropdown" style="width:100%;" id="workplace" name="workplace">
                                        @if(old('workplace'))
                                        <option value="{{ old('workplace') }}" selected>{{ old('workplace')}}</option>
                                        @else
                                        <option value="" selected></option>
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
                                        <option value="" @if(old('branch')=='') selected disabled @endif>{{__('Select the branch')}}</option>
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
                                        <option value="user" @if(old('user_type')=='user') selected @endif >{{__('Normal User')}}</option>
                                        <option value="branch_head" @if(old('user_type')=='branch_head') selected @endif >{{__('Branch Head')}}</option>
                                        <option value="div_sec" @if(old('user_type')=='div_sec') selected @endif >{{__('Divisional Secretary')}}</option>
                                        <option value="admin" @if(old('user_type')=='admin') selected @endif >{{__('Admin')}}</option>
                                        <option value="sys_admin" @if(old('user_type')=='sys_admin') selected @endif >{{__('System Admin')}}</option>
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
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    
                                    <label class="form-label"></label> 
                                    </div>
                                    @error('')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                   
                                        <label class="form-label"></label>
                                    </div>
                                    @error('')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
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

</section>

<script>
    function getworkplace(){
       
        workplaceid1 = document.getElementById('workplace_type');
  var workplaceid =workplaceid1.value;  
  if(workplaceid){
    
    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.timeout = 1800;
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('workplace').innerHTML=this.responseText;
            }
            else{
                document.getElementById('workplace').innerHTML="<option value='' disabled >{{__('Select Your Work Place')}}</option>";
            }
        };
        xmlhttp.open("GET","{{url('app()->getLocale()/getWorkplaces')}}?wplaceid="+workplaceid,true);
        xmlhttp.send();   
  }
    }
</script>

@endsection

