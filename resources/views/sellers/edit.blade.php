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
                <h2>{{__('EDIT WHOLESALE SELLER')}}</h2>
            </div>
            <div class="card">
                
                <div class="body">
                    <form action="{{ route('sellers.update', [app()->getLocale(), $seller->id]) }}" method="POST" enctype="multipart/form-data" id="sellers_edit_form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }} 
                        <div class="row clearfix">
                            
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="applicant_name" class="form-control" name="seller_name" value="{{ $seller->name }}">
                                        <label class="form-label">{{__('Seller Name')}}</label>
                                    </div>
                                    @error('seller_name')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="seller_address" class="form-control" name="seller_address" value="{{ $seller->address }}">
                                        <label class="form-label">{{__('Seller Address')}}</label>
                                    </div>
                                    @error('seller_address')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="nic_no" class="form-control" name="nic_no" value="{{ $seller->nic_no }}">
                                        <label class="form-label">{{__('NIC No')}}</label>
                                    </div>
                                    @error('nic_no')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>   
                        </div>
                    
                        
                        <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect" style="margin-right:10px">Create</button> -->
                        <a class="btn bg-grey btn-xs waves-effect" style="margin-right:10px" href="{{route('sellers.index', app()->getLocale())}}">
                            <i class="material-icons">keyboard_backspace</i>
                            <span>{{__('BACK')}}</span>
                        </a>
                        
                        <button type="submit" class="btn btn-primary btn-xs waves-effect" style="margin-right:10px">
                            <i class="material-icons">note_add</i>
                            <span>{{__('CHANGE')}}</span>
                        </button>
                        
                    </form>
                    <br />
                    <form method="POST" action="{{ route('sellers.destroy', [app()->getLocale(), $seller->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-danger btn-xs waves-effect" onclick="return confirm('{{__('Are you sure? You cannot revert this action.')}}')">
                            <i class="material-icons">delete</i>
                                <span>{{__('DELETE SELLER')}}</span>
                        </button>
                    </form> 
                    
                </div>
            </div>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
        <script >
        @if(session()->has('message'))
            $.notify({
                title: '<strong>Heads up!</strong>',
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

