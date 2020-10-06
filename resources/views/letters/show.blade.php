@extends('inc.layout')

@section('sidebar')
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li >
                        <a href="{{route('home')}}">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>Letters</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li class="active">
                                        <a href="{{route('letters.index')}}">View Letter</a>
                                    </li>
                                    <li >
                                        <a href="{{route('letters.create')}}">Add Letter</a>
                                    </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">playlist_add_check</i>
                            <span>Tasks</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="{{route('tasks.index')}}">View Task(s)</a>
                                    </li>
                                    <li >
                                        <a href="{{route('tasks.create')}}">Assign Task</a>
                                    </li>
                        </ul>
                    </li>
                    <li >
                        <a href="index.html">
                            <i class="material-icons">group</i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>System Data</span>
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
                    <li >
                        <a href="index.html">
                            <i class="material-icons">help</i>
                            <span>Help</span>
                        </a>
                    </li>
                    <li >
                        <a href="index.html">
                            <i class="material-icons">group</i>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li >
                        <a href="index.html">
                            <i class="material-icons">contact_phone</i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy;2020 <a href="javascript:void(0);">District Secretariat - Ampara</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.1
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
      
    </section>
@endsection

@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>LETTER DETAILS</h2>
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
                                        <td>Letter Number:</td>
                                        <td>{{$letter->letter_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>Letter Date:</td>
                                        <td>{{$letter->letter_date}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Sender:</td>
                                        <td>{{$letter->letter_from}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Title:</td>
                                        <td>{{$letter->letter_title}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>Content:</td>
                                        <td>{{$letter->letter_content}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Scanned Copy:</td>
                                        @if($letter->letter_scanned_copy)
                                            <td><a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('scanned_letters/' . $letter->letter_scanned_copy) }}" target="_blank">
                                                    <i class="material-icons">file_download</i>
                                                </a> Click to view attached scanned copy
                                            </td>
                                        @else
                                            <td>No Scanned copy was attached</td>
                                        @endif    
                                    </tr>
                                </tbody>    
                            </table>
                            <div>
                                <a type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" href="{{route('letters.edit', $letter->id)}}">
                                    <i class="material-icons">mode_edit</i>
                                    <span>EDIT DETAILS</span>
                                </a>
                                <button type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect collapsed" data-toggle="collapse" data-target="#createTask" aria-expanded="false" aria-controls="createTask">
                                    <i class="material-icons">add_to_photos</i>
                                    <span>CREATE TASK</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn bg-deep-purple btn-xs waves-effect collapsed " data-toggle="collapse" data-target="#taskHistory" aria-expanded="false" aria-controls="taskHistory">
                                    <i class="material-icons">access_time</i>
                                    <span>VIEW TASK HISTORY</span>
                                </button><br /><br />

                                <form method="POST" action="{{ route('letters.destroy', $letter->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-xs waves-effect"  onclick="return confirm('Are you sure? You cannot revert this action.')">
                                        <i class="material-icons">delete</i>
                                            <span>DELETE LETTER</span>
                                    </button>
                                </form>                                                                                                     
                                <!-- <a type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" href="{{route('letters.destroy', $letter->id)}}">
                                    <i class="material-icons">delete</i>
                                    <span>DELETE LETTER</span>
                                </a> -->
                                <br />
                                <div class="collapse" id="createTask" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        This is createTask
                                    </div>
                                </div>
                                <br />
                                <div class="collapse" id="taskHistory" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        This is taskHistory
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
</section>
@endsection