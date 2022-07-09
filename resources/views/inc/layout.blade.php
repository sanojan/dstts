<!DOCTYPE html>
<html>
@inject('app', 'Illuminate\Contracts\Foundation\Application')
@inject('urlGenerator', 'Illuminate\Routing\UrlGenerator')
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>DS-TTS</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-16x16.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('plugins/animate-css/animate.css')}}" rel="stylesheet" />
    
    <!-- Morris Css -->
    
    <!-- ChartJs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
    <!-- Datatables Css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css"/>
    
    <!-- Dropdown with search-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Custom Css -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('css/theme-light-blue.css')}}" rel="stylesheet" />
</head>

<body class="ls-closed theme-light-blue">


    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-light-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="#" class="bars"></a>
                <a class="navbar-brand" href="{{route('home', app()->getLocale())}}">TASK TRACKING SYSTEM</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                
                    <!-- Call Search -->
                    <li><a href="#" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Language Switcher -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">language</i>
                            <span class="label-count">
                            @if(app()->getLocale() == "en")
                                EN
                                @elseif(app()->getLocale() == "si")
                                සි
                                @elseif(app()->getLocale() == "ta")
                                த
                            @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">CHOOSE YOUR LANGUAGE</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                    <a href="{{ $urlGenerator->toLanguage('en') }}">
                                            
                                            <div class="menu-info">
                                                <h4>ENGLISH</h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $urlGenerator->toLanguage('si') }}">
                                            
                                            <div class="menu-info">
                                                <h4>සිංහල</h4>
                                                
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $urlGenerator->toLanguage('ta') }}">
                                            
                                            <div class="menu-info">
                                                <h4>தமிழ்</h4>
                                                
                                            </div>
                                        </a>
                                    </li>
                                        
                                        
                                    
                                </ul>
                            </li>
                            
                        </ul>
                    </li>
                    <!--Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            @if(count(Auth::user()->unreadNotifications) > 0)
                            <span class="label-count">{{count(Auth::user()->unreadNotifications)}}</span>
                            @endif
                        </a>
                        
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    @forelse(Auth::user()->unreadNotifications as $notification)
                                        @if(class_basename($notification->type) == "NewTask")
                                            <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                <a href="{{ route('tasks.show', [app()->getLocale(), $notification->data['task']['id']]) }}" >   
                                                    <div class="icon-circle bg-light-blue">
                                                        <i class="material-icons">playlist_add_check</i>
                                                    </div>
                                                    <div class="menu-info">
                                                        <h4>New Task from {{$notification->data['assigned_by']['name']}}</h4>
                                                        <p>
                                                            <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['task']['created_at'])->diffForHumans()}}
                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif

                                        @if(class_basename($notification->type) == "UpdateTask")
                                            @if($notification->data['history']['status'] == "Accepted")
                                                <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                    <a href="{{ route('tasks.show', [app()->getLocale(), $notification->data['task']['id']]) }}" >   
                                                        <div class="icon-circle bg-green">
                                                            <i class="material-icons">done</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>Your task has been Accepted!</h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['history']['created_at'])->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($notification->data['history']['status'] == "Rejected")
                                                <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                    <a href="{{ route('tasks.show', [app()->getLocale(), $notification->data['task']['id']]) }}" >   
                                                        <div class="icon-circle bg-red">
                                                            <i class="material-icons">close</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>Your task has been Rejected!</h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['history']['created_at'])->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($notification->data['history']['status'] == "Forwarded")
                                                <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                    <a href="{{ route('tasks.show', [app()->getLocale(), $notification->data['task']['id']]) }}" >   
                                                        <div class="icon-circle bg-deep-purple">
                                                            <i class="material-icons">fast_forward</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>Your task has been Forwarded!</h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['history']['created_at'])->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($notification->data['history']['status'] == "Completed")
                                                <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                    <a href="{{ route('tasks.show', [app()->getLocale(), $notification->data['task']['id']]) }}" >   
                                                        <div class="icon-circle bg-blue">
                                                            <i class="material-icons">stars</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>Your task has been Completed!</h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['history']['created_at'])->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($notification->data['history']['status'] == "Cancelled")
                                                <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                    <a href="{{ route('tasks.show', [app()->getLocale(), $notification->data['task']['id']]) }}" >   
                                                        <div class="icon-circle bg-orange">
                                                            <i class="material-icons">cancel</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>Your task has been Cancelled!</h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['history']['created_at'])->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif

                                        @endif
                                        @if(class_basename($notification->type) == "NewUser")
                                            <li id="notification" onclick="markNotificationAsRead('{{$notification->id}}');">
                                                <a href="{{ route('users.show', [app()->getLocale(), $notification->data['user']['id']]) }}" >   
                                                    <div class="icon-circle bg-green">
                                                        <i class="material-icons">person_add</i>
                                                    </div>
                                                    <div class="menu-info">
                                                        <h4>New User has been registered</h4>
                                                        <p>
                                                            <i class="material-icons">access_time</i> {{\Carbon\Carbon::parse($notification->data['user']['created_at'])->diffForHumans()}}
                                                        </p>
                                                    </div>
                                                </a>
                                            </li>

                                        @endif

                                    @empty
                                       
                                        <div class="menu-info">
                                            <h4>No Unread Notifications</h4>
                                        </div>
                                     
                                    @endforelse
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    

                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <!--<span class="label-count">9</span> -->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                <!--
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{asset('images/user.png')}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
                    <div class="email">{{Auth::user()->designation}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{route('users.show', [app()->getLocale(), Auth::user()->id])}}"><i class="material-icons">person</i>My Profile</a></li>
                            <!--
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Test</a></li>
                            -->
                            <li role="seperator" class="divider"></li>
                            <li><a href="{{ route('logout', app()->getLocale()) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="material-icons">input</i>{{ __('Sign Out') }}</a>
                                                     <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->

    
    @yield('sidebar')
    
    <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy;2020 <a href="#">IT Unit, District Secretariat - Ampara</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.1
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
      
    </section>
    
    @yield('content')
    
