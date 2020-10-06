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
                    
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">playlist_add_check</i>
                            <span>Tasks</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li class="active">
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
                <h2>VIEW LETTERS</h2>
            </div>
            <div class="card">
                <div class="body">
                    
                    <table id="table_id" class="display compact">
                        <thead>
                            <tr>
                                <th>Letter No.</th>
                                <th>Letter Title</th>
                                <th>Task Assigned To</th>
                                <th>Task Assigned On</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($tasks) > 0)
                                @foreach($tasks as $task)
                                <tr>
                                        <td>{{$task->letter->letter_no}}</td>
                                    <td>{{$task->letter->letter_title}}&nbsp;</td>
                                    @foreach($users as $user)
                                        @if($user->id==$task->assigned_to)
                                        <td>{{$user->name}}&nbsp;</td>
                                        @endif
                                    @endforeach
                                    <td>{{$task->created_at}}</td>
                                    <td>{{$task->remarks}}&nbsp;</td>
                                    <td><a class="btn bg-green btn-block btn-xs waves-effect" href="{{ route('tasks.show', $task->id) }}">
                                            <i class="material-icons">pageview</i>
                                                <span>VIEW</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>No records found</tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
@endsection