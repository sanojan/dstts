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
                                <li >
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">playlist_add_check</i>
                                        <span>{{__('Tasks')}}</span>
                                        @if($new_tasks > 0)
                                        <span class="badge bg-red">{{$new_tasks}} {{__('New')}}</span>
                                        @endif
                                    </a>
                                    <ul class="ml-menu">
                                        
                                                <li >
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
                                <li >
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">transfer_within_a_station</i>
                                        <span>{{__('Travel Pass')}}</span>
                                        @if(Gate::allows('dist_admin'))
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
                                            <li>
                                                <a href="{{route('vehicles.index', app()->getLocale())}}">Vehicles List</a>
                                            </li>
                                            <li class="active">
                                                <a href="{{route('fuelstations.index', app()->getLocale())}}">Fuel Sheds List</a>
                                            </li>
                                        @endif
                                            <li>
                                                <a href="#">Duty Schedule</a>
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
            <h2>{{__('EDIT FUEL STATION')}}</h2>
        </div>
        <div class="card">
            <div class="body">
                <form action="{{ route('fuelstations.update', [app()->getLocale(), $fuelstation->id]) }}" method="POST" enctype="multipart/form-data" id="fuelstation_edit_form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }} 
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" class="name form-control" style="text-transform: uppercase" name="name" value="{{ $fuelstation->name }}" required>
                                    <label class="form-label">{{__('Name of Fuel Station')}}</label>
                                </div>
                                @error('name')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="address" class="address form-control" name="address" value="{{ $fuelstation->address }}" required>
                                    <label class="form-label">{{__('Address')}}</label>
                                </div>
                                @error('address')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" id="no_of_pumbs" class="no_of_pumbs form-control" name="no_of_pumbs" min="1" max="5" onKeyDown="return false" value="{{ $fuelstation->no_of_pumbs }}" required>
                                    <label class="form-label">{{__('No. of Pumbs')}}</label>
                                </div>
                                @error('no_of_pumbs')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <div class="form-line">
                                    <select class="station_type form-control " style="width:100%;" id="station_type" name="station_type" required>
                                        <option value="" @if(old('station_type')=="") selected disabled @endif>{{__('Select Station Type')}}</option>
                                        <option value="LIOC" @if(old('station_type')=="LIOC") selected @elseif($fuelstation->station_type=='LIOC') selected @endif>{{__('LIOC')}}</option>
                                        <option value="CYPETCO" @if(old('station_type')=="CYPETCO") selected @elseif($fuelstation->station_type=='CYPETCO') selected @endif>{{__('CYPETCO')}}</option>
                                    </select>
                                </div>
                                @error('station_type')
                                <label class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="contact_no" class="contact_no form-control" name="contact_no" value="{{ $fuelstation->contact_no }}" required>
                                    <label class="form-label">{{__('Contact No.')}}</label>
                                </div>
                                @error('contact_no')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="owner_name" class="owner_name form-control" name="owner_name" value="{{ $fuelstation->owner_name }}" required>
                                    <label class="form-label">{{__('Owner Name with Initials')}}</label>
                                </div>
                                @error('owner_name')
                                        <label class="error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </label>
                                @enderror
                            </div> 
                        </div>
                    </div>
                    <a class="btn bg-blue-grey waves-effect" style="margin-right:10px" href="{{route('fuelstations.index', app()->getLocale())}}">
                        <i class="material-icons">keyboard_backspace</i>
                        <span>{{__('BACK')}}</span>
                    </a>

                    <button type="submit" class="btn bg-teal waves-effect" style="margin-right:10px" name="subbutton" value="save">
                        <i class="material-icons">save</i>
                        <span>{{__('SAVE')}}</span>
                    </button>

                    <button type="submit" class="btn btn-primary waves-effect" style="margin-right:10px" name="subbutton" value="submit">
                        <i class="material-icons">send</i>
                        <span>{{__('SUBMIT')}}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $('.contact_no').inputmask('9999999999');
    });
    $('.station_type').select2({
        placeholder: '{{__('Select Station Type')}}',
        width: 'resolve'
    });
</script>
@endsection