<!-- Jquery Core Js -->
<script src="{{asset('plugins/jquery/jquery-2.x-git.min.js')}}" ></script>


<!-- Toastr Plugin Js -->

<!-- Bootstrap Core Js -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js
<script src="{{asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script> -->


<!-- Waves Effect Plugin Js -->
<script src="{{asset('plugins/node-waves/waves.js')}}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{{asset('plugins/jquery-countto/jquery.countTo.js')}}"></script>

<!-- Moment Plugin Js -->

<!-- slimscroll -->
<script src="{{asset('plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Notify -->
<script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

<!-- Morris Plugin Js -->




<!-- Flot Charts Plugin Js -->
<script src="{{asset('plugins/flot-charts/jquery.flot.js')}}"></script>
<script src="{{asset('plugins/flot-charts/jquery.flot.resize.js')}}"></script>
<script src="{{asset('plugins/flot-charts/jquery.flot.pie.js')}}"></script>
<script src="{{asset('plugins/flot-charts/jquery.flot.categories.js')}}"></script>
<script src="{{asset('plugins/flot-charts/jquery.flot.time.js')}}"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="{{asset('plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

<!-- Custom Js -->
<script src="{{asset('js/admin.js')}}"></script>

<!-- Demo Js -->
<script src="{{asset('js/demo.js')}}"></script>

<!-- Input Mask Plugin Js -->


<!-- Data Tables Js -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>

<!-- Dropdown with search-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<script type="text/javascript">
var locale = '{{ config('app.locale') }}';

var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

