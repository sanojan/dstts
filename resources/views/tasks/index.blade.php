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
                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                    <li >
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>{{__('Letters')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li >
                                        <a href="{{route('letters.index', app()->getLocale())}}">{{__('View Letter')}}</a>
                                    </li>
                                    <li >
                                        <a href="{{route('letters.create', app()->getLocale())}}">{{__('Add Letter')}}</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    
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
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                                    <li >
                                        <a href="{{route('tasks.create', app()->getLocale())}}">{{__('Assign Task')}}</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    @if(Gate::allows('sys_admin'))
                    <li >
                        <a href="index.html">
                            <i class="material-icons">group</i>
                            <span>{{__('Users')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>{{__('System Data')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="#">{{__('Designation')}}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{__('Work Place')}}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{__('Services')}}</a>
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
                <h2>{{__('VIEW TASKS')}}</h2>
            </div>
            <div class="card">
                <div class="body">
                    
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>{{__('Letter No.')}}</th>
                                <th>{{__('Letter Title')}}</th>
                                <th>{{__('Task Assigned To')}}</th>
                                <th>{{__('Task Assigned On')}}</th>
                                <th>{{__('Current Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                            @if($tasks)
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                        <td>{{$task->letter->letter_no}}</td>
                                    <td>{{$task->letter->letter_title}}&nbsp;</td>
                                    
                                        
                                        <td>{{$task->user->name}}</td>
                                        
                                    
                                    <td>{{$task->created_at}}</td>
                                    @if(count($task->histories) > 0)
                                            @foreach($task->histories as $history)
                                                @if($history->current==true)
                                                <td>{{$history->status}}&nbsp;</td>
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