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
                                        <li class="active">
                                            <a href="{{route('vehicles.index', app()->getLocale())}}">Vehicles List</a>
                                        </li>
                                        <li >
                                            <a href="#">Fuel Sheds List</a>
                                        </li>
                                        <li >
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
                <h2>{{__('EDIT VEHICLE')}}</h2>
            </div>
            <div class="card">
                <div class="body">
                    <form action="{{ route('vehicles.update', [app()->getLocale(), $vehicle->id]) }}" method="POST" enctype="multipart/form-data" id="vehicles_edit_form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }} 
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="vehicle_no" class="vehicle_no form-control" style="text-transform: uppercase" name="vehicle_no" value="{{ $vehicle->vehicle_no }}" required>
                                        <label class="form-label">{{__('Vehicle No.')}}</label>
                                    </div>
                                    @error('vehicle_no')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="form-line">
                                        <select class="vehicle_type form-control " style="width:100%;" id="vehicle_type" name="vehicle_type" required>
                                            
                                            <option value="" @if(old('vehicle_type')=="") selected disabled @endif>{{__('Select Vehicle Type')}}</option>
                                            <option value="Motor Bike" @if(old('vehicle_type')=="Motor Bike") selected @elseif($vehicle->vehicle_type=='Motor Bike') selected @endif>{{__('Motor Bike')}}</option>
                                            <option value="Three Wheeler" @if(old('vehicle_type')=="Three Wheeler") selected @elseif($vehicle->vehicle_type=='Three Wheeler') selected @endif>{{__('Three Wheeler')}}</option>
                                            <option value="Car" @if(old('vehicle_type')=="Car") selected @elseif($vehicle->vehicle_type=='Car') selected @endif>{{__('Car')}}</option>
                                            <option value="Van" @if(old('vehicle_type')=="Van") selected @elseif($vehicle->vehicle_type=='Van') selected @endif>{{__('Van')}}</option>
                                            <option value="Consumer Trucks(Pick Up/Jeep)" @if(old('vehicle_type')=="Consumer Trucks(Pick Up/Jeep)") selected @elseif($vehicle->vehicle_type=='Consumer Trucks(Pick Up/Jeep)') selected @endif>{{__('Consumer Trucks(Pick Up/Jeep)')}}</option>
                                            <option value="Small Lorry" @if(old('vehicle_type')=="Small Lorry") selected @elseif($vehicle->vehicle_type=='Small Lorry') selected @endif>{{__('Small Lorry')}}</option>
                                            <option value="SUV" @if(old('vehicle_type')=="SUV") selected @elseif($vehicle->vehicle_type=='SUV') selected @endif>{{__('SUV')}}</option>
                                            <option value="Lorry" @if(old('vehicle_type')=="Lorry") selected @elseif($vehicle->vehicle_type=='Lorry') selected @endif>{{__('Lorry')}}</option>
                                            <option value="Tractor" @if(old('vehicle_type')=="Tractor") selected @elseif($vehicle->vehicle_type=='Tractor') selected @endif>{{__('Tractor')}}</option>
                                            <option value="Other" @if(old('vehicle_type')=="Other") selected @elseif($vehicle->vehicle_type=='Other') selected @endif>{{__('Other')}}</option>
                                        </select>
                                    </div>
                                    @error('vehicle_type')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="form-line">
                                        <select class="fuel_type form-control " style="width:100%;" id="fuel_type" name="fuel_type" required>
                                            <option value="" @if(old('fuel_type')=="") selected disabled @endif>{{__('Select fuel Type')}}</option>
                                            <option value="Petrol" @if(old('fuel_type')=="Petrol") selected @elseif($vehicle->fuel_type=='Petrol') selected @endif>{{__('Petrol')}}</option>
                                            <option value="Diesel" @if(old('fuel_type')=="Diesel") selected @elseif($vehicle->fuel_type=='Diesel') selected @endif>{{__('Diesel')}}</option>
                                            <option value="Kerosene" @if(old('fuel_type')=="Kerosene") selected elseif($vehicle->fuel_type=='Kerosene') selected @endif>{{__('Kerosene')}}</option>
                                        </select>
                                    </div>
                                    @error('fuel_type')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="owner_name" class="owner_name form-control" name="owner_name" value="{{ $vehicle->owner_name }}" required>
                                        <label class="form-label">{{__('Owner\'s Name with Initials')}}</label>
                                    </div>
                                    @error('owner_name')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <div class="form-line">
                                        <select class="owner_gender form-control" style="width:100%;" id="owner_gender" name="owner_gender" required>
                                            <option value="" @if(old('owner_gender')=="") selected disabled @endif>{{__('Select Owner\'s Gender')}}</option>
                                            <option value="Male" @if(old('owner_gender')=="Male") selected @elseif($vehicle->owner_gender=='Male') selected @endif>{{__('Male')}}</option>
                                            <option value="Female" @if(old('owner_gender')=="Female") selected @elseif($vehicle->owner_gender=='Female') selected @endif>{{__('Female')}}</option>
                                            <option value="Other" @if(old('owner_gender')=="Other") selected @elseif($vehicle->owner_gender=='Other') selected @endif>{{__('Other')}}</option>
                                        </select>
                                    </div>
                                    @error('owner_gender')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="owner_nic" class="owner_nic form-control" name="owner_nic" style="text-transform: uppercase" value="@if($vehicle->consumer_type == 'T'){{ old('owner_nic') }} @else {{ $vehicle->owner_id }} @endif" @if($vehicle->consumer_type == 'T') disabled @endif>
                                        <label class="form-label">{{__('Owner\'s NIC')}}</label>
                                    </div>
                                    @error('owner_nic')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="owner_pp" class="owner_pp form-control" name="owner_pp" style="text-transform: uppercase" value="@if($vehicle->consumer_type == 'T') {{ $vehicle->owner_id }} @else {{ old('owner_pp') }} @endif" @if($vehicle->consumer_type != 'T') disabled @endif>
                                        <label class="form-label">{{__('Owner\'s Passport No.')}}</label>
                                    </div>
                                    @error('owner_pp')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="owner_job" class="owner_job form-control" name="owner_job" value="{{ $vehicle->owner_job }}" required>
                                        <label class="form-label">{{__('Owner\'s Occupation')}}</label>
                                    </div>
                                    @error('owner_job')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="owner_workplace" class="owner_workplace form-control" name="owner_workplace" value="{{ $vehicle->owner_workplace }}">
                                        <label class="form-label">{{__('Owner\'s Workplace')}}</label>
                                    </div>
                                    @error('owner_workplace')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="perm_address" class="perm_address form-control" name="perm_address" value="{{ $vehicle->perm_address }}" required>
                                        <label class="form-label">{{__('Permanant Address')}}</label>
                                    </div>
                                    @error('perm_address')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="temp_address" class="temp_address form-control" name="temp_address" value="{{ $vehicle->temp_address }}">
                                        <label class="form-label">{{__('Temporary Address')}}</label>
                                    </div>
                                    @error('temp_address')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="perm_district form-control" style="width:100%;" id="perm_district" name="perm_district" required>
                                            <option value="" @if(old('perm_district')=="") selected disabled @endif>{{__('Select Permanant District')}}</option>
                                            <option value="Ampara" @if(old('perm_district')=="Ampara") selected @elseif($vehicle->perm_district=='Ampara') selected @endif>{{__('Ampara')}}</option>
                                            <option value="Anuradhapura" @if(old('perm_district')=="Anuradhapura") selected  @elseif($vehicle->perm_district=='Anuradhapura') selected @endif>{{__('Anuradhapura')}}</option>
                                            <option value="Badulla" @if(old('perm_district')=="Badulla") selected  @elseif($vehicle->perm_district=='Badulla') selected @endif>{{__('Badulla')}}</option>
                                            <option value="Batticaloa" @if(old('perm_district')=="Batticaloa") selected  @elseif($vehicle->perm_district=='Batticaloa') selected @endif>{{__('Batticaloa')}}</option>
                                            <option value="Colombo" @if(old('perm_district')=="Colombo") selected  @elseif($vehicle->perm_district=='Colombo') selected @endif>{{__('Colombo')}}</option>
                                            <option value="Gampaha" @if(old('perm_district')=="Gampaha") selected  @elseif($vehicle->perm_district=='Gampaha') selected @endif>{{__('Gampaha')}}</option>
                                            <option value="Hambantota" @if(old('perm_district')=="Hambantota") selected  @elseif($vehicle->perm_district=='Hambantota') selected @endif>{{__('Hambantota')}}</option>
                                            <option value="Jaffna" @if(old('perm_district')=="Jaffna") selected  @elseif($vehicle->perm_district=='Jaffna') selected @endif>{{__('Jaffna')}}</option>
                                            <option value="Kalutara" @if(old('perm_district')=="Kalutara") selected  @elseif($vehicle->perm_district=='Kalutara') selected @endif>{{__('Kalutara')}}</option>
                                            <option value="Kandy" @if(old('perm_district')=="Kandy") selected  @elseif($vehicle->perm_district=='Kandy') selected @endif>{{__('Kandy')}}</option>
                                            <option value="Kegalle" @if(old('perm_district')=="Kegalle") selected  @elseif($vehicle->perm_district=='Kegalle') selected @endif>{{__('Kegalle')}}</option>
                                            <option value="Kilinochchi" @if(old('perm_district')=="Kilinochchi") selected  @elseif($vehicle->perm_district=='Kilinochchi') selected @endif>{{__('Kilinochchi')}}</option>
                                            <option value="Kurunegala" @if(old('perm_district')=="Kurunegala") selected  @elseif($vehicle->perm_district=='Kurunegala') selected @endif>{{__('Kurunegala')}}</option>
                                            <option value="Mannar" @if(old('perm_district')=="Mannar") selected  @elseif($vehicle->perm_district=='Mannar') selected @endif>{{__('Mannar')}}</option>
                                            <option value="Matale" @if(old('perm_district')=="Matale") selected  @elseif($vehicle->perm_district=='Matale') selected @endif>{{__('Matale')}}</option>
                                            <option value="Matara" @if(old('perm_district')=="Matara") selected  @elseif($vehicle->perm_district=='Matara') selected @endif>{{__('Matara')}}</option>
                                            <option value="Monaragala" @if(old('perm_district')=="Monaragala") selected  @elseif($vehicle->perm_district=='Monaragala') selected @endif>{{__('Monaragala')}}</option>
                                            <option value="Mullaitivu" @if(old('perm_district')=="Mullaitivu") selected  @elseif($vehicle->perm_district=='Mullaitivu') selected @endif>{{__('Mullaitivu')}}</option>
                                            <option value="Nuwara Eliya" @if(old('perm_district')=="Nuwara Eliya") selected  @elseif($vehicle->perm_district=='Nuwara Eliya') selected @endif>{{__('Nuwara Eliya')}}</option>
                                            <option value="Polonnaruwa" @if(old('perm_district')=="Polonnaruwa") selected  @elseif($vehicle->perm_district=='Polonnaruwa') selected @endif>{{__('Polonnaruwa')}}</option>
                                            <option value="Puttalam" @if(old('perm_district')=="Puttalam") selected  @elseif($vehicle->perm_district=='Puttalam') selected @endif>{{__('Puttalam')}}</option>
                                            <option value="Ratnapura" @if(old('perm_district')=="Ratnapura") selected  @elseif($vehicle->perm_district=='Ratnapura') selected @endif>{{__('Ratnapura')}}</option>
                                            <option value="Trincomalee" @if(old('perm_district')=="Trincomalee") selected  @elseif($vehicle->perm_district=='Trincomalee') selected @endif>{{__('Trincomalee')}}</option>
                                            <option value="Vavuniya" @if(old('perm_district')=="Vavuniya") selected  @elseif($vehicle->perm_district=='Vavuniya') selected @endif>{{__('Vavuniya')}}</option>
                                        </select>
                                    </div>
                                    @error('perm_district')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="form-line">
                                        <select class="consumer_type form-control" style="width:100%;" id="consumer_type" name="consumer_type" required>
                                            <option value="" @if(old('consumer_type')=="") selected disabled @endif>{{__('Select Consumer Type')}}</option>
                                            <option value="P" @if(old('consumer_type')=="P") selected @elseif($vehicle->consumer_type=='P') selected @endif>{{__('General Public')}}</option>
                                            <option value="O" @if(old('consumer_type')=="O") selected @elseif($vehicle->consumer_type=='O') selected @endif>{{__('Government/Private Employees')}}</option>
                                            <option value="E" @if(old('consumer_type')=="E") selected @elseif($vehicle->consumer_type=='E') selected @endif>{{__('Essential Service')}}</option>
                                            <option value="T" @if(old('consumer_type')=="T") selected @elseif($vehicle->consumer_type=='T') selected @endif>{{__('Foreign Tourists')}}</option>
                                        </select>
                                    </div>
                                    @error('consumer_type')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <p class="font-bold col-pink">Note: Select Consumer Type as "Essential Service" for Health Sector Employees, Threewheel Drivers, Itinerant Sellers and Wholesale Transporters.</p>

                        <a class="btn bg-blue-grey waves-effect" style="margin-right:10px" href="{{route('vehicles.index', app()->getLocale())}}">
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
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $('.vehicle_no').inputmask('**[*]-9999');
    });
    $(document).ready(function(){
        $('.owner_nic').inputmask('999999999*[99]');
    });

    $('.vehicle_type').select2({
        placeholder: '{{__('Select Vehicle Type')}}',
        width: 'resolve'
    });
    $('.fuel_type').select2({
        placeholder: '{{__('Select Fuel Type')}}',
        width: 'resolve'
    });
    $('.owner_gender').select2({
        placeholder: '{{__('Select Gender')}}',
        width: 'resolve'
    });
    $('.perm_district').select2({
        placeholder: '{{__('Select Permanant District')}}',
        width: 'resolve'
    });
    $('.consumer_type').select2({
        placeholder: '{{__('Select Consumer Type')}}',
        width: 'resolve'
    });

    $('#fuel_type').change(function(){
        var fuel_type = $(this).val(); 
        if(fuel_type == "Petrol"){
            $("#vehicle_no").prop("disabled", false);
            $("#vehicle_type").prop("disabled", false);
            $("#owner_job").prop("required", true);
        }
        else if(fuel_type == "Diesel"){
            $("#vehicle_no").prop("disabled", false);
            $("#vehicle_type").prop("disabled", false);
            $("#owner_job").prop("required", true);
        }
        else if(fuel_type == "Kerosene"){
            $("#vehicle_no").prop("disabled", true);
            $("#vehicle_type").prop("disabled", true);
            $("#owner_job").prop("required", false);
        }
    });

    $('#consumer_type').change(function(){
        var consumer_type = $(this).val(); 
        if(consumer_type == "T"){
            $("#owner_pp").prop("disabled", false);
            $("#owner_nic").prop("disabled", true);
            $("#perm_address").prop("required", false);
            $("#perm_district").prop("required", false);
        }
        else{
            $("#owner_pp").prop("disabled", true);
            $("#owner_nic").prop("disabled", false);
            $("#perm_address").prop("required", true);
            $("#perm_district").prop("required", true);
        }
    });
</script>
@endsection