if(locale == "si"){

    $('#export_table_id').DataTable({
        retrieve: true,
            dom: 'Blfrtip',
            autoWidth: false,
            processing : true,
                serverSide : true,
                ajax: "{{ route('travelpasses.index', app()->getLocale()) }}",
                
                
                columns: [
                {data: 'created_at'},
                {data: 'travelpass_no'},
                {data: 'travelpass_type'},
                {data: 'applicant_name'},
                {data: 'applicant_address'},
                {data: 'nic_no'},
                {data: 'vehicle_type'},
                {data: 'vehicle_no'},
                {data: 'travel_date'},
                {data: 'comeback_date'},
                {data: 'reason_for_travel'},
                {data: 'travel_path'},
                {data: 'passengers_details'},
                {data: 'travel_items'},
                {data: 'travelpass_status'},
                {data: 'rejection_reason'},

                {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
           
            buttons: [
                {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                },
                title: 'Daily summary of Travel Passes-' + date,
                messageTop: 'Travel Passes details report generated from DS-TTS',
                messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
                },
                'colvis'
            ],
            "order": [],

            "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
        },
        {
            "targets": [ 2 ],
            "visible": false
        },
        {
            "targets": [ 4 ],
            "visible": false
        },
        {
            "targets": [ 5 ],
            "visible": false
        },
        {
            "targets": [ 6 ],
            "visible": false
        },
        {
            "targets": [ 7 ],
            "visible": false
        },
        {
            "targets": [ 9 ],
            "visible": false
        },
        {
            "targets": [ 10 ],
            "visible": false
        },
        {
            "targets": [ 11 ],
            "visible": false
        },
        {
            "targets": [ 12 ],
            "visible": false
        },
        {
            "targets": [ 13 ],
            "visible": false
        },
        {
            "targets": [ 15 ],
            "visible": false
        }
        ],
        "createdRow": function (row, data, index) {
            if(data.travelpass_status == "TRAVEL PASS ISSUED" || data.travelpass_status == "TRAVEL PASS RECEIVED"){
                $('td', row).eq(3).addClass("font-bold col-green");
            }
            if(data.travelpass_status == "SUBMITTED" || data.travelpass_status == "PENDING"){
                $('td', row).eq(3).addClass("font-bold col-blue");
            }
            if(data.travelpass_status == "ACCEPTED"){
                $('td', row).eq(3).addClass("font-bold col-deep-orange");
            }
            if(data.travelpass_status == "REJECTED"){
                $('td', row).eq(3).addClass("font-bold col-red");
            }
        },

        language: {
            search: "වගුවේ සොයන්න:",
            paginate: {
            first:      "පළමුවන",
            previous:   "පෙර",
            next:       "ඊලඟ",
            last:       "අවසන්"
            },
        zeroRecords:    "වගුවේ දත්ත නොමැත",
        infoEmpty:      "ඇතුළත් කිරීම් 0 න් 0 සිට 0 දක්වා පෙන්වයි",
        info:           "ඇතුළත් කිරීම් _TOTAL_ න් _START_ සිට   _END_ දක්වා පෙන්වයි",
        lengthMenu:     "ඇතුළත් කිරීම් _MENU_ ක් පෙන්වන්න",
        }
            
        } );

        $('#no_export_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
            buttons: [
                'colvis'
        ],
        language: {
            search: "වගුවේ සොයන්න:",
            paginate: {
            first:      "පළමුවන",
            previous:   "පෙර",
            next:       "ඊලඟ",
            last:       "අවසන්"
            },
        zeroRecords:    "වගුවේ දත්ත නොමැත",
        infoEmpty:      "ඇතුළත් කිරීම් 0 න් 0 සිට 0 දක්වා පෙන්වයි",
        info:           "ඇතුළත් කිරීම් _TOTAL_ න් _START_ සිට   _END_ දක්වා පෙන්වයි",
        lengthMenu:     "ඇතුළත් කිරීම් _MENU_ ක් පෙන්වන්න",
        }
            
        } );

        $('#sellers_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('sellers.index', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'address'},
        {data: 'nic_no'},
        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        

        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2]
            },
            title: 'List of Wholesale sellers -' + date,
            messageTop: 'Wholesale seller details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],
        "order": [],
   
            
    } );

    $('#workplaces_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('workplaces.all', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'contact_no'},
        {data: 'sellers_list'},
        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        buttons: [
            'colvis'
        ],
        "order": [],

        "createdRow": function (row, data, index) {
            if(data.sellers_list == "SUBMITTED"){
                $('td', row).eq(2).addClass("font-bold col-blue");
            }
            if(data.sellers_list == "APPROVED"){
                $('td', row).eq(2).addClass("font-bold col-green");
            }
            if(data.sellers_list == "REJECTED"){
                $('td', row).eq(2).addClass("font-bold col-red");
            }
            if(data.sellers_list == "CHANGE REQUESTED"){
                $('td', row).eq(2).addClass("font-bold col-teal");
            }
        },
   
            
    } );
} 
if(locale == "ta"){

    $('#export_table_id').DataTable({
        retrieve: true,
            dom: 'Blfrtip',
            autoWidth: false,
            processing : true,
                serverSide : true,
                ajax: "{{ route('travelpasses.index', app()->getLocale()) }}",
                
                
                columns: [
                {data: 'created_at'},
                {data: 'travelpass_no'},
                {data: 'travelpass_type'},
                {data: 'applicant_name'},
                {data: 'applicant_address'},
                {data: 'nic_no'},
                {data: 'vehicle_type'},
                {data: 'vehicle_no'},
                {data: 'travel_date'},
                {data: 'comeback_date'},
                {data: 'reason_for_travel'},
                {data: 'travel_path'},
                {data: 'passengers_details'},
                {data: 'travel_items'},
                {data: 'travelpass_status'},
                {data: 'rejection_reason'},

                {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
           
            buttons: [
                {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                },
                title: 'Daily summary of Travel Passes-' + date,
                messageTop: 'Travel Passes details report generated from DS-TTS',
                messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
                },
                'colvis'
            ],
            "order": [],

            "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
        },
        {
            "targets": [ 2 ],
            "visible": false
        },
        {
            "targets": [ 4 ],
            "visible": false
        },
        {
            "targets": [ 5 ],
            "visible": false
        },
        {
            "targets": [ 6 ],
            "visible": false
        },
        {
            "targets": [ 7 ],
            "visible": false
        },
        {
            "targets": [ 9 ],
            "visible": false
        },
        {
            "targets": [ 10 ],
            "visible": false
        },
        {
            "targets": [ 11 ],
            "visible": false
        },
        {
            "targets": [ 12 ],
            "visible": false
        },
        {
            "targets": [ 13 ],
            "visible": false
        },
        {
            "targets": [ 15 ],
            "visible": false
        }
        ],
        "createdRow": function (row, data, index) {
            if(data.travelpass_status == "TRAVEL PASS ISSUED" || data.travelpass_status == "TRAVEL PASS RECEIVED"){
                $('td', row).eq(3).addClass("font-bold col-green");
            }
            if(data.travelpass_status == "SUBMITTED" || data.travelpass_status == "PENDING"){
                $('td', row).eq(3).addClass("font-bold col-blue");
            }
            if(data.travelpass_status == "ACCEPTED"){
                $('td', row).eq(3).addClass("font-bold col-deep-orange");
            }
            if(data.travelpass_status == "REJECTED"){
                $('td', row).eq(3).addClass("font-bold col-red");
            }
        },
        
        language: {
            search: "தேடுக:",
            paginate: {
            first:      "முதல்",
            previous:   "முந்தையது",
            next:       "அடுத்தது",
            last:       "கடந்த"
        },
        zeroRecords:    "அட்டவணையில் தரவு இல்லை",
        infoEmpty:      "0 முதல் 0 வரையிலான உள்ளீடுகளைக் காட்டுகிறது",
        info:           "_TOTAL_ உள்ளீடுகளில் _START_ முதல் _END_ வரையான உள்ளீடுகள்",
        lengthMenu:     "_MENU_ உள்ளீடுகளைக் காட்டு",
        }
    } );

    $('#no_export_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
            buttons: [
                'colvis'
        ],
        language: {
            search: "தேடுக:",
            paginate: {
            first:      "முதல்",
            previous:   "முந்தையது",
            next:       "அடுத்தது",
            last:       "கடந்த"
        },
        zeroRecords:    "அட்டவணையில் தரவு இல்லை",
        infoEmpty:      "0 முதல் 0 வரையிலான உள்ளீடுகளைக் காட்டுகிறது",
        info:           "_TOTAL_ உள்ளீடுகளில் _START_ முதல் _END_ வரையான உள்ளீடுகள்",
        lengthMenu:     "_MENU_ உள்ளீடுகளைக் காட்டு",
        }
            
        } );

        $('#sellers_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('sellers.index', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'address'},
        {data: 'nic_no'},
        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        

        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2]
            },
            title: 'List of Wholesale sellers -' + date,
            messageTop: 'Wholesale seller details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],
        "order": [],
   
            
    } );

    $('#workplaces_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('workplaces.all', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'contact_no'},
        {data: 'sellers_list'},
        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        buttons: [
            'colvis'
        ],
        "order": [],

        "createdRow": function (row, data, index) {
            if(data.sellers_list == "SUBMITTED"){
                $('td', row).eq(2).addClass("font-bold col-blue");
            }
            if(data.sellers_list == "APPROVED"){
                $('td', row).eq(2).addClass("font-bold col-green");
            }
            if(data.sellers_list == "REJECTED"){
                $('td', row).eq(2).addClass("font-bold col-red");
            }
            if(data.sellers_list == "CHANGE REQUESTED"){
                $('td', row).eq(2).addClass("font-bold col-teal");
            }
        },
   
            
    } );
}

