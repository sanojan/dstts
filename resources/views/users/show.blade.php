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
                        @php $userSubject = false; @endphp
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
                                        
                                        <li>
                                            <a href="{{route('users.create', app()->getLocale())}}">Create User</a>
                                        </li>
                                        <li class="active">
                                            <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
                                        </li>
                                        
                                    </ul>
                                </li>  
                                @php $userSubject = true; @endphp
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

                        @if(!$userSubject)

                            <li class="active">
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">group</i>
                                    <span>{{__('Users')}}</span>
                                </a>
                                <ul class="ml-menu">
                            
                                    <li class="active">
                                        <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
                                    </li>
                                    
                                </ul>
                            </li>  
                                    
                        @endif
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
                <h2>{{__('USER DETAILS')}}</h2>
            </div>
            @if(session()->has('message'))
                <div class="alert alert-{{session()->get('alert-type')}}">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                        <div class="body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th ></th>
                                        <th ></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('User Name.')}}:</td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Gender')}}:</td>
                                        <td>{{$user->gender}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Date Of Birth')}}:</td>
                                        <td>{{$user->dob}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('NIC No.')}}:</td>
                                        <td>{{$user->nic}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Email Address')}}:</td>
                                        <td>{{$user->email}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Mobile No.')}}:</td>
                                        <td>{{$user->mobile_no}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Designation')}}:</td>
                                        <td>{{$user->designation}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Service')}}:</td>
                                        <td>{{$user->service}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Class')}}:</td>
                                        <td>{{$user->class}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Work Place')}}:</td>
                                        <td>{{$user->workplace->name}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Branch')}}:</td>
                                        <td>{{$user->branch}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('User Type')}}:</td>
                                        @if($user->user_type == "sys_admin")
                                        <td>System Admin</td>
                                        @elseif($user->user_type == "dist_admin")
                                            <td>District Admin</td>
                                        @elseif($user->user_type == "divi_admin")
                                            <td>Division Admin</td>
                                        @elseif($user->user_type == "branch_head")
                                            <td>Branch Head</td>
                                        @elseif($user->user_type == "user")
                                            <td>Standard User</td>
                                        @endif
                                        
                                    </tr>
                                    <tr>
                                        <td>Assigned Subjects:</td>
                                        <td>
                                            @foreach($user->subjects as $subject)
                                                <span class="label label-primary">{{$subject->subject_name}}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Account Created On')}}:</td>
                                        <td>{{$user->created_at}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Account Status')}}:</td>
                                        @if($user->account_status)
                                            <td class="font-bold col-green">ENABLED</td>
                                        @else
                                            <td class="font-bold col-red">DISABLED</td>
                                        @endif
                                    
                                        
                                    </tr>
                                </tbody>    
                            </table>
                            <div>
                            
                              
                            <form action="{{ route('users.update', [app()->getLocale(), $user->id] )}}" method="POST" enctype="multipart/form-data" id="user_type_form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                    <a type="button" style="margin-right:10px" class="btn bg-purple btn-xs waves-effect" href="{{route('users.edit', [app()->getLocale(), $user->id])}}">
                                        <i class="material-icons">mode_edit</i>
                                        <span>{{__('EDIT DETAILS')}}</span>
                                    </a>
                                    @if(Auth::user()->id == $user->id)
                                    <a type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#changePassword" aria-expanded="false" aria-controls="changeAccountType">
                                        <i class="material-icons">add_to_photos</i>
                                        <span>{{__('CHANGE PASSWORD')}}</span>
                                    </a>
                                    @endif
                                    @php 
                                    $user_subjects[] = "";
                                    foreach(Auth::user()->subjects as $key => $subject){
                                        $user_subjects[$key] = $subject->subject_code; 
                                    }
                                    @endphp
                                    @if(Gate::allows('sys_admin') || in_array("users", $user_subjects))
                                    <a type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#changeAccountType" aria-expanded="false" aria-controls="changeAccountType">
                                        <i class="material-icons">add_to_photos</i>
                                        <span>{{__('CHANGE ACCOUNT TYPE')}}</span>
                                    </a>

                                    <a type="button" style="margin-right:10px" class="btn bg-indigo btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#modifySubjects" aria-expanded="false" aria-controls="modifySubjects">
                                        <i class="material-icons">note_add</i>
                                        <span>{{__('MODIFY SUBJECTS')}}</span>
                                    </a>
                                    
                                    @if($user->account_status)
                                    <button type="submit" style="margin-right:10px" class="btn bg-red btn-xs waves-effect" name="user_status_button" value="disable_user">
                                        <i class="material-icons">close</i>
                                        <span>
                                            {{__('DISABLE USER')}}
                                        </span>
                                    </button>
                                    @else
                                    <button type="submit" style="margin-right:10px" class="btn bg-green btn-xs waves-effect" name="user_status_button" value="enable_user">
                                        <i class="material-icons">check</i>
                                        <span>
                                            {{__('ENABLE USER')}}
                                        </span>
                                    </button>
                                    @endif
                                    @endif
                                    @if(Gate::allows('sys_admin'))
                                    <button type="submit" style="margin-right:10px" class="btn bg-blue-grey btn-xs waves-effect" name="reset_password_button" value="reset_password" onclick="return confirm('{{__('This will reset the password to 11111111. Do you want to continue?.')}}')">
                                        <i class="material-icons">settings_backup_restore</i>
                                        <span>
                                            {{__('RESET PASSWORD')}}
                                        </span>
                                    </button>
                                    @endif
                            </form>
                                    
                                   
                                
                                
                                <br /><br />
                                @if(Gate::allows('sys_admin'))
                                    
                                <form method="POST" action="{{ route('users.destroy', [app()->getLocale(), $user->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-xs waves-effect" onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                                        <i class="material-icons">delete</i>
                                            <span>{{__('DELETE USER')}}</span>
                                    </button>
                                </form>    
                                @endif 
                                <br />

                                
                                <div class="collapse" id="changeAccountType" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('users.update', [app()->getLocale(), $user->id] )}}" method="POST" enctype="multipart/form-data" id="user_type_form">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th style="width:200px"></th>
                                                            <th style="width:200px"></th>
                                                            <th style="width:50px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                            <label class="form-label">{{__('Select the User Type')}}</label>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" style="width:100%;" id="user_type" name="user_type">
                                                                @if(Gate::allows('sys_admin'))
                                                                
                                                                @if($user->user_type == "sys_admin")
                                                                <option value="{{$user->user_type}}" selected disabled>System Admin</option>
                                                                @else
                                                                <option value="sys_admin">System Admin</option>
                                                                @endif

                                                                @if($user->user_type == "dist_admin")
                                                                <option value="{{$user->user_type}}" selected disabled>District Admin</option>
                                                                @else
                                                                <option value="dist_admin">District Admin</option>
                                                                @endif

                                                                @endif

                                                                @if($user->user_type == "divi_admin")
                                                                <option value="{{$user->user_type}}" selected disabled>Division Admin</option>
                                                                @else
                                                                <option value="divi_admin">Division Admin</option>
                                                                @endif

                                                                @if($user->user_type == "branch_head")
                                                                <option value="{{$user->user_type}}" selected disabled>Branch Head</option>
                                                                @else
                                                                <option value="branch_head">Branch Head</option>
                                                                @endif

                                                                @if($user->user_type == "user")
                                                                <option value="{{$user->user_type}}" selected disabled>Standard User</option>
                                                                @else
                                                                <option value="user">Standard User</option>
                                                                @endif 
                                                                </select>
                                                                
                                                                    
                                                            </td>  <td></td>     
                                                            <td>
                                                                <button type="submit" style="margin-right:10px" name="user_type_button" value="change_user_type" class="btn bg-green btn-xs waves-effect" >
                                                                <i class="material-icons">check</i>
                                                                <span>{{__('SUBMIT')}}</span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse" id="modifySubjects" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('users.update', [app()->getLocale(), $user->id] )}}" method="POST" enctype="multipart/form-data" id="user_subject_form">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th style="width:200px"></th>
                                                            <th style="width:200px"></th>
                                                            <th style="width:50px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                            <label class="form-label">{{__('Select the Subjects to Add')}}</label>
                                                            </td>
                                                            <td>
                                                                
                                                            <select class="form-control subjects_dropdown" style="width:100%;" id="subjects" name="subjects[]" multiple="multiple">
                                                                @if(Gate::allows('sys_admin'))
                                                                    <option value="users">Users</option>
                                                                    <option value="letters">Letters</option>
                                                                    <option value="tasks" >Tasks</option>
                                                                    <option value="files">Files</option>
                                                                    <option value="complaints">Complaints</option>
                                                                @endif
                                                                    <option value="travelpass" >Travel Pass</option>
                                                                    <option value="fuel">Fuel Supply</option>
                                                            </select>
                                                                    
                                                            </td>  
                                                            <td></td>     
                                                            <td>
                                                                <button type="submit" style="margin-right:10px" name="subject_button" value="add_subject" class="btn bg-green btn-xs waves-effect" >
                                                                <i class="material-icons">check</i>
                                                                <span>{{__('ADD')}}</span>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button type="submit" style="margin-right:10px" name="subject_button" value="remove_subject" class="btn bg-red btn-xs waves-effect" >
                                                                <i class="material-icons">check</i>
                                                                <span>{{__('REMOVE')}}</span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse" id="changePassword" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('change.password', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="change_password_form">
                                            @csrf 
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th style="width:200px"></th>
                                                            <th style="width:200px"></th>
                                                            <th style="width:50px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                            <label class="form-label">{{__('Enter Current Password')}}</label>
                                                            </td>
                                                            <td><input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                                                            @error('current_password')
                                                            <label class="error" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </label>
                                                            @enderror
                                                            </td> 
                                                            </tr>
                                                            <tr style="height:80px">
                                                            <td><label class="form-label">{{__('Enter New Password')}}</label></td>
                                                            <td><input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                                                            @error('new_password')
                                                            <label class="error" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </label>
                                                            @enderror
                                                            </td>    
                                                            </tr>
                                                            <tr>
                                                            <td><label class="form-label">{{__('Re-enter New Password')}}</label></td>
                                                            <td><input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                                                            @error('new_confirm_password')
                                                            <label class="error" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </label>
                                                            @enderror
                                                            </td>
                                                            </tr>
                                                            <tr style="height:80px">
                                                            <td></td>
                                                            <td>
                                                                <button type="submit" style="margin-right:10px" name="change_password_button" value="change_password" class="btn bg-green btn-xs waves-effect" >
                                                                <i class="material-icons">check</i>
                                                                <span>{{__('SUBMIT')}}</span>
                                                                </button>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
        </div>
        
</section>
@endsection