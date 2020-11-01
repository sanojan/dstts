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
                    <li class="">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>{{__('Letters')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li class="">
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
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                                    <li >
                                        <a href="{{route('tasks.create', app()->getLocale())}}">{{__('Assign Task')}}</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                    <li class="active">
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
                <h2>{{__('COMPLAINT DETAILS')}}</h2>
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
                                        <td>{{__('Complainant Name')}}:</td>
                                        <td>{{$complaint->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Complainant NIC')}}:</td>
                                        <td>{{$complaint->nic}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Complainant Date of Birth')}}:</td>
                                        <td>{{$complaint->dob}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Complainant Email & Phone No.')}}:</td>
                                        <td>{{$complaint->email}} | {{$complaint->mobile_no}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Complainant DS & GN Division')}}:</td>
                                        <td>{{$complaint->dsdivision}} - {{$complaint->gndivision}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Complainant Permanent Address')}}:</td>
                                        <td>{{$complaint->permanant_address}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Complainant Temporary Address')}}:</td>
                                        <td>{{$complaint->temporary_address}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Complaint Content')}}:</td>
                                        <td>{{$complaint->complaint_content}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Scanned Copy')}}:</td>
                                        @if($complaint->complaint_scanned_copy)
                                            <td><a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('scanned_complaints/' . $complaint->complaint_scanned_copy) }}" target="_blank">
                                                    <i class="material-icons">file_download</i>
                                                </a> {{__('Click to view attached scanned copy')}}
                                            </td>
                                        @else
                                            <td>{{__('No Scanned copy was attached')}}</td>
                                        @endif    
                                    </tr>
                                    <tr>
                                        <td>{{__('Complaint Status')}}:</td>
                                        <td>{{$complaint->status}}</td>
                                    </tr>
                                </tbody>    
                            </table>
                            <div>
                                <button type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#createTask" aria-expanded="false" aria-controls="createTask">
                                    <i class="material-icons">add_to_photos</i>
                                    <span>{{__('CREATE TASK')}}</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn bg-deep-purple btn-xs waves-effect collapsed " data-toggle="collapse" data-target="#taskHistory" aria-expanded="false" aria-controls="taskHistory">
                                    <i class="material-icons">access_time</i>
                                    <span>{{__('VIEW TASK HISTORY')}}</span>
                                </button><br /><br />
                                @if(Gate::allows('sys_admin'))
                                <form method="POST" action="{{ route('complaints.destroy', [app()->getLocale(), $complaint->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-xs waves-effect"  onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                                        <i class="material-icons">delete</i>
                                            <span>{{__('DELETE COMPLAINT')}}</span>
                                    </button>
                                </form>   
                                @endif                                                                                                  
                                <!-- <a type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" href="{{route('complaints.destroy', [$complaint->id, app()->getLocale()])}}">
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
                                                        <div class="col-md-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="hidden" name="complaint_id" value="{{$complaint->id}}">
                                                                    <select class="form-control assign_to_dropdown" style="width:100%;" id="assigned_to" name="assigned_to[]">
                                                                    <option value="" ></option>
                                                                    @foreach($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}-<i>{{$user->designation}}</i> ({{$user->workplace}})</option>
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
                                                    <button type="submit" class="btn btn-primary waves-effect" name="task_from_complaint_button" value="task_from_complaint" style="margin-right:10px">
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
                                    @if($complaint->tasks)
                                        @foreach($complaint->tasks as $task)
                                        <div class="panel panel-primary">
                                            <div class="panel-heading" role="tab" id="headingOne_{{$task->id}}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_{{$task->id}}" aria-expanded="true" aria-controls="collapseOne_{{$task->id}}" class="">
                                                        New Task Assigned To {{$task->user->name}} - {{$task->user->designation}} ({{$task->user->workplace}}) On {{$task->created_at}} 
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne_{{$task->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_{{$task->id}}" aria-expanded="true" style="">
                                                <div class="panel-body">
                                                <ul>
                                                    @foreach($task->histories as $history)
                                                    <li>This Task was {{$history->status}} by {{$history->task->user->name}} on {{$history->created_at}}</li>
                                                    @if($history->remarks)
                                                        <ul><li>Remarks: {{$history->remarks}}</li></ul>
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