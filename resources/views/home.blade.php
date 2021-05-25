@extends('inc.layout')

@section('sidebar')
         
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">{{__('MAIN NAVIGATION')}}</li>
                    <li class="active">
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
                    <li class="">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">transfer_within_a_station</i>
                            <span>{{__('Travel Pass')}}</span>
                            @if(Gate::allows('sys_admin') || Gate::allows('admin'))
                            @if($new_travelpasses > 0)
                            <span class="badge bg-red">{{$new_travelpasses}} {{__('New')}}</span>
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
                    @if(Gate::allows('sys_admin'))
                    <li class="">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">group</i>
                            <span>{{__('Users')}}</span>
                        </a>
                        <ul class="ml-menu">
                                    
                            <li>
                                <a href="{{route('users.create', app()->getLocale())}}">Create User</a>
                            </li>
                            <li class="">
                                <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
                            </li>
                        </ul>
                    </li>
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
            <h2>{{__('DASHBOARD')}}</h2>
            </div>
           
            
            
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">new_releases</i>
                    </div>
                    <div class="content">
                        <div class="text">{{__('NEW TASKS')}}</div>
                        <div class="number count-to task-number" data-from="0" data-to="{{$new_tasks}}" data-speed="1000" data-fresh-interval="20">125</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">play_arrow</i>
                    </div>
                    <div class="content">
                        <div class="text">{{__('ON GOING TASKS')}}</div>
                        <div class="number count-to task-number" data-from="0" data-to="{{$ongoing_tasks}}" data-speed="1000" data-fresh-interval="20">125</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">{{__('COMPLETED TASKS')}}</div>
                        <div class="number count-to task-number" data-from="0" data-to="{{$comp_tasks}}" data-speed="1000" data-fresh-interval="20">125</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-light-blue hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">list</i>
                    </div>
                    <div class="content">
                        <div class="text">{{__('TOTAL TASKS')}}</div>
                        <div class="number count-to task-number" data-from="0" data-to="{{$tot_tasks}}" data-speed="1000" data-fresh-interval="20">125</div>
                    </div>
                </div>
            </div>
            
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
        <script >
        @if(session()->has('message'))
            $.notify({
                message: '{{ session()->get('message') }}'
            },{
                type: '{{session()->get('alert-type')}}',
                delay: 5000,
                offset: {x: 50, y:100}
            },
            );
        @endif
        </script>
</section>
@endsection