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
                    @if(Gate::allows('sys_admin'))
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
                    <li >
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
            <div class="card">
                        <div class="body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px"></th>
                                        <th style="width:20px"></th>
                                        
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
                                        <td>{{$user->workplace}}</td>
                                        
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
                                <a type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" href="{{route('users.edit', [app()->getLocale(), $user->id])}}">
                                    <i class="material-icons">mode_edit</i>
                                    <span>{{__('EDIT DETAILS')}}</span>
                                </a>
                            <br /><br />
                                <form method="POST" action="{{ route('users.destroy', [app()->getLocale(), $user->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-xs waves-effect" onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                                        <i class="material-icons">delete</i>
                                            <span>{{__('DELETE USER')}}</span>
                                    </button>
                                </form>     
                                
                                
                            </div>
                        </div>
                    </div>
        </div>
</section>
@endsection