if(locale == "en"){
    $('#travelpass_table_id').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('travelpasses.index', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'created_at'},
        {data: 'travelpass_no'},
        {data: 'travelpass_type'},
        {data: 'applicant_name'},
        {data: 'applicant_address'},
        {data: 'nic_no'},
        {data: 'vehicle_type'},
        {data: 'vehicle_no'},
        {data: 'travel_date'},
        {data: 'comeback_date'},
        {data: 'reason_for_travel'},
        {data: 'travel_path'},
        {data: 'passengers_details'},
        {data: 'travel_items'},
        {data: 'travelpass_status'},
        {data: 'rejection_reason'},

        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
            },
            title: 'Daily summary of Travel Passes-' + date,
            messageTop: 'Travel Passes details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],
        "order": [],

        "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
        },
        {
            "targets": [ 2 ],
            "visible": false
        },
        {
            "targets": [ 4 ],
            "visible": false
        },
        {
            "targets": [ 5 ],
            "visible": false
        },
        {
            "targets": [ 6 ],
            "visible": false
        },
        {
            "targets": [ 7 ],
            "visible": false
        },
        {
            "targets": [ 9 ],
            "visible": false
        },
        {
            "targets": [ 10 ],
            "visible": false
        },
        {
            "targets": [ 11 ],
            "visible": false
        },
        {
            "targets": [ 12 ],
            "visible": false
        },
        {
            "targets": [ 13 ],
            "visible": false
        },
        {
            "targets": [ 15 ],
            "visible": false
        }
        ],

        "createdRow": function (row, data, index) {
            if(data.travelpass_status == "TRAVEL PASS ISSUED" || data.travelpass_status == "TRAVEL PASS RECEIVED"){
                $('td', row).eq(3).addClass("font-bold col-green");
            }
            if(data.travelpass_status == "SUBMITTED" || data.travelpass_status == "PENDING"){
                $('td', row).eq(3).addClass("font-bold col-blue");
            }
            if(data.travelpass_status == "ACCEPTED"){
                $('td', row).eq(3).addClass("font-bold col-deep-orange");
            }
            if(data.travelpass_status == "REJECTED"){
                $('td', row).eq(3).addClass("font-bold col-red");
            }
        },
        
        
            
    } );

    $('#letters_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5]
            },
            title: 'List of Letters -' + date,
            messageTop: 'Letters details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],
        "order": [],
    } );

    $('#files_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4]
            },
            title: 'List of Files -' + date,
            messageTop: 'Files details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],

        "order": [],

        
            
    } );

    $('#complaints_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4]
            },
            title: 'List of Files -' + date,
            messageTop: 'Complaints details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],

        "order": [],

        
            
    } );


    $('#tasks_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            title: 'List of Assigned Tasks -' + date,
            messageTop: 'Tasks details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],

        "order": [],
   
            
    } );




    $('#sellers_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('sellers.index', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'address'},
        {data: 'nic_no'},
        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        

        buttons: [
            {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2]
            },
            title: 'List of Wholesale sellers -' + date,
            messageTop: 'Wholesale seller details report generated from DS-TTS',
            messageBottom: 'All rights reserved District Secretariat - Ampara \u00A92020'
            },
            'colvis'
        ],
        "order": [],
   
            
    } );

    $('#workplaces_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('workplaces.all', app()->getLocale()) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'contact_no'},
        {data: 'sellers_list'},
        {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        buttons: [
            'colvis'
        ],
        "order": [],

        "createdRow": function (row, data, index) {
            if(data.sellers_list == "SUBMITTED"){
                $('td', row).eq(2).addClass("font-bold col-blue");
            }
            if(data.sellers_list == "APPROVED"){
                $('td', row).eq(2).addClass("font-bold col-green");
            }
            if(data.sellers_list == "REJECTED"){
                $('td', row).eq(2).addClass("font-bold col-red");
            }
            if(data.sellers_list == "CHANGE REQUESTED"){
                $('td', row).eq(2).addClass("font-bold col-teal");
            }
        },
   
            
    } );

    $('#users_table_id').DataTable({
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('users.index', app()->getLocale()) }}",

        columns: [
        {data: 'name'},
        {data: 'nic'},
        {data: 'designation'},
        {data: 'workplace'},
        {data: 'user_type'},
        {data: 'created_at'},
        {data: 'account_status'},
        

        {data: 'action', name: 'action', orderable: false, searchable: false}],

        buttons: [
            'colvis'
        ],

        "order": [],

        "createdRow": function (row, data, index) {
            if(data.user_type == "sys_admin"){
                $('td', row).eq(4).text("System Admin");
            }
            if(data.user_type == "dist_admin"){
                $('td', row).eq(4).text("District Admin");
            }
            if(data.user_type == "divi_admin"){
                $('td', row).eq(4).text("Divisional Admin");
            }
            if(data.user_type == "branch_head"){
                $('td', row).eq(4).text("Branch Head");
            }
            if(data.user_type == "user"){
                $('td', row).eq(4).text("Normal User");
            }
            if(data.account_status == "1"){
                $('td', row).eq(6).text("ENABLED");
                $('td', row).eq(6).addClass("font-bold col-green");
            }
            if(data.account_status == "0"){
                $('td', row).eq(6).text("DISABLED");
                $('td', row).eq(6).addClass("font-bold col-red");
            }
            
            
        },
            
    } );

    

    
}
</script>

