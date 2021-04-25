@extends('inc.layout')

@section('sidebar')
         
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">{{__('MAIN NAVIGATION')}}</li>
                    <li class="">
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
                                    <li>
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
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">playlist_add_check</i>
                            <span>{{__('Tasks')}}</span>
                            @if($new_tasks > 0)
                            <span class="badge bg-red">{{$new_tasks}} {{__('New')}}</span>
                            @endif
                        </a>
                        <ul class="ml-menu">
                            
                                    <li class="active">
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
                <h2>{{__('VIEW TASKS')}}</h2>
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
                <div class="body">
                    
                    <table id="export_table_id" class="display">
                        <thead>
                            <tr>
                                <th>{{__('Letter No.')}}/{{__('Complaint Ref.No')}}</th>
                                <th>{{__('Letter Title')}}/{{__('Complainant Name')}}</th>
                                <th>{{__('Letter Type')}}</th>
                                <th>{{__('Receieved Date')}}</th>
                                <th>{{__('Task Assigned To')}}</th>
                                <th>{{__('Task Assigned On')}}</th>
                                <th>{{__('Curent File No.')}}</th>
                                <th>{{__('Current Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                            @if($tasks)
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                @if($task->letter)
                                    <td>{{$task->letter->letter_no}}</td>
                                    <td>{{$task->letter->letter_title}}</td>

                                    @if ($task->letter->letter_type == 'reg_post')
                                    <td>{{__('Registered Post')}} ({{$task->letter->letter_reg_no}})</td>
                                    @elseif ($task->letter->letter_type == 'norm_post')
                                    <td>{{__('Normal Post')}}</td>
                                    @elseif ($task->letter->letter_type == 'fax')
                                    <td>{{__('Fax')}}</td>
                                    @elseif ($task->letter->letter_type == 'email')
                                    <td>{{__('Email')}}</td>
                                    @elseif ($task->letter->letter_type == 'from_ga')
                                    <td>{{__('From GA')}}</td>
                                    @elseif ($task->letter->letter_type == 'from_ds')
                                    <td>{{__('From DS')}}</td>
                                    @endif
                                    



                                    <td>{{$task->letter->letter_received_on}}</td>
                                @else
                                    <td>{{$task->complaint->ref_no}}</td>
                                    <td>{{$task->complaint->name}}</td>
                                    <td>{{__('Not Applicable')}}</td>
                                    <td>{{$task->complaint->created_at}}</td>
                                @endif
                                    @php 
                                        $task_assigned_by = App\User::find($task->assigned_by)
                                    @endphp
                                    <td>{{$task->user->name}}({{$task->user->designation}})-{{$task->user->workplace->name}} ({{$task->user->branch}} Branch)</td>    
                                    
                                    <td>{{$task->created_at}}</td>
                                    @if($task->letter)
                                        @if($task->letter->file)
                                        <td>{{$task->letter->file->file_no}}</td>
                                        @else
                                        <td>{{__('Not in File')}}</td>
                                        @endif
                                    @else
                                    <td>{{__('Not Applicable')}}</td>
                                    @endif
                                    
                                    @if(count($task->histories) > 0)
                                            @foreach($task->histories as $history)
                                                @if($history->current==true)
                                                <td>{{$history->status}}</td>
                                                @endif
                                            @endforeach
                                    @else
                                    <td>Waiting to be Accepted</td>
                                    @endif
                                    <td><a class="btn bg-green btn-block btn-xs waves-effect" href="{{ route('tasks.show', [app()->getLocale(), $task->id]) }}">
                                            <i class="material-icons">pageview</i>
                                                <span>{{__('VIEW')}}</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endif
                    </table>
                </div>
            </div>
        </div>
</section>
@endsection