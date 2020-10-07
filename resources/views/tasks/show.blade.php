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
                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
                    <li >
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>Letters</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li >
                                        <a href="{{route('letters.index')}}">View Letter</a>
                                    </li>
                                    <li >
                                        <a href="{{route('letters.create')}}">Add Letter</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">playlist_add_check</i>
                            <span>Tasks</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li class="active">
                                        <a href="{{route('tasks.index')}}">View Task(s)</a>
                                    </li>
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
                                    <li >
                                        <a href="{{route('tasks.create')}}">Assign Task</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
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
                    @endif
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
                <h2>TASK DETAILS</h2>
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
                                        <td>{{$task->letter->letter_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>Letter Title:</td>
                                        <td>{{$task->letter->letter_title}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Assigned To:</td>
                                        
                                       
                                        <td>{{$task->user->name}}</td>

                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>Assigned On:</td>
                                        <td>{{$task->created_at}}</td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <td>Remarks:</td>
                                        <td>{{$task->remarks}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Deadline:</td>
                                        <td>{{$task->deadline}}&nbsp;</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Current Status:</td>
                                        <td>&nbsp;</td>
                                        
                                    </tr>
                                    
                                </tbody>    
                            </table>
                            <div>
                                <a type="button" style="margin-right:10px" class="btn bg-grey btn-xs waves-effect" href="{{route('tasks.index')}}">
                                    <i class="material-icons">keyboard_backspace</i>
                                    <span>BACK</span>
                                </a>
                                <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect">
                                    <i class="material-icons">check</i>
                                    <span>ACCEPT TASK</span>
                                </button>
                               
                                <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect" >
                                    <i class="material-icons">fast_forward</i>
                                    <span>ACCEPT & FORWARD</span>
                                </button>
                                </button> <button type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" >
                                    <i class="material-icons">close</i>
                                    <span>REJECT TASK</span>
                                </button>
                                
                            </div>
                        </div>
                    </div>
        </div>
</section>
@endsection