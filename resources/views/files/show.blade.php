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
                                <li>
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
                                <li class="active">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">folder</i>
                                        <span>{{__('Files')}}</span>
                                        
                                    </a>
                                    <ul class="ml-menu">
                                        
                                                <li class="active">
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
                <h2>{{__('FILE DETAILS')}}</h2>
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
                                        <td>{{__('File No.')}}:</td>
                                        <td>{{$file->file_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('File Name')}}:</td>
                                        <td>{{$file->file_name}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('File Location')}}:</td>
                                        <td>{{$file->workplace->name}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('File Branch')}}:</td>
                                        <td>{{$file->file_branch}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('File Description')}}:</td>
                                        <td>{{$file->file_desc}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('File Owner')}}:</td>
                                        @if($file->user)
                                        <td>{{$file->user->name}} - {{$file->user->designation}}</td>
                                        @else
                                        <td>No Owner</td>
                                        @endif
                                        
                                    </tr>
                                </tbody>    
                            </table>
                            <div>
                                @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head'))
                                <a type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" href="{{route('files.edit', [app()->getLocale(), $file->id])}}">
                                    <i class="material-icons">mode_edit</i>
                                    <span>{{__('EDIT FILE')}}</span>
                                </a>
                               
                                <button type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#changeOwner" aria-expanded="false" aria-controls="changeOwner">
                                    <i class="material-icons">person</i>
                                    <span>{{__('CHANGE OWNER')}}</span>
                                </button>
                                @endif 
                                <button type="button" style="margin-right:10px" class="btn bg-teal btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#addLetter" aria-expanded="false" aria-controls="addLetter">
                                    <i class="material-icons">add_to_photos</i>
                                    <span>{{__('ADD LETTER')}}</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn bg-deep-purple btn-xs waves-effect collapsed " data-toggle="collapse" data-target="#viewContents" aria-expanded="false" aria-controls="viewContents">
                                    <i class="material-icons">view_headline</i>
                                    <span>{{__('VIEW CONTENTS')}}</span>
                                </button><br /><br />
                                @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin'))
                                <form method="POST" action="{{ route('files.destroy', [app()->getLocale(), $file->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-danger btn-xs waves-effect" onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                                    <i class="material-icons">delete</i>
                                        <span>{{__('DELETE FILE')}}</span>
                                </button>
                                </form>         
                                @endif                                                                                            
                               
                                <br />
                                @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head'))
                                <div class="collapse" id="changeOwner" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('files.update', [app()->getLocale(), $file->id] )}}" method="POST" enctype="multipart/form-data" id="change_owner_form">
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
                                                            <label class="form-label">{{__('Select the New Owner')}}</label>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" style="width:100%;" id="users_name" name="users_name">
                                                                
                                                                <option value="" @if(old('users')=="") selected disabled @endif>{{__('Select Owner')}}</option>
                                                        
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}" @if(old('users')=="{{$user->id}}") selected @endif>{{$user->name}} - {{$user->designation}}</option>
                                                                @endforeach
                                                                
                                                                </select>
                                                                
                                                                    
                                                            </td>  <td></td>     
                                                            <td>
                                                                <button type="submit" style="margin-right:10px" name="change_owner_button" value="change_owner" class="btn bg-green btn-xs waves-effect" >
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
                                @endif

                                <div class="collapse" id="viewContents" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <table id="letters_table_id" class="display ">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('Letter No.')}}</th>
                                                        <th>{{__('Letter Title')}}</th>
                                                        <th>{{__('Letter Date')}}</th>
                                                        <th>{{__('Letter From')}}</th>
                                                        <th>{{__('Created On')}}</th>
                                                        @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head'))
                                                        <th>{{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                @if(count($file->letters) > 0)
                                                <tbody>
                                                    @foreach($file->letters as $letter)
                                                    <tr>
                                                        <td>{{$letter->letter_no}}</td>
                                                        <td>{{$letter->letter_title}}</td>
                                                        <td>{{$letter->letter_date}}</td>
                                                        <td>{{$letter->letter_from}}</td>
                                                        <td>{{$letter->created_at}}</td>
                                                        @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin') || Gate::allows('branch_head'))
                                                        <td><a class="btn bg-green btn-block btn-xs waves-effect" href="{{ route('letters.show', [app()->getLocale(), $letter->id]) }}">
                                                                <i class="material-icons">pageview</i>
                                                                    <span>{{__('VIEW')}}</span>
                                                            </a>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                @endif
                        
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="collapse" id="addLetter" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('files.update', [app()->getLocale(), $file->id] )}}" method="POST" enctype="multipart/form-data" id="change_owner_form">
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
                                                            <label class="form-label">{{__('Select the Letter')}}</label>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" style="width:100%;" id="letters_name" name="letters_name">
                                                                
                                                                <option value="" @if(old('users')=="") selected disabled @endif>{{__('Select Letter')}}</option>
                                                                @php $unique = $tasks->unique('key');
                                                                $task_letter=""; 
                                                                @endphp
                                                                @foreach($unique as $task)
                                                                    @php
                                                                    if(\App\Letter::find($task->letter_id)){
                                                                        $task_letter = \App\Letter::find($task->letter_id);
                                                                    }else{
                                                                        $task_letter = "";
                                                                    }
                                                                    @endphp
                                                                    <option value="{{$task->letter_id}}" @if(old('task')=="{{$task->letter_id}}") selected @endif>{{$task_letter->letter_no}} - {{$task_letter->letter_title}}</option>
                                                                @endforeach
                                                                
                                                                </select>
                                                            
                                                                    
                                                            </td>  <td></td>     
                                                            <td>
                                                            @if($task_letter != "")
                                                                @if($task_letter->file)
                                                                    <button type="submit" style="margin-right:10px" name="add_letter_button" value="add_letter" class="btn bg-green btn-xs waves-effect" onclick="return confirm('This letter will be moved from {{ $task_letter->file->file_no }} ({{$task_letter->file->file_name}}) to this file. Do you want to continue?')">
                                                                    <i class="material-icons">check</i>
                                                                    <span>{{__('SUBMIT')}}</span>
                                                                    </button>
                                                                @else
                                                                    <button type="submit" style="margin-right:10px" name="add_letter_button" value="add_letter" class="btn bg-green btn-xs waves-effect">
                                                                    <i class="material-icons">check</i>
                                                                    <span>{{__('SUBMIT')}}</span>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                               

                                <br />
                                
                            </div>
                        </div>
                    </div>
        </div>
</section>
@endsection