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
                            <li class="active">
                                <a href="{{route('travelpasses.index', app()->getLocale())}}">{{__('View Travel Pass Entries')}}</a>
                            </li>
                            
                            <li >
                                <a href="{{route('travelpasses.create', app()->getLocale())}}">{{__('Add New Request')}}</a>
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
                <h2>{{__('VIEW TRAVEL PASSES')}}</h2>
            </div>
            
            <div class="card">
                <div class="body">
                    
                    <table id="export_table_id" class="display">
                        <thead>
                            <tr>
                                <th>{{__('Created At')}}</th>
                                <th>{{__('Ref No.')}}</th>
                                <th>{{__('Travel Pass Type')}}</th>
                                <th>{{__('Applicant Name')}}</th>
                                <th>{{__('Applicant Address')}}</th>
                                <th>{{__('Applicant NIC')}}</th>
                                <th>{{__('Applicant Vechicle No. & Type')}}</th>
                                <th>{{__('Travel Date')}}</th>
                                <th>{{__('Retun Date')}}</th>
                                <th>{{__('Reason For Travel')}}</th>
                                <th>{{__('Travel Path')}}</th>
                                <th>{{__('Passenger Details')}}</th>
                                <th>{{__('Items Carried During Travel')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Reason If Rejected')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                            @if(count($travelpasses) > 0)
                            <tbody>
                                @foreach($travelpasses as $travelpass)
                                <tr>
                                    <td>{{$travelpass->created_at}}</td>
                                    <td>{{$travelpass->travelpass_no}}</td>
                                    @if($travelpass->travelpass_type == "foods_goods")
                                    <td>For Essential Items & Foods</td>
                                    @elseif($travelpass->travelpass_type == "private_trans")
                                    <td>For Private Transport</td>
                                    @endif
                                    <td>{{$travelpass->applicant_name}}</td>
                                    <td>{{$travelpass->applicant_address}}</td>
                                    <td>{{$travelpass->nic_no}}</td>
                                    <td>{{$travelpass->vehicle_no}}({{$travelpass->vehicle_type}})</td>
                                    <td>{{$travelpass->travel_date}}</td>
                                    <td>{{$travelpass->comeback_date}}</td>
                                    <td>{{$travelpass->reason_for_travel}}</td>
                                    <td>{{$travelpass->travel_path}}</td>
                                    <td>{{$travelpass->passengers_details}}</td>
                                    <td>{{$travelpass->travel_items}}</td>
                                    

                                    @if(($travelpass->travelpass_status == "PENDING") || ($travelpass->travelpass_status == "SUBMITTED"))
                                    <td class="font-bold col-blue">{{$travelpass->travelpass_status}}</td>
                                    @elseif($travelpass->travelpass_status == "ACCEPTED")
                                    <td class="font-bold col-deep-orange">{{$travelpass->travelpass_status}}</td>
                                    @elseif(($travelpass->travelpass_status == "TRAVEL PASS ISSUED") ||($travelpass->travelpass_status == "TRAVEL PASS RECEIVED"))
                                    <td class="font-bold col-green">{{$travelpass->travelpass_status}}</td>
                                    @elseif($travelpass->travelpass_status == "REJECTED")
                                    <td class="font-bold col-red">{{$travelpass->travelpass_status}}</td>
                                    @endif
                                    <td>{{$travelpass->rejection_reason}}</td>
                                    <td><a class="btn bg-green btn-block btn-xs waves-effect" href="{{ route('travelpasses.show', [app()->getLocale(), $travelpass->id]) }}">
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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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