<script>
    function markNotificationAsRead(id){
        var path = '/en/markAsRead/' + id;
        $.get(path);
    }
</script>


<script type="text/javascript">
   $('.letter_no_dropdown').select2({
  placeholder: '{{__('Select the Letter NO')}}',
  width: 'resolve'
});

$('.assign_to_dropdown').select2({
  placeholder: '{{__('Select Officer to Assign')}}',
  width: 'resolve',
  multiple:true
});

$('.subjects_dropdown').select2({
  placeholder: '{{__('Select Subjects to Add')}}',
  width: 'resolve',
  
});

$('.file_owner_dropdown').select2({
  placeholder: '{{__('Select the File Owner')}}',
  width: 'resolve'
});

$('.file_branch_dropdown').select2({
  placeholder: '{{__('Select the File Branch')}}',
  width: 'resolve'
});
</script>
<script type="text/javascript">
  $('.task-number').countTo();
</script>

<script type="text/javascript">
function change_regno_textbox()
{
    if (document.getElementById("letter_type").value === "reg_post") {
        document.getElementById("reg_no").disabled = '';
    } else {
        document.getElementById("reg_no").value="";
        document.getElementById("reg_no").disabled = 'true';
    }
}
</script>

<script type="text/javascript">
        function change_travelpass_type()
        {
            if (document.getElementById("travelpass_type").value === "foods_goods") {
                document.getElementById("reason_for_travel").value = "";
                document.getElementById("reason_for_travel").disabled = true;
                document.getElementById("travel_goods_info").disabled= false;
                document.getElementById("comeback_goods_info").disabled= false;
                document.getElementById("travel_goods_info").required = true;
                document.getElementById("comeback_goods_info").required= true;
                document.getElementById("reason_for_travel").required= false;


            } 
            if(document.getElementById("travelpass_type").value === "private_trans") {
                document.getElementById("reason_for_travel").disabled= false;
                document.getElementById("travel_goods_info").disabled= true;
                document.getElementById("comeback_goods_info").disabled= true;
                document.getElementById("travel_goods_info").value = "";
                document.getElementById("comeback_goods_info").value= "";
                document.getElementById("travel_goods_info").required = false;
                document.getElementById("comeback_goods_info").required= false;
                document.getElementById("reason_for_travel").required= true;
            }
            
        }
        
</script>

</body>

</html>