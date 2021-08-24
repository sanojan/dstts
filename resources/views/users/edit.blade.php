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
                            <i class="material-icons">folder</i>
                            <span>{{__('Files')}}</span>
                            
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="{{route('files.index', app()->getLocale())}}">{{__('View File(s)')}}</a>
                                    </li>
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('branch_head'))
                                    <li >
                                        <a href="{{route('files.create', app()->getLocale())}}">{{__('Create File')}}</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    
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
                            
                            <li >
                                <a href="{{route('travelpasses.create', app()->getLocale())}}">{{__('Add New Request')}}</a>
                            </li>    
                        </ul>
                    </li>
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
                <h2>{{__('EDIT USER')}}</h2>
            </div>
            <div class="card">
                
                <div class="body">
                    <form action="{{ route('users.update', [app()->getLocale() , $user->id])}}" method="POST" enctype="multipart/form-data" id="user_add_form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }} 
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="name" type="text" class="form-control " name="name" value="{{ $user->name }}" required autocomplete="name" autofocus >
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
                                    <select class="form-control gender_dropdown" id="gender" name="gender" value="{{ old('gender') }}">
                                    <option value="" @if(old('gender' )== '') selected disabled @endif>{{_('Select your Gender')}}</option>
                                    <option value="Male" @if(old('gender')== 'Male') selected @elseif($user->gender=='Male') selected @endif>Male</option>
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
                                    <input class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="dob" name="dob" value="{{ $user->dob }}">
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
                                    <input type="text" class="form-control" name="nic" value="{{ $user->nic }}">
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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" >
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
                                    <input type="text" class="form-control" name="mobile_no" value="{{ $user->mobile_no }}">
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control workplace_dropdown" style="width:100%;" id="workplace" name="workplace">
                                        @if(old('workplace'))
                                        <option value="{{ old('workplace') }}" selected>{{ old('workplace')}}</option>
                                        @else
                                        <option value="{{$user->workplace->id}}" >{{$user->workplace->name}}</option>
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
                                        <option value="{{$service->name}}" @if(old('service' )== '{{$service->name}}') selected @elseif($service->name==$user->service) selected @endif>{{$service->name}} </option>
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
                                        <option value="" @if(old('class')== '') selected @elseif($user->class=='') selected @endif>Select the service class</option>
                                        <option value="1" @if(old('class')=='1') selected @elseif($user->class=='1') selected @endif>{{__('Class I')}}</option>
                                        <option value="2" @if(old('class' )== '2') selected @elseif($user->class=='2') selected @endif>{{__('Class II')}}</option>
                                        <option value="3" @if(old('class' )== '3') selected @elseif($user->class=='3') selected @endif>{{__('Class III')}}</option>
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
                                        <select class="form-control designation_dropdown" style="width:100%;" id="designation" name="designation" >
                                        <option value="" @if(old('designation')== '') selected @elseif($user->designation=='') selected @endif>{{__('Select the Designation')}}</option>
                                        @foreach($designations as $designation)
                                        <option value="{{$designation->name}}" @if(old('designation')== '{{$designation->name}}') selected @elseif($user->designation==$designation->name) selected @endif>{{$designation->name}} </option>
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
                                        <option value="" @if(old('branch')== '') selected @elseif($user->branch=='') selected @endif>{{__('Select the branch')}}</option>
                                        <option value="Administration"@if(old('branch')== 'Administration') selected @elseif($user->branch=='Administration') selected @endif>{{__('Administration Division')}}</option>
                                        <option value="Accounts" @if(old('branch')== 'Accounts') selected @elseif($user->branch=='Accounts') selected @endif>{{__('Accounts Division')}}</option>
                                        <option value="Engineering" @if(old('branch')== 'Engineering') selected @elseif($user->branch=='Engineering') selected @endif>{{__('Engineering Division')}}</option>
                                        <option value="Field Branch" @if(old('branch')== 'Field Branch') selected @elseif($user->branch=='Field Branch') selected @endif>{{__('Field Division')}}</option>
                                        <option value="Internal Audit" @if(old('branch')== 'Internal Audit') selected @elseif($user->branch=='Internal Audit') selected @endif>{{__('Internal Audit Division')}}</option>
                                        <option value="Land" @if(old('branch')== 'Land') selected @elseif($user->branch=='Land') selected @endif>{{__('Land Division')}}</option>
                                        <option value="NIC Branch" @if(old('branch')== 'NIC Branch') selected @elseif($user->branch=='NIC Branch') selected @endif>{{__('NIC Division')}}</option>
                                        <option value="Planning" @if(old('branch')== 'Planning') selected @elseif($user->branch=='Planning') selected @endif>{{__('Planning Division')}}</option> 
                                        <option value="Registrar" @if(old('branch')== 'Registrar') selected @elseif($user->branch=='Registrar') selected @endif>{{__('Registrar Division')}}</option>
                                        <option value="Samurdhy" @if(old('branch')== 'Samurdhy') selected @elseif($user->branch=='Samurdhy') selected @endif>{{__('Samurdhy Division')}}</option>
                                        <option value="Social Service" @if(old('branch')== 'Social Service') selected @elseif($user->branch=='Social Service') selected @endif>{{__('Social Service Division')}}</option>

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

                        
                        
                        
                        <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect" style="margin-right:10px">Create</button> -->
                        <button type="submit" class="btn btn-warning waves-effect" style="margin-right:10px" name="user_details_button" value="edit_user">
                            <i class="material-icons">note_add</i>
                            <span>{{__('UPDATE')}}</span>
                        </button>
                        
                    </form>
                </div>
            </div>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
</section>



@endsection

