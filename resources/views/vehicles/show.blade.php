@extends('inc.layout')

@section('sidebar')
         
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">{{__('MAIN NAVIGATION')}}</li>
                    <li>
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
                                                <li>
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

                            @if($subject->subject_code == "fuel")
                                <li class="active">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">local_gas_station</i>
                                        <span>{{__('Fuel Supply')}}</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @if(Gate::allows('sys_admin') || Gate::allows('dist_admin') || Gate::allows('divi_admin'))
                                            <li class="active">
                                                <a href="{{route('vehicles.index', app()->getLocale())}}">Vehicles List</a>
                                            </li>
                                            <li>
                                                <a href="{{route('fuelstations.index', app()->getLocale())}}">Fuel Sheds List</a>
                                            </li>
                                        @endif
                                            <li>
                                                <a href="#">Duty List</a>
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
            <h2>{{__('VEHICLE DETAILS')}}</h2>
        </div>
        <div class="row clearfix">
            <div class="col-md-3">
                <div class="card">
                <div class="header">
                    <h2><i class="material-icons" style="vertical-align:middle">directions_car</i><span> {{__('Vehicle Details')}}</span></h2><small class="m-l-30">{{ $vehicle->ref_no }}</small>
                    <ul class="header-dropdown m-r-0">
                        @if($vehicle->status == "SAVED")
                            <li>
                                <a href="{{route('vehicles.edit', [app()->getLocale(), $vehicle->id])}}">
                                    <i class="material-icons">edit</i>
                                </a>
                            </li>
                        @endif
                        @if(Gate::allows('dist_admin'))
                        <li>
                            <a href="#">
                                <i class="material-icons">lock</i>
                            </a>
                        </li>
                        @endif
                        @if($vehicle->print_lock == false)
                        <li>
                            <a href="#">
                                <i class="material-icons">print</i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                    <div class="body">
                        <table class="table-condensed">
                            <tbody>
                                <tr> 
                                    <th scope="row">Vehicle No:</th>
                                    <td>{{ $vehicle->vehicle_no }}</td>
                                </tr>
                                <tr> 
                                    <th scope="row">Vehicle Type:</th>
                                    <td>{{ $vehicle->vehicle_type }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Fuel Type:</th>
                                    <td>{{ $vehicle->fuel_type }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Reference No:</th>
                                    <td>{{ $vehicle->ref_no }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">DS Division:</th>
                                    <td>{{ substr($vehicle->workplace->name, 0, strpos($vehicle->workplace->name, "-")) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                <div class="header">
                    <h2><i class="material-icons" style="vertical-align:middle">person</i><span> {{__('Owner Details')}}</span></h2><small class="m-l-30">{{ $vehicle->ref_no }}</small>
                    <ul class="header-dropdown m-r-0">
                        @if($vehicle->status == "SAVED")
                            <li>
                                <a href="{{route('vehicles.edit', [app()->getLocale(), $vehicle->id])}}">
                                    <i class="material-icons">edit</i>
                                </a>
                            </li>
                        @endif
                        @if(Gate::allows('dist_admin'))
                        <li>
                            <a href="#">
                                <i class="material-icons">lock</i>
                            </a>
                        </li>
                        @endif
                        @if($vehicle->print_lock == false)
                        <li>
                            <a href="#">
                                <i class="material-icons">print</i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                    <div class="body">
                        <table class="table-condensed">
                            <tbody>
                                <tr> 
                                    <th scope="row">Owner Name:</th>
                                    <td>{{ $vehicle->owner_name }}</td>
                                </tr>
                                <tr> 
                                    <th scope="row">Owner Gender:</th>
                                    <td>{{ $vehicle->owner_gender }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Owner ID:</th>
                                    <td>{{ $vehicle->owner_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Owner Work:</th>
                                    <td>{{ $vehicle->owner_job }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Owner Workplace:</th>
                                    <td>{{ $vehicle->owner_workplace }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                <div class="header">
                    <h2><i class="material-icons" style="vertical-align:middle">home</i><span> {{__('Residential Details')}}</span></h2><small class="m-l-30">{{ $vehicle->ref_no }}</small>
                    <ul class="header-dropdown m-r-0">
                        @if($vehicle->status == "SAVED")
                            <li>
                                <a href="{{route('vehicles.edit', [app()->getLocale(), $vehicle->id])}}">
                                    <i class="material-icons">edit</i>
                                </a>
                            </li>
                        @endif
                        @if(Gate::allows('dist_admin'))
                        <li>
                            <a href="#">
                                <i class="material-icons">lock</i>
                            </a>
                        </li>
                        @endif
                        @if($vehicle->print_lock == false)
                        <li>
                            <a href="#">
                                <i class="material-icons">print</i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                    <div class="body">
                        <table class="table-condensed">
                            <tbody>
                                <tr> 
                                    <th scope="row">Permanant Address:</th>
                                    <td>{{ $vehicle->perm_address }}</td>
                                </tr>
                                <tr> 
                                    <th scope="row">Permanant District:</th>
                                    <td>{{ $vehicle->perm_district }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Temporary Address:</th>
                                    <td>{{ $vehicle->temp_address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                <div class="header">
                    <h2><i class="material-icons" style="vertical-align:middle">local_gas_station</i><span> {{__('Fuel Supply Details')}}</span></h2><small class="m-l-30">{{ $vehicle->ref_no }}</small>
                    <ul class="header-dropdown m-r-0">
                        @if($vehicle->status == "SAVED")
                            <li>
                                <a href="{{route('vehicles.edit', [app()->getLocale(), $vehicle->id])}}">
                                    <i class="material-icons">edit</i>
                                </a>
                            </li>
                        @endif
                        @if(Gate::allows('dist_admin'))
                        <li>
                            <a href="#">
                                <i class="material-icons">lock</i>
                            </a>
                        </li>
                        @endif
                        @if($vehicle->print_lock == false)
                        <li>
                            <a href="#">
                                <i class="material-icons">print</i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                    <div class="body">
                        <table class="table-condensed">
                            <tbody>
                                <tr> 
                                    <th scope="row">Consumer Type:</th>
                                    @if($vehicle->consumer_type == "O")
                                        <td>Government/Private Employees</td>
                                    @elseif($vehicle->consumer_type == "P")
                                        <td>General Public</td>
                                    @elseif($vehicle->consumer_type == "E")
                                        <td>Essential Service</td>
                                    @elseif($vehicle->consumer_type == "T")
                                        <td>Foreign Tourists</td>
                                    @endif
                                </tr>
                                <tr> 
                                    <th scope="row">Allowed Period:</th>
                                    <td>Once Per {{ $vehicle->allowed_days }} Days</td>
                                </tr>
                                <tr>
                                    <th scope="row">Created On:</th>
                                    <td>{{ $vehicle->created_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Print Lock:</th>
                                    @if($vehicle->print_lock == true)
                                        <td>LOCKED</td>
                                    @elseif($vehicle->print_lock == false)
                                        <td>UNLOCKED</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row">Status:</th>
                                    <td>{{ $vehicle->status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-header">
            <h2>{{__('FUEL CONSUMPTIONS RECORDS')}}</h2>
        </div>
        <!-- Add fuel supplies table -->
        
    </div>
</section>
@endsection

@section('scripts')
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
@endsection