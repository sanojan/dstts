@extends('inc.layout')

@section('sidebar')
         
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">{{__('MAIN NAVIGATION')}}</li>
                    <li class="active">
                        <a href="{{route('home', app()->getLocale())}}">
                            <i class="material-icons">dashboard</i>
                            <span>{{__('Dashboard')}}</span>
                        </a>
                    </li>
                    @if(Gate::allows('sys_admin'))
                    <li>
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
                    <li class="">
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
            <h2>{{__('DASHBOARD')}}</h2>
            </div>
            <div class="block-header">
            <h2>{{__('TOTAL STATISTICS')}}</h2>
            </div>
           <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">close</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('REJECTED APPLICATIONS')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$rejected_travelpass}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">check</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('ACCEPTED APPLICATIONS')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$accepted_travelpass}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">assignment_turned_in</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('ISSUED TRAVEL PASSES')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$issued_travelpass}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">list</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('TRAVEL PASS APPLICATIONS')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$tot_travelpass}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Gate::allows('sys_admin') || Gate::allows('admin'))
            <div class="block-header">
                @php
                $dt = Carbon\Carbon::now();
                @endphp
            <h2>{{__('TODAY SUMMARY')}} ({{$dt->format('d-m-Y')}})</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">close</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('REJECTED APPLICATIONS')}}</div>
                            @php
                            $rejected_today = 0;
                            $accepted_today = 0;
                            $issued_today = 0;
                            $total_today = 0;
                            foreach(\App\TravelPass::all() as $travelpass){
                                if($travelpass->created_at->isToday()){
                                    $total_today += 1;
                                    if($travelpass->travelpass_status == "REJECTED"){
                                        $rejected_today += 1;
                                    }
                                    elseif($travelpass->travelpass_status == "ACCEPTED"){
                                        $accepted_today += 1;
                                    }
                                    elseif(($travelpass->travelpass_status == "TRAVEL PASS ISSUED") || ($travelpass->travelpass_status == "TRAVEL PASS RECEIVED")){
                                        $issued_today += 1;
                                    }
                                }
                            }


                            @endphp
                            <div class="number count-to task-number" data-from="0" data-to="{{$rejected_today}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">check</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('ACCEPTED APPLICATIONS')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$accepted_today}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">assignment_turned_in</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('ISSUED TRAVEL PASSES')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$issued_today}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">list</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('TRAVEL PASS APPLICATIONS')}}</div>
                            <div class="number count-to task-number" data-from="0" data-to="{{$total_today}}" data-speed="1000" data-fresh-interval="20">125</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!--
            <div class="card">
                <div class="header">
                    <h2>BAR CHART</h2>
                </div>
                <div class="body"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                    <canvas id="myChart" height="50"></canvas>
                </div>
            </div>
            -->

            
            

         
        
            
            
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
        <script>
            const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            ];
            const data = {
            labels: labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(20, 192, 255)',
                borderColor: 'rgb(255, 99, 132)',
                data: [5, 10, 5, 2, 20, 30],
            }]
            };
            const config = {
            type: 'bar',
            data,
            options: {}
            };

            var myChart = new Chart(
            document.getElementById('myChart'),
            config
            );
        </script>
</section>
@endsection