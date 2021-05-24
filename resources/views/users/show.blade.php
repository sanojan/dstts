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
                                        @elseif($user->user_type == "admin")
                                            <td>Admin</td>
                                        @elseif($user->user_type == "div_sec")
                                            <td>Divisional Secretary</td>
                                        @elseif($user->user_type == "branch_head")
                                            <td>Branch Head</td>
                                        @elseif($user->user_type == "user")
                                            <td>Standard User</td>
                                        @endif
                                        
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
                                    @if(Gate::allows('sys_admin'))
                                    <a type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#changeAccountType" aria-expanded="false" aria-controls="changeAccountType">
                                        <i class="material-icons">add_to_photos</i>
                                        <span>{{__('CHANGE ACCOUNT TYPE')}}</span>
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
                                                                @if($user->user_type == "sys_admin")
                                                                <option value="{{$user->user_type}}" selected disabled>System Admin</option>
                                                                @else
                                                                <option value="sys_admin">System Admin</option>
                                                                @endif

                                                                @if($user->user_type == "branch_head")
                                                                <option value="{{$user->user_type}}" selected disabled>Branch Head</option>
                                                                @else
                                                                <option value="branch_head">Branch Head</option>
                                                                @endif

                                                                @if($user->user_type == "admin")
                                                                <option value="{{$user->user_type}}" selected disabled>Admin</option>
                                                                @else
                                                                <option value="admin">Admin</option>
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