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
                    @if(Gate::allows('sys_admin') || Gate::allows('admin'))
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
                    @endif
                    
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
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">transfer_within_a_station</i>
                            <span>{{__('Travel Pass')}}</span>
                            @if(Gate::allows('sys_admin') || Gate::allows('admin'))
                            @if($new_travelpasses > 0)
                            <span class="badge bg-red">{{$new_travelpasses}} {{__('New')}}</span>
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
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">group</i>
                            <span>{{__('Users')}}</span>
                        </a>
                        @if(Gate::allows('sys_admin'))
                        <ul class="ml-menu">
                                    
                                    <li>
                                        <a href="{{route('users.create', app()->getLocale())}}">Create User</a>
                                    </li>
                                    <li>
                                        <a href="{{route('users.index', app()->getLocale())}}">View Users</a>
                                    </li>
                        </ul>
                        @endif
                    </li>
                   
                    @if(Gate::allows('sys_admin'))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>{{__('System Data')}}</span>
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
                    <li>
                        <a href="#">
                            <i class="material-icons">help</i>
                            <span>{{__('Help')}}</span>
                        </a>
                    </li>
                    <li >
                        <a href="#">
                            <i class="material-icons">group</i>
                            <span>{{__('About Us')}}</span>
                        </a>
                    </li>
                    <li >
                        <a href="#">
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
                <h2>{{__('TRAVEL PASS APPLICATION DETAILS')}}</h2>
            </div>
            <div class="card">
                        <div class="body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th ></th>
                                        <th ></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('Travel Pass Ref No.')}}:</td>
                                        <td>{{$travelpass->travelpass_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Travel Pass Type')}}:</td>
                                        @if($travelpass->travelpass_type == "private_trans")
                                        <td>{{__('For Private Transport')}}</td>
                                        @elseif($travelpass->travelpass_type == "foods_goods")
                                        <td>{{__('For Transport Foods & Essential Items')}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{__('Applicant Name')}}:</td>
                                        <td>{{$travelpass->applicant_name}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Applicant Address & Mobile No.')}}:</td>
                                        <td>{{$travelpass->applicant_address}} - {{$travelpass->mobile_no}}</td>
                                        
                                        
                                    </tr>
                                    
                                    @if($travelpass->travelpass_type == "foods_goods")
                                    <tr>
                                        <td>{{__('Business Reg.No')}}:</td>
                                        <td>{{$travelpass->business_reg_no}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Details of Foods & Essential Items during travel')}}:</td>
                                        <td>{{$travelpass->travel_items}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Details of Foods & Essential Items during return')}}:</td>
                                        <td>{{$travelpass->comeback_items}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Details of Foods & Essential Items carried before')}}:</td>
                                        <td>{{$travelpass->prev_travel_items}}</td>
                                    </tr>
                                    @endif
                                    
                                    <tr>
                                        <td>{{__('NIC No.')}}:</td>
                                        <td>{{$travelpass->nic_no}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Vehicle No & Type')}}:</td>
                                        <td>{{$travelpass->vehicle_no}} - {{$travelpass->vehicle_type}}</td>
                                        
                                    </tr>
                                    @if($travelpass->travelpass_type == "private_trans")
                                    <tr>
                                        <td>{{__('Reason For Travel')}}:</td>
                                        <td>{{$travelpass->reason_for_travel}}</td>
                                        
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('Travel Date - Return Date')}}:</td>
                                        <td>{{$travelpass->travel_date}} - @if($travelpass->comeback_date) {{$travelpass->comeback_date}} @else {{__('Applicant will not return')}}@endif</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Travel From')}}:</td>
                                        <td>{{$travelpass->travel_from}}</td>
    
                                    </tr>
                                    <tr>
                                        <td>{{__('Travel To')}}:</td>
                                        <td>{{$travelpass->travel_to}}</td>
    
                                    </tr>
                                   
                                    <tr>
                                        <td>{{__('Travel Path')}}:</td>
                                        <td>{{$travelpass->travel_path}}</td>
    
                                    </tr>
                                    @if(!$travelpass->comeback_date)
                                    <tr>
                                        <td>{{__('Remarks for not return back')}}:</td>
                                        <td>{{$travelpass->remarks_if_not_return}}</td>
    
                                    </tr>
                                    @else
                                    <tr>
                                        <td>{{__('Return From')}}:</td>
                                        <td>{{$travelpass->comeback_from}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Return To')}}:</td>
                                        <td>{{$travelpass->comeback_to}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Return Path')}}:</td>
                                        <td>{{$travelpass->comeback_path}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('Passengers Details')}}:</td>
                                        <td>{{$travelpass->passengers_details}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>{{__('Travel Pass Status')}}:</td>
                                        @if(($travelpass->travelpass_status == "SUBMITTED") || ($travelpass->travelpass_status == "EDITED"))
                                        <td class="font-bold col-blue">{{$travelpass->travelpass_status}}</td>
                                        @elseif($travelpass->travelpass_status == "ACCEPTED")
                                        <td class="font-bold col-deep-orange">{{$travelpass->travelpass_status}}</td>
                                        @elseif($travelpass->travelpass_status == "TRAVEL PASS ISSUED")
                                        <td class="font-bold col-green">{{$travelpass->travelpass_status}}</td>
                                        @elseif($travelpass->travelpass_status == "REJECTED")
                                        <td class="font-bold col-red">{{$travelpass->travelpass_status}} | Reason: {{$travelpass->rejection_reason}}</td>
                                        @endif
                                        
                                    </tr>
                                </tbody>    
                            </table>
                            
                            <div>
                            <form action="{{ route('travelpasses.update', [app()->getLocale(), $travelpass->id] )}}" method="POST" enctype="multipart/form-data" id="travelpass_accept_form">
                                <a class="btn bg-grey btn-xs waves-effect" style="margin-right:10px" href="{{route('travelpasses.index', app()->getLocale())}}">
                                    <i class="material-icons">keyboard_backspace</i>
                                    <span>BACK</span>
                                </a>
                                @if($travelpass->workplace == \Auth::user()->workplace)
                                <a type="button" style="margin-right:10px" class="btn bg-purple btn-xs waves-effect" href="{{route('travelpasses.edit', [app()->getLocale(), $travelpass->id])}}">
                                    <i class="material-icons">mode_edit</i>
                                    <span>{{__('EDIT DETAILS')}}</span>
                                </a>
                                @endif
                                @if(Gate::allows('admin'))
                                @if(($travelpass->travelpass_status == "SUBMITTED") || ($travelpass->travelpass_status == "EDITED"))
                                
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                <button type="submit" style="margin-right:10px" class="btn bg-blue btn-xs waves-effect" name="subbutton" value="accept">
                                    <i class="material-icons">check</i>
                                    <span>{{__('ACCEPT APPLICATION')}}</span>
                                </button>
                                <button type="button" style="margin-right:10px" class="btn btn-danger btn-xs waves-effect" data-toggle="collapse" data-target="#rejectTravelPass" aria-expanded="false" aria-controls="rejectTravelPass">
                                    <i class="material-icons">close</i>
                                    <span>{{__('REJECT APPLICATION')}}</span>
                                </button>
                                @elseif($travelpass->travelpass_status == "ACCEPTED")
                                <a type="button" style="margin-right:10px" class="btn bg-deep-purple btn-xs waves-effect" href="{{ route('travelpass.pdf', [app()->getLocale(), $travelpass->id] )}}" target="_blank">
                                    <i class="material-icons">file_download</i>
                                    <span>{{__('DOWNLOAD APPLICATION')}}</span>
                                </a>
                                <button type="button" style="margin-right:10px" class="btn bg-indigo btn-xs waves-effect" data-toggle="collapse" data-target="#uploadTravelPass" aria-expanded="false" aria-controls="uploadTravelPass">
                                    <i class="material-icons">send</i>
                                    <span>{{__('SEND TRAVEL PASS')}}</span>
                                </button>
                                </form>
                                @endif
                                @endif
                                @if($travelpass->travelpass_status == "TRAVEL PASS ISSUED" && Gate::allows('user'))
                                
                                <a type="button" style="margin-right:10px" class="btn bg-green btn-xs waves-effect" href="{{ Storage::url('scanned_travelpasses/' . $travelpass->travelpass_scanned_copy) }}" target="_blank">
                                    <i class="material-icons">file_download</i>
                                    <span>{{__('DOWNLOAD TRAVEL PASS')}}</span>
                                </a> 
                                @endif
                                <br /><br />
                                @if(Gate::allows('sys_admin'))
                                <form method="POST" action="{{ route('travelpasses.destroy', [app()->getLocale(), $travelpass->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-xs waves-effect" onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                                        <i class="material-icons">delete</i>
                                            <span>{{__('DELETE TRAVEL PASS')}}</span>
                                    </button>
                                </form>    
                                @endif 
                                <br />

                                <div class="collapse" id="rejectTravelPass" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('travelpasses.update', [app()->getLocale(), $travelpass->id] )}}" method="POST" enctype="multipart/form-data" id="accept_travelpass_form">
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
                                                                <button type="submit" style="margin-right:10px" name="subbutton" value="reject" class="btn bg-green btn-xs waves-effect" >
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

                                <div class="collapse" id="uploadTravelPass" aria-expanded="false" style="height: 0px;">
                                    <div class="well">
                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <form action="{{ route('travelpasses.update', [app()->getLocale(), $travelpass->id] )}}" method="POST" enctype="multipart/form-data" id="issue_travelpass_form">
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
                                                            <label class="form-label">{{__('Select Travel Pass')}}</label>
                                                            </td>
                                                            <td>
                                                                
                                                            <input type="file" name="travelpass_scanned_copy" class="form-control"> 
                                                            @error('travelpass_scanned_copy')
                                                                    <label class="error" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </label>
                                                            @enderror
                                                                    
                                                            </td>  <td></td>     
                                                            <td>
                                                                <button type="submit" style="margin-right:10px" name="subbutton" value="travelpass" class="btn bg-green btn-xs waves-effect" >
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