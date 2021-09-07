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
                                <li >
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">email</i>
                                        <span>{{__('Letters')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                                <li >
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
                                <li class="">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">group</i>
                                        <span>{{__('Users')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                       
                                        <li>
                                            <a href="{{route('users.create', app()->getLocale())}}">Create User</a>
                                        </li>
                                        
                                        
                                            <li >
                                                <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
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
                <h2>{{__('TASK DETAILS')}}</h2>
            </div>
            <div class="card">
                        <div class="body table-responsive">
                        <form action="{{ route('histories.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="history_add_form">
                        @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px"></th>
                                        <th style="width:20px"></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($task->letter)
                                    <tr>
                                        <td>{{__('Letter No.')}}:</td>
                                        <input type="hidden" name="task_id" class="form-control" value="{{$task->id}}" readonly> 
                                        <td><input type="text" name="letter_no" class="form-control" value="{{$task->letter->letter_no}}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter Title')}}:</td>
                                        <td><input type="text" name="letter_title" class="form-control" value="{{$task->letter->letter_title}}" readonly> </td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter Sender')}}:</td>
                                        <td><input type="text" name="letter_sender" class="form-control" value="{{$task->letter->letter_from}}" readonly> </td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter Content')}}:</td>
                                        <td><textarea name="letter_content" class="form-control" style="resize: none;" readonly>{{$task->letter->letter_content}} </textarea></td>
                                        
                                    </tr>
                                    @else
                                    <tr>
                                        <td>{{__('Complaint Ref.No')}}:</td>
                                        <input type="hidden" name="task_id" class="form-control" value="{{$task->id}}" readonly> 
                                        <td><input type="text" name="ref_no" class="form-control" value="{{$task->complaint->ref_no}}" readonly></td>
                                        </tr>
                                    <tr>
                                        <td>{{__('Complainant Name')}}:</td>
                                        <td><input type="text" name="complainant_name" class="form-control" value="{{$task->complaint->name}}" readonly> </td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Complaint Content')}}:</td>
                                        <td><textarea name="complaint_content" class="form-control" style="resize: none;" readonly>{{$task->complaint->complaint_content}} </textarea></td>
                                        
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('Task Assigned To')}}:</td>
                                        
                                        <td><input type="text" name="assigned_to" class="form-control" value="{{$task->user->name}}" readonly> </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Task Assigned By')}}:</td>
                                        
                                        <td><input type="text" name="assigned_to" class="form-control" value="{{$assigned_by->name}} - {{$assigned_by->designation}}" readonly> </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Task Assigned On')}}:</td>
                                        <td><input type="text" name="assigned_on" class="form-control" value="{{$task->created_at}}" readonly> </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Remarks')}}:</td>
                                        <td><input type="text" name="remarks" class="form-control" value="{{$task->remarks}}" readonly> </td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Deadline')}}:</td>
                                        <td><input type="text" name="deadline" class="form-control" value="{{$task->deadline}}" readonly> </td>
                                        
                                        
                                    </tr>
                                    <tr>
                                    @if($task->letter)
                                    <td>{{__('Letter Scanned Copy')}}:</td>
                                    @if($task->letter->letter_scanned_copy)
                                    
                                    <td><a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('scanned_letters/' . $task->letter->letter_scanned_copy) }}" target="_blank">
                                                    <i class="material-icons">file_download</i>
                                                </a>{{__('Click to view attached scanned copy')}}
                                            </td>
                                        @else
                                            <td>{{__('No Scanned copy was attached')}}</td>
                                        @endif   
                                    </tr>
                                    @else
                                    <td>{{__('Content Scanned Copy')}}:</td>
                                    @if($task->complaint->complaint_scanned_copy)
                                    
                                    <td><a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('scanned_complaints/' . $task->complaint->complaint_scanned_copy) }}" target="_blank">
                                                    <i class="material-icons">file_download</i>
                                                </a>{{__('Click to view attached scanned copy')}}
                                            </td>
                                        @else
                                            <td>{{__('No Scanned copy was attached')}}</td>
                                        @endif   
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('Current Status')}}:</td>
                                        @if(count($task->histories) > 0)
                                            @foreach($task->histories as $history)
                                                @if($history->current==true)
                                                    @if($history->status == "Forwarded")
                                                    <td><input type="text" name="current_status" class="form-control" value="{{$history->status}} by {{$task->user->name}}" readonly> </td>
                                                    @else
                                                    <td><input type="text" name="current_status" class="form-control" value="{{$history->status}} on {{$history->created_at}} " readonly> </td>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                        <td><input type="text" name="current_status" class="form-control" value="Waiting to be Accepted" readonly> </td>
                                        @endif
                                        
                                    </tr>
                                    
                                    
                                </tbody>    
                            </table>
                               
                                
                            <div>
                            
                                @if(count($task->histories) > 0)
                                            @foreach($task->histories as $history)
                                                @if($history->current==true)
                                                    @if($history->status=='Accepted')
                                                    <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                                        <i class="material-icons">keyboard_backspace</i>
                                                        <span>{{__('BACK')}}</span>
                                                    </a>
                                                    <a type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" data-toggle="collapse" data-target="#cancelTask" aria-expanded="false" aria-controls="rejectTask">
                                                        <i class="material-icons">undo</i>
                                                        <span>{{__('CANCEL TASK')}}</span>
                                                    </a>
                                                    <a type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect" data-toggle="collapse" data-target="#completeTask" aria-expanded="false" aria-controls="completeTask">
                                                        <i class="material-icons">done</i>
                                                        <span>{{__('COMPLETE TASK')}}</span>
                                                    </a>
                                                    @elseif($history->status == "Rejected")
                                                    <table class="table">
                                                    <tr>
                                                        <td >{{__('Reason for Rejection')}}:</td>
                                                        <td><input type="text" name="reject_remarks" class="form-control" value="{{$history->remarks}}" readonly> </td>
                                                    </tr>
                                                
                                                    </table>
                                                    <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                                        <i class="material-icons">keyboard_backspace</i>
                                                        <span>{{__('BACK')}}</span>
                                                    </a>
                                                    @elseif($history->status=='Forwarded')
                                                    <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                                        <i class="material-icons">keyboard_backspace</i>
                                                        <span>{{__('BACK')}}</span>
                                                    </a>
                                                    @elseif($history->status == "Cancelled")
                                                    <table class="table">
                                                    <tr>
                                                        <td >{{__('Reason for Cancellation')}}:</td>
                                                        <td><input type="text" name="cancel_remarks" class="form-control" value="{{$history->remarks}}" readonly> </td>
                                                    </tr>
                                                
                                                    </table>
                                                    <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                                        <i class="material-icons">keyboard_backspace</i>
                                                        <span>{{__('BACK')}}</span>
                                                    </a>
                                                    @elseif($history->status == "Seen")
                                                    <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                                        <i class="material-icons">keyboard_backspace</i>
                                                        <span>{{__('BACK')}}</span>
                                                    </a>
                                                
                                                    @if($task->user->id == Auth::user()->id)
                                                            <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" data-toggle="collapse" data-target="#acceptTask" aria-expanded="false" aria-controls="acceptTask">
                                                                <i class="material-icons">done</i>
                                                                <span>{{__('ACCEPT TASK')}}</span>
                                                            </button>
                                                            @if (Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('branch_head')) 
                                                            <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" data-toggle="collapse" data-target="#acceptandforwardTask" aria-expanded="false" aria-controls="acceptandforwardTask">
                                                                <i class="material-icons">fast_forward</i>
                                                                <span>{{__('ACCEPT & FORWARD')}}</span>
                                                            </button>
                                                            @endif
                                                        <a type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" data-toggle="collapse" data-target="#rejectTask" aria-expanded="false" aria-controls="rejectTask">
                                                            <i class="material-icons">close</i>
                                                            <span>{{__('REJECT TASK')}}</span>
                                                        </a>
                                                    @endif
                                                    @elseif($history->status == "Completed")
                                                        <table class="table">
                                                        <tr>
                                                            <td >{{__('Actions Taken for the task')}}:</td>
                                                            <td><input type="text" name="complete_remarks" class="form-control" value="{{$history->remarks}}" readonly> </td>
                                                        </tr>
                                                        @if($task->task_report)
                                                        <tr>
                                                        <td>{{__('Task completion report')}}</td>
                                                        <td><a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('task_reports/' . $task->task_report) }}" target="_blank">
                                                        <i class="material-icons">file_download</i>
                                                        </a>{{__('Click to view attached Task report')}}
                                                        </td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                        <td>{{__('Task completion report')}}</td>
                                                        <td>{{__('No Task report was attached')}}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                        
                                                        </tr>
                                                    
                                                        </table>
                                                        <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                                            <i class="material-icons">keyboard_backspace</i>
                                                            <span>{{__('BACK')}}</span>
                                                        </a>
                                                    
                                                    
                                                    @endif
                                                @endif
                                            @endforeach
                                @else
                                    <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index', app()->getLocale())}}">
                                        <i class="material-icons">keyboard_backspace</i>
                                        <span>{{__('BACK')}}</span>
                                    </a>
                                    @if($task->user->id == Auth::user()->id)
                                            <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" data-toggle="collapse" data-target="#acceptTask" aria-expanded="false" aria-controls="acceptTask">
                                                <i class="material-icons">done</i>
                                                <span>{{__('ACCEPT TASK')}}</span>
                                            </button>
                                            @if (Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('branch_head')) 
                                            <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" data-toggle="collapse" data-target="#acceptandforwardTask" aria-expanded="false" aria-controls="acceptandforwardTask">
                                                <i class="material-icons">fast_forward</i>
                                                <span>{{__('ACCEPT & FORWARD')}}</span>
                                            </button>
                                            @endif
                                        <a type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" data-toggle="collapse" data-target="#rejectTask" aria-expanded="false" aria-controls="rejectTask">
                                            <i class="material-icons">close</i>
                                            <span>{{__('REJECT TASK')}}</span>
                                        </a>
                                    @endif
                                @endif
                                
                            </div>
                            <br>
                                <div class="collapse" id="acceptTask" aria-expanded="false" style="height: 0px;">
                                        <div class="well" style="background:#03A9F4;"><table class="table">
                                            <tr>
                                            <td style="color:white;">{{__('Select File to place Letter')}}:</td>
                                                <td>
                                                    <select class="form-control" style="width:100%;" id="file_name" name="file_name">
                                                        <option value="" @if(old('file_name')=="") selected disabled @endif>{{__('Select File No.')}}</option>
                                                        
                                                       @foreach($task->user->files as $files)
                                                        <option value="{{$files->id}}" @if(old('file_name')=="{{$files->id}}") selected @endif>{{$files->file_no}} - {{$files->file_name}}</option>
                                                       @endforeach
                                                    </select> 
                                                </td>
                                                    
                                                <td>
                                            <button type="submit" style="margin-right:10px" name="subbutton" value="Accept" class="btn btn-danger btn-xs waves-effect" >
                                            <i class="material-icons">check</i>
                                            <span>{{__('SUBMIT')}}</span>
                                            </button>
                                            </td>
                                            </tr>
                                        
                                            </table>
                                        </div>
                                </div>

                                <div class="collapse" id="rejectTask" aria-expanded="false" style="height: 0px;">
                                    <div class="well" style="background:#a35d6a;"><table class="table">
                                        <tr>
                                        <td style="color:white;">{{__('Reason for Rejection')}} :</td>
                                            <td><input type="text" name="reject_remarks" class="form-control" > </td>
                                                
                                            <td>
                                        <button type="submit" style="margin-right:10px" name="subbutton" value="Reject" class="btn btn-danger btn-xs waves-effect" >
                                        <i class="material-icons">check</i>
                                        <span>{{__('SUBMIT')}}</span>
                                        </button>
                                        </td>
                                        </tr>
                                    
                                        </table>
                                    </div>
                                </div>

                                <div class="collapse" id="cancelTask" aria-expanded="false" style="height: 0px;">
                                    <div class="well" style="background:#03B7F6;"><table class="table">
                                        <tr>
                                        <td style="color:black;">{{__('Reason for Cancellation')}}:</td>
                                            <td><input type="text" name="cancel_remarks" class="form-control" > </td>
                                                
                                            <td>
                                        <button type="submit" style="margin-right:10px" name="subbutton" value="undo_task" class="btn btn-primary btn-xs waves-effect" >
                                        <i class="material-icons">check</i>
                                        <span>{{__('SUBMIT')}}</span>
                                        </button>
                                        </td>
                                        </tr>
                                    
                                        </table>
                                    </div>
                                </div>

                                <div class="collapse" id="completeTask" aria-expanded="false" style="height: 0px;">
                                    <div class="well" style="background:#2DF366;"><table class="table">
                                        <tr>
                                        <td style="color:black;">{{__('Actions taken for this Task')}}</td>
                                            <td><input type="text" name="complete_remarks" class="form-control" > </td>
                                                
                                        <td>
                                        <button type="submit" style="margin-right:10px" name="subbutton" value="Completed" class="btn btn-success btn-xs waves-effect" >
                                        <i class="material-icons">check</i>
                                        <span>{{__('SUBMIT')}}</span>
                                        </button>
                                        </td>
                                        <tr>
                                        <td><label class="form-label">{{__('Task Report (Optional)')}}</label></td>
                                        <td><input type="file" name="task_report" class="form-control"></td>
                                        @error('task_report')
                                                <label class="error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </label>
                                        @enderror
                                        </tr>
                                        </tr>
                                    
                                        </table>
                                    </div>
                                </div>
                            </form>
                            @if (Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('branch_head')) 
                            <div class="collapse" id="acceptandforwardTask" aria-expanded="false" style="height: 0px;">
                                <div class="well">
                                    <div class="card">
                
                                        <div class="body">
                                            <form action="{{ route('tasks.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="tasks_add_form">
                                            @csrf
                                                <div class="row clearfix">
                                                @if($task->letter)
                                                    <div class="col-md-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                            <input type="hidden" name="old_task_id" value="{{$task->id}}">
                                                            <select class="form-control letter_no_dropdown" style="width:100%;" id="letter_no" name="letter_no" value="{{ old('letter_no') }}">
                                                            <option value="{{$task->letter->id}}" selected>{{$task->letter->letter_no}} - <i>{{$task->letter->letter_no}}</i></option>
                                                            </select>
                                                            </div>
                                                            
                                                            @error('letter_no')
                                                                    <label class="error" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <select class="form-control assign_to_dropdown" style="width:100%;" id="assigned_to" name="assigned_to[]">
                                                                <option value="" ></option>
                                                                @foreach($users as $user)
                                                                @php
                                                                $user_workplace = \App\Workplace::find($user->workplace_id);
                                                                @endphp
                                                                <option value="{{$user->id}}">{{$user->name}} - <i>{{$user->designation}}</i>({{$user_workplace->name}})</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            @error('assigned_to')
                                                                    <label class="error" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="col-md-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <select class="form-control assign_to_dropdown" style="width:100%;" id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}">
                                                                <option value="" ></option>
                                                                @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}} - <i>{{$user->designation}}</i>({{$user->workplace}})</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            @error('assigned_to')
                                                                    <label class="error" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                </div>
                                                <div class="row clearfix">
                                                <div class="col-md-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <textarea rows="3" class="form-control no-resize" name="remarks">{{ old('remarks') }}</textarea>
                                                                <label class="form-label">Remarks</label>
                                                            </div>
                                                            @error('remarks')
                                                                    <label class="error" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </label>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                            <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="deadline" name="deadline" value="{{ old('deadline') }}">
                                                            <label class="form-label">Deadline</label> 
                                                            </div>
                                                            @error('deadline')
                                                                    <label class="error" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </label>
                                                            @enderror
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-md-6">
                                                        <div class="row clearfix">
                                                        <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    
                                                                    <input placeholder="" class="form-control" type="checkbox"  id="deadlinetf"   name="deadlinetf" value="{{ old('deadlinetf') }}" onchange="if(this.checked==true){document.getElementById('deadline').value='';document.getElementById('deadline').disabled=true;}else{document.getElementById('deadline').disabled=false;}">
                                                                    <label class="form-label" for="deadlinetf">No Deadline Task</label> 
                                                                    </div>
                                                                    @error('deadlinetf')
                                                                            <label class="error" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </label>
                                                                    @enderror
                                                                
                                                            </div>
                                                        </div>  
                                                    
                                                    </div>
                                                </div>
                                                     
                                                

                                                
                                                
                                                <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect" style="margin-right:10px">Create</button> -->
                                                <button type="submit" class="btn btn-primary waves-effect" name="accept_and_forward_button" value="accept_and_forward" style="margin-right:10px">
                                                    <i class="material-icons">fast_forward</i>
                                                    <span>FORWARD</span>
                                                </button>
                                                
                                                <a class="btn bg-grey waves-effect" style="margin-right:10px" href="{{route('letters.index', app()->getLocale())}}">
                                                    <i class="material-icons">keyboard_backspace</i>
                                                    <span>BACK</span>
                                                </a>

                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
        </div>
</section>
@endsection