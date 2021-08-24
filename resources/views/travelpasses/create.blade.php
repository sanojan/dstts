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
                    <li class="">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>{{__('Letters')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="{{route('letters.index', app()->getLocale())}}">{{__('View Letter')}}</a>
                                    </li>
                                    <li class="">
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
                            <li>
                                <a href="{{route('travelpasses.index', app()->getLocale())}}">{{__('View Travel Pass Entries')}}</a>
                            </li>
                            
                            <li class="active">
                                <a href="{{route('travelpasses.create', app()->getLocale())}}">{{__('Add New Request')}}</a>
                            </li>    
                            <li>
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
                <h2>{{__('REQUEST NEW TRAVEL PASS')}}</h2>
            </div>
            <div class="card">
                
                <div class="body">
                    <form action="{{ route('travelpasses.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="travelpass_add_form">
                    @csrf
                        <div class="row clearfix">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="form-line">
                                        <select class="form-control travelpass_type_dropdown" style="width:100%;" id="travelpass_type" name="travelpass_type" onChange="change_travelpass_type();">
                                        <option value="" @if(old('travelpass_type')=="") disabled selected @endif>{{__('Select Travel Pass Type')}}</option>
                                        <option value="foods_goods" @if(old('travelpass_type')=="foods_goods") selected @endif>{{__('For transporting essential goods and foods')}}</option>
                                        <option value="private_trans" @if(old('travelpass_type')=="private_trans") selected @endif>{{__('For private travel')}}</option>
                                        </select>
                                    </div>
                                        
                                    @error('travelpass_type')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                                     
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="form-line">
                                        <select class="form-control seller_dropdown" style="width:100%;" id="wholesale_seller" name="wholesale_seller" onChange="change_travelpass_type();" disabled>
                                        <option value="" @if(old('wholesale_seller')=="") disabled selected @endif>{{__('Select Wholesale Seller')}}</option>
                                        
                                        </select>
                                    </div>
                                        
                                    @error('travelpass_type')
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                    @enderror
                                </div>
                                     
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="applicant_name" class="form-control" name="applicant_name" value="{{ old('applicant_name') }}" readonly>
                                        <label class="form-label">{{__('Applicant Name')}}</label>
                                    </div>
                                    @error('applicant_name')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="applicant_address" class="form-control" name="applicant_address" value="{{ old('applicant_address') }}" readonly>
                                        <label class="form-label">{{__('Applicant Address')}}</label>
                                    </div>
                                    @error('applicant_address')
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
                                        <input type="text" id="nic_no" class="form-control" name="nic_no" value="{{ old('nic_no') }}" readonly>
                                        <label class="form-label">{{__('NIC No')}}</label>
                                    </div>
                                    @error('nic_no')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="vehicle_no" class="form-control" name="vehicle_no" value="{{ old('vehicle_no') }}">
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
                                        <select class="form-control vehicle_type_dropdown" style="width:100%;" id="vehicle_type" name="vehicle_type" onChange="change_regno_textbox();" required>
                                            <option value="" @if(old('vehicle_type')=="") selected disabled @endif>{{__('Select Vehicle Type')}}</option>
                                            <option value="Motor Bike" @if(old('vehicle_type')=="Motor Bike") selected @endif>{{__('Motor Bike')}}</option>
                                            <option value="Three Wheeler" @if(old('vehicle_type')=="Three Wheeler") selected @endif>{{__('Three Wheeler')}}</option>
                                            <option value="Car" @if(old('vehicle_type')=="Car") selected @endif>{{__('Car')}}</option>
                                            <option value="Van" @if(old('vehicle_type')=="Van") selected @endif>{{__('Van')}}</option>
                                            <option value="Public Transport" @if(old('vehicle_type')=="Public Transport") selected @endif>{{__('Public Transport')}}</option>
                                            <option value="Small Lorry" @if(old('vehicle_type')=="Small Lorry") selected @endif>{{__('Small Lorry')}}</option>
                                            <option value="Lorry" @if(old('vehicle_type')=="Lorry") selected @endif>{{__('Lorry')}}</option>
                                            <option value="Other" @if(old('vehicle_type')=="Other") selected @endif>{{__('Other')}}</option>
                                        </select>
                                    </div>
                                    @error('vehicle_type')
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
                                    <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="travel_date" name="travel_date" value="{{ old('travel_date') }}">
                                    <label class="form-label">{{__('Travel Date')}}</label> 
                                    </div>
                                    @error('travel_date')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="comeback_date" name="comeback_date" value="{{ old('comeback_date') }}">
                                    <label class="form-label">{{__('Return Date')}}</label> 
                                    </div>
                                    @error('comeback_date')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control no-resize" id="reason_for_travel" name="reason_for_travel" value="{{ old('reason_for_travel') }}">
                                        <label class="form-label">{{__('Reason for Travel')}}</label>
                                    </div>
                                    @error('reason_for_travel')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="5" class="form-control no-resize" name="passengers_info">{{ old('passengers_info') }}</textarea>
                                        <label class="form-label">{{__('Details of Passengers | i.e: Name with Initial;NIC;Name with Initial;NIC')}}</label>
                                    </div>
                                    @error('passengers_info')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">

                            <div class="col-md-6">
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" id="travel_path" class="form-control" name="travel_path" value="{{ old('travel_path') }}" required>
                                    <label class="form-label">{{__('Travel Path (Enter Main cities only) | i.e: City1;City2;City3')}}</label>
                                    </div>
                                    @error('travel_path')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                                        
                            </div>

                            <div class="col-md-6">
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" id="return_path" class="form-control" name="return_path" value="{{ old('return_path') }}" required>
                                    <label class="form-label">{{__('Return Path (Enter Main cities only) (Enter "Not Applicable" If applicant will not return) | i.e: City1;City2;City3')}}</label>
                                    </div>
                                    @error('return_path')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                                        
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="5" id="travel_goods_info" class="form-control no-resize" name="travel_goods_info">{{ old('travel_goods_info') }}</textarea>
                                        <label class="form-label">{{__('Details of Essential Food Items & Goods when Travel (Enter "Not Applicable" If no items when travel)| i.e: Category-Quantity;Category-Quantity')}}</label>
                                    </div>
                                    @error('travel_goods_info')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="5" id="comeback_goods_info" class="form-control no-resize" name="comeback_goods_info">{{ old('comeback_goods_info') }}</textarea>
                                        <label class="form-label">{{__('Details of Essential Food Items & Goods when Return (Enter "Not Applicable" If no items when return) | i.e: Category-Quantity;Category-Quantity')}}</label>
                                    </div>
                                    @error('comeback_goods_info')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect" style="margin-right:10px">Create</button> -->
                        <button type="submit" class="btn btn-primary waves-effect" style="margin-right:10px">
                            <i class="material-icons">note_add</i>
                            <span>{{__('CREATE')}}</span>
                        </button>
                        
                        <a class="btn bg-grey waves-effect" style="margin-right:10px" href="{{route('travelpasses.index', app()->getLocale())}}">
                            <i class="material-icons">keyboard_backspace</i>
                            <span>{{__('BACK')}}</span>
                        </a>

                        
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="{{asset('plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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


        $('.seller_dropdown').select2({
        placeholder: '{{__('Select Wholesale Seller')}}',
        width: 'resolve'
        });

        $('#travelpass_type').change(function(){
            var travelpasstype = $(this).val();  
            if(travelpasstype == "foods_goods"){
                $.ajax({
                    type:"GET",
                    url:"{{url('app()->getLocale()/get-sellers-list')}}",
                    success:function(res){        
                        if(res){
                            $("#applicant_name").val("");
                            $("#applicant_address").val("");
                            $("#nic_no").val("");
                            $("#wholesale_seller").prop("disabled", false);
                            $("#wholesale_seller").prop("required", true);
                            $("#applicant_name").prop("readonly", true);
                            $("#applicant_address").prop("readonly", true);
                            $("#nic_no").prop("readonly", true);
                            $("#wholesale_seller").empty();
                            $("#wholesale_seller").append('<option disabled selected>{{__('Select Wholesale Seller')}}</option>');
                            
                            
                            $.each(res,function(key,value){
                            $("#wholesale_seller").append('<option value="'+value['id']+'">'+value['name']+" "+value['nic_no']+'</option>');
                            });
                        
                        }else{
                            alert('Please get approval for your Wholesale sellers list to create Travelpass applications for transporting essential items!');
                            $("#wholesale_seller").empty();
                            $("#wholesale_seller").append('<option disabled selected>{{__('Select Wholesale Seller')}}</option>');
                            $("#applicant_name").prop("readonly", true);
                            $("#applicant_address").prop("readonly", true);
                            $("#nic_no").prop("readonly", true);
                            $("#applicant_name").val("");
                            $("#applicant_address").val("");
                            $("#nic_no").val("");
                            
                        }
                    }
                });
            }else{
                $("#wholesale_seller").prop("disabled", true);
                $("#wholesale_seller").prop("required", false);
                $("#wholesale_seller").empty();
                $("#applicant_name").prop("readonly", false);
                $("#applicant_address").prop("readonly", false);
                $("#nic_no").prop("readonly", false);
                $("#applicant_name").val("");
                $("#applicant_address").val("");
                $("#nic_no").val("");
            }   
        });

        $('#wholesale_seller').change(function(){
            var seller = $(this).val();  
            if(seller){
                $.ajax({
                    type:"GET",
                    url:"{{url('app()->getLocale()/get-seller-details')}}?seller_id="+seller,
                    success:function(res){        
                        if(res){
                            
                            $.each(res,function(key,value){
                                $('#applicant_name').val(value['name']);
                                $('#applicant_address').val(value['address']);
                                $('#nic_no').val(value['nic_no']);
                            });
                        
                        }else{
                            $("#wholesale_seller").empty();
                            $("#wholesale_seller").append('<option disabled selected>{{__('Select Wholesale Seller')}}</option>');
                            
                        }
                    }
                });
            }
        });

        </script>

</section>

<noscript>Sorry, your browser does not support JavaScript!</noscript>
@endsection

