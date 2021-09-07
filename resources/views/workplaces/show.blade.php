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
                                <li >
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
                                                <li c>
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
                                        <li>
                                            <a href="{{route('travelpasses.index', app()->getLocale())}}">{{__('View Travel Pass Entries')}}</a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{route('travelpasses.create', app()->getLocale())}}">{{__('Add New Request')}}</a>
                                        </li>    

                                        <li class="active">
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
                <h2>{{__('WHOLESALE SELLERS OF')}} @php echo strtoupper($workplace->name) @endphp</h2>
        </div>
        
        @if(Gate::allows('admin') || Gate::allows('sys_admin'))
        <div class="card">
            <div class="body">
                
                <table id="workplaces_sellers_table" class="display">
                    <thead>
                        <tr>
                            <th>{{__('Seller Name')}}</th>
                            <th>{{__('Seller Address')}}</th>
                            <th>{{__('Seller NIC No.')}}</th>
                            
                        </tr>
                    </thead>
                        
                </table>
                <br />
                <b>Wholesale Sellers List Status: </b> 
                @if($workplace->sellers_list)
                    @if($workplace->sellers_list == "SUBMITTED")
                        <p class="font-bold col-blue" style="display:inline">{{$workplace->sellers_list}}</p>
                        <br />
                        <br /> 
                    @elseif($workplace->sellers_list == "APPROVED")  
                        <p class="font-bold col-green" style="display:inline">{{$workplace->sellers_list}}</p>
                        <br />
                        <br /> 
                    @elseif($workplace->sellers_list == "REJECTED")
                        <p class="font-bold col-red" style="display:inline">{{$workplace->sellers_list}} (Reason: {{$workplace->rejection_reason}})</p>
                        <br />
                        <br />
                    @elseif($workplace->sellers_list == "CHANGE REQUESTED")
                    <p class="font-bold col-teal" style="display:inline">{{$workplace->sellers_list}}</p>
                    <br />
                    <br />
                    @endif 
                @else
                    <p class="font-bold col-orange" style="display:inline">NOT SUBMITTED</p>
                    <br />
                    <br />   
                @endif

                <form action="{{ route('workplaces.update', [app()->getLocale(), $workplace->id] )}}" method="POST" enctype="multipart/form-data" id="sellers_submit_form">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn bg-grey btn-xs waves-effect" style="margin-right:10px" href="{{route('sellers.index', app()->getLocale())}}">
                            <i class="material-icons">keyboard_backspace</i>
                            <span>{{__('BACK')}}</span>
                        </a>
                @if($workplace->sellers_list == "SUBMITTED")
                        <button type="submit" style="margin-right:10px" class="btn bg-green btn-xs waves-effect" name="sellers_list" value="approve">
                            <i class="material-icons">check</i>
                            <span>{{__('APPROVE LIST')}}</span>
                        </button>
                        <button type="button" style="margin-right:10px" class="btn bg-red btn-xs waves-effect" data-toggle="collapse" data-target="#rejectSellersList" aria-expanded="false" aria-controls="rejectSellersList">
                            <i class="material-icons">clear</i>
                            <span>{{__('REJECT LIST')}}</span>
                        </button>
                @elseif($workplace->sellers_list == "CHANGE REQUESTED")
                        <button type="submit" style="margin-right:10px" class="btn bg-teal btn-xs waves-effect" name="sellers_list" value="allow_edit">
                            <i class="material-icons">thumb_up</i>
                            <span>{{__('ALLOW CHANGES')}}</span>
                        </button>
                    </form>
                @endif

                <br /><br />
                <div class="collapse" id="rejectSellersList" aria-expanded="false" style="height: 0px;">
                    <div class="well">
                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                            <form action="{{ route('workplaces.update', [app()->getLocale(), $workplace->id] )}}" method="POST" enctype="multipart/form-data" id="accept_travelpass_form">
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
                                            <label class="form-label">{{__('Reason for Rejection')}}</label>
                                            </td>
                                            <td>
                                                
                                            <input type="text" name="reject_remarks" class="form-control" > 
                                                    
                                            </td>  <td></td>     
                                            <td>
                                                <button type="submit" style="margin-right:10px" name="sellers_list" value="reject" class="btn bg-green btn-xs waves-effect" >
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
            </div>
        </div>
        @endif




    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
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

    $('#workplaces_sellers_table').DataTable({
        
        retrieve: true,
        dom: 'Blfrtip',
        autoWidth: false,
        processing : true,
        serverSide : true,
        ajax: "{{ route('workplaces.show', [app()->getLocale(), $workplace->id]) }}",
        
        
        columns: [
        {data: 'name'},
        {data: 'address'},
        {data: 'nic_no'},


        ],

        buttons: [
            'colvis'
        ],
        "order": [],
   
            
    } );

    
    </script>


</section>
@endsection