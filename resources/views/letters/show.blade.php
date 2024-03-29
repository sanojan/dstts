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
                                <li class="active">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">email</i>
                                        <span>{{__('Letters')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                                <li class="active">
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
                <h2>{{__('LETTER DETAILS')}}</h2>
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
                                        <th style="width:200px"></th>
                                        <th style="width:20px"></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('Letter No.')}}:</td>
                                        <td>{{$letter->letter_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter Date')}}:</td>
                                        <td>{{$letter->letter_date}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter From')}}:</td>
                                        <td>{{$letter->letter_from}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter Title')}}:</td>
                                        <td>{{$letter->letter_title}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Letter Content')}}:</td>
                                        <td>{{$letter->letter_content}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Scanned Copy')}}:</td>
                                        @if($letter->letter_scanned_copy)
                                            <td><a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('scanned_letters/' . $letter->letter_scanned_copy) }}" target="_blank">
                                                    <i class="material-icons">file_download</i>
                                                </a> {{__('Click to view attached scanned copy')}}
                                            </td>
                                        @else
                                            <td>{{__('No Scanned copy was attached')}}</td>
                                        @endif    
                                    </tr>
                                </tbody>    
                            </table>
                            <div>
                                <a class="btn bg-grey btn-xs waves-effect" style="margin-right:10px" href="{{route('letters.index', app()->getLocale())}}">
                                    <i class="material-icons">keyboard_backspace</i>
                                    <span>{{__('BACK')}}</span>
                                </a>
                                @if($letter->user->workplace->id == Auth::user()->workplace->id)
                                <a type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" href="{{route('letters.edit', [app()->getLocale(), $letter->id])}}">
                                    <i class="material-icons">mode_edit</i>
                                    <span>{{__('EDIT DETAILS')}}</span>
                                </a>
                                @if(Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('sys_admin'))
                                <button type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#createTask" aria-expanded="false" aria-controls="createTask">
                                    <i class="material-icons">add_to_photos</i>
                                    <span>{{__('CREATE TASK')}}</span>
                                </button>
                                @endif
                                @if(Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('sys_admin') || Gate::allows('branch_head'))
                                <button type="button" style="margin-right:10px" class="btn bg-deep-purple btn-xs waves-effect collapsed " data-toggle="collapse" data-target="#taskHistory" aria-expanded="false" aria-controls="taskHistory">
                                    <i class="material-icons">access_time</i>
                                    <span>{{__('VIEW TASK HISTORY')}}</span>
                                </button>
                                @endif
                                @if(Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('sys_admin'))
                                <br /><br />
                                <br /><br />
                                <form method="POST" action="{{ route('letters.destroy', [app()->getLocale(), $letter->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-xs waves-effect" onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                                        <i class="material-icons">delete</i>
                                            <span>{{__('DELETE LETTER')}}</span>
                                    </button>
                                </form>    
                                @endif
                                @endif
                                                                                                                           
                                <!-- <a type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" href="{{route('letters.destroy', [$letter->id, app()->getLocale()])}}">
                                    <i class="material-icons">delete</i>
                                    <span>DELETE LETTER</span>
                                </a> -->
                                <br />
                                <div class="collapse" id="createTask" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                    <div class="card">
                
                <div class="body">
                    <form action="{{ route('tasks.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="tasks_add_form">
                    @csrf
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control letter_no_dropdown" style="width:100%;" id="letter_no" name="letter_no" value="{{ old('letter_no') }}">
                                    <option value="{{$letter->id}}" selected>{{$letter->letter_no}} - <i>{{$letter->letter_title}}</i></option>
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
                                        @if($users)
                                        @foreach($users as $user)
                                        @php
                                        $user_workplace = \App\Workplace::find($user->workplace_id);
                                        @endphp
                                        <option value="{{$user->id}}">{{$user->name}}-<i>{{$user->designation}}</i> ({{$user_workplace->name}})</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    
                                    @error('assigned_to')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                              
                        </div>
                        <div class="row clearfix">
                        <div class="col-md-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="3" class="form-control no-resize" name="remarks">{{ old('remarks') }}</textarea>
                                        <label class="form-label">{{__('Remarks')}}</label>
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
                                    <label class="form-label">{{__('Deadline')}}</label> 
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
                                            <label class="form-label" for="deadlinetf">{{__('No Deadline Task')}}</label> 
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
                        <button type="submit" class="btn btn-primary waves-effect" name="task_from_letter_button" value="task_from_letter" style="margin-right:10px">
                            <i class="material-icons">note_add</i>
                            <span>{{__('CREATE')}}</span>
                        </button>
                        

                        
                    </form>
                </div>
            </div>
        </div>
</div>
                                <br />
                                <div class="collapse" id="taskHistory" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                    <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                    @if($letter->tasks)
                                        @foreach($letter->tasks as $task)
                                        <div class="panel panel-primary">
                                            <div class="panel-heading" role="tab" id="headingOne_{{$task->id}}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_{{$task->id}}" aria-expanded="true" aria-controls="collapseOne_{{$task->id}}" class="">
                                                        New Task Assigned To {{$task->user->name}} - {{$task->user->designation}} ({{$task->user->workplace->name}}) On {{$task->created_at}} 
                                                    </a>
                                                    
                                                </h4>
                                            </div>
                                            <div id="collapseOne_{{$task->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_{{$task->id}}" aria-expanded="true" style="">
                                                <div class="panel-body">
                                                <ul>
                                                    <li>Task remarks: {{$task->remarks}} </li>
                                                    @foreach($task->histories as $history)
                                                    <li>This Task was {{$history->status}} by {{$history->task->user->name}} on {{$history->created_at}} | Remarks: {{$task->remarks}}</li>
                                                    @if($history->remarks)
                                                        <ul><li>Remarks: {{$history->remarks}}</li></ul>
                                                        @if($history->status == "Completed")
                                                            @if($task->task_report)
                                                                <ul><li>Task Report: <a href="{{ Storage::url('task_reports/' . $task->task_report) }}" target="_blank">Click Here to View</a> </li></ul>
                                                            @endif
                                                        @endif
                                                        

                                                    @endif
                                                    @endforeach
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
</section>
@endsection