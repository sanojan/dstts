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
                            <i class="material-icons">library_books</i>
                            <span>Assignments</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="pages/widgets/cards/basic.html">View Assignment(s)</a>
                                    </li>
                                    <li>
                                        <a href="pages/widgets/cards/colored.html">Create Assignment</a>
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
                                        <a href="pages/widgets/cards/basic.html">View Task(s)</a>
                                    </li>
                                    <li>
                                        <a href="pages/widgets/cards/colored.html">Assign Task</a>
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
                                        <td><button type="button" class="btn btn-default btn-xs waves-effect">
                                                <i class="material-icons">file_download</i>
                                            </button> 
                                        </td>
                                        
                                    </tr>
                                </tbody>    
                            </table>
                            <div>
                                <button type="button" style="margin-right:10px" class="btn btn-success btn-xs waves-effect">
                                    <i class="material-icons">mode_edit</i>
                                    <span>EDIT DETAILS</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn btn-primary btn-xs waves-effect" >
                                    <i class="material-icons">add_to_photos</i>
                                    <span>CREATE TASK</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn bg-deep-purple btn-xs waves-effect" >
                                    <i class="material-icons">access_time</i>
                                    <span>VIEW TASK HISTORY</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" >
                                    <i class="material-icons">delete</i>
                                    <span>DELETE LETTER</span>
                                </button>
                            </div>
                        </div>
                    </div>
        </div>
</section>
@endsection