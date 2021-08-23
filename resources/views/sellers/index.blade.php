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
                    @if(Gate::allows('sys_admin'))
                    <li >
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>{{__('Letters')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="{{route('letters.index', app()->getLocale())}}">{{__('View Letter')}}</a>
                                    </li>
                                    <li >
                                        <a href="{{route('letters.create', app()->getLocale())}}">{{__('Add Letter')}}</a>
                                    </li>
                        </ul>
                    </li>
                    
                    
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
                    @endif
                    <li class="active">
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
                            <li >
                                <a href="{{route('travelpasses.index', app()->getLocale())}}">{{__('View Travel Pass Entries')}}</a>
                            </li>
                            
                            <li >
                                <a href="{{route('travelpasses.create', app()->getLocale())}}">{{__('Add New Request')}}</a>
                            </li>   
                            
                            <li class="active">
                                <a href="{{route('sellers.index', app()->getLocale())}}">{{__('View Wholesale Sellers List')}}</a>
                            </li>

                        </ul>
                    </li>
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
            @if(Gate::allows('user'))
                <h2>{{__('VIEW WHOLESALE SELLERS')}}</h2>
            @elseif(Gate::allows('admin') || Gate::allows('sys_admin'))
                <h2>{{__('SELECT DIVISION TO VIEW WHOLESALE SELLERS')}}</h2>
            @endif
        </div>
        
        @if(Gate::allows('user'))
        <div class="card">
            <div class="body">
                
                <table id="sellers_table" class="display">
                    <thead>
                        <tr>
                            <th>{{__('Seller Name')}}</th>
                            <th>{{__('Seller Address')}}</th>
                            <th>{{__('Seller NIC No.')}}</th>
                            <th>{{__('Action')}}</th>
                            
                        </tr>
                    </thead>
                        
                </table>
                <br />
                <b>Wholesale Sellers List Status: </b> 
                @if(Auth::user()->workplace->sellers_list)
                    @if(Auth::user()->workplace->sellers_list == "SUBMITTED")
                        <p class="font-bold col-blue" style="display:inline">{{Auth::user()->workplace->sellers_list}}</p>
                        <br />
                        <br /> 
                    @elseif(Auth::user()->workplace->sellers_list == "APPROVED")  
                        <p class="font-bold col-green" style="display:inline">{{Auth::user()->workplace->sellers_list}}</p>
                        <br />
                        <br /> 
                    @elseif(Auth::user()->workplace->sellers_list == "REJECTED")
                        <p class="font-bold col-red" style="display:inline">{{Auth::user()->workplace->sellers_list}} (Reason: {{Auth::user()->workplace->rejection_reason}})</p>
                        <br />
                        <br />
                    @elseif(Auth::user()->workplace->sellers_list == "CHANGE REQUESTED")
                    <p class="font-bold col-teal" style="display:inline">{{Auth::user()->workplace->sellers_list}}</p>
                    <br />
                    <br />
                    @endif 
                @else
                    <p class="font-bold col-orange" style="display:inline">NOT SUBMITTED</p>
                    <br />
                    <br />   
                @endif

                <form action="{{ route('workplaces.update', [app()->getLocale(), Auth::user()->workplace->id] )}}" method="POST" enctype="multipart/form-data" id="sellers_submit_form">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                @if(Auth::user()->workplace->sellers_list == "REJECTED" || !Auth::user()->workplace->sellers_list)
                        <a class="btn bg-deep-purple btn-xs waves-effect" style="margin-right:10px" href="{{route('sellers.create', app()->getLocale())}}">
                            <i class="material-icons">playlist_add</i>
                            <span>{{__('ADD NEW SELLER')}}</span>
                        </a>
                @if(count(Auth::user()->workplace->sellers) > 0)
                        <button type="submit" style="margin-right:10px" class="btn bg-green btn-xs waves-effect" name="sellers_list" value="submit">
                            <i class="material-icons">check</i>
                            <span>{{__('SUBMIT LIST')}}</span>
                        </button>
                @elseif(Auth::user()->workplace->sellers_list == "APPROVED")
                        <button type="submit" style="margin-right:10px" class="btn bg-teal btn-xs waves-effect" name="sellers_list" value="edit_req">
                            <i class="material-icons">edit</i>
                            <span>{{__('REQUEST CHANGES')}}</span>
                        </button>
                    </form>
                @endif
                @endif
            </div>
        </div>
        @endif

        @if(Gate::allows('admin') || Gate::allows('sys_admin'))
            <div class="card">
                <div class="body">
                    
                    <table id="workplaces_table" class="display">
                        <thead>
                            <tr>
                                <th>{{__('Division Name')}}</th>
                                <th>{{__('Contact No.')}}</th>
                                <th>{{__('Wholesale Sellers List')}}</th>
                                <th>{{__('Action')}}</th>
                                
                            </tr>
                        </thead>
                            
                    </table>
                    <br />
                </div>
            </div>


        @endif



    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script >
    @if(session()->has('message'))
        $.notify({
            message: '{{ session()->get('message') }}'
        },{
            type: '{{session()->get('alert-type')}}',
            delay: 5000,
            offset: {x: 50, y:100}
        },
        );
    @endif
    </script>


</section>
@endsection