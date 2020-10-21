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
                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>{{__('Letters')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li >
                                        <a href="{{route('letters.index', app()->getLocale())}}">{{__('View Letter')}}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('letters.create', app()->getLocale())}}">{{__('Add Letter')}}</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    
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
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                                    <li >
                                        <a href="{{route('tasks.create', app()->getLocale())}}">{{__('Assign Task')}}</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    @if(Gate::allows('sys_admin'))
                    <li >
                        <a href="index.html">
                            <i class="material-icons">group</i>
                            <span>{{__('Users')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>{{__('System Data')}}</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="#">{{__('Designation')}}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{__('Work Place')}}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{__('Services')}}</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    <li >
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
                <h2>{{__('CREATE LETTER')}}</h2>
            </div>
            <div class="card">
                
                <div class="body">
                    <form action="{{ route('letters.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" id="letter_add_form">
                    @csrf
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="letter_no" class="form-control" name="letter_no" value="{{ old('letter_no') }}">
                                        <label class="form-label">{{__('Letter No.')}}</label>
                                    </div>
                                    @error('letter_no')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="letter_date" name="letter_date" value="{{ old('letter_date') }}">
                                    <label class="form-label">{{__('Letter Date')}}</label> 
                                    </div>
                                    @error('letter_date')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="letter_sender" class="form-control" name="letter_sender" value="{{ old('letter_sender') }}">
                                        <label class="form-label">{{__('Letter Sender')}}</label>
                                    </div>
                                    @error('letter_sender')
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
                                        <input type="text" id="letter_title" class="form-control" name="letter_title" value="{{ old('letter_title') }}" />
                                        <label class="form-label">{{__('Letter Title')}}</label>
                                    </div>
                                    @error('letter_title')
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
                                        <textarea rows="3" class="form-control no-resize" name="letter_content">{{ old('letter_content') }}</textarea>
                                        <label class="form-label">{{__('Letter Content')}}</label>
                                    </div>
                                    @error('letter_content')
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
                                    <label class="form-label">{{__('Letter Scanned Copy')}}</label>
                                    <input type="file" name="letter_scanned_copy" class="form-control"> 
                                    @error('letter_scanned_copy')
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
                        
                        <a class="btn bg-grey waves-effect" style="margin-right:10px" href="{{route('letters.index', app()->getLocale())}}">
                            <i class="material-icons">keyboard_backspace</i>
                            <span>{{__('BACK')}}</span>
                        </a>

                        
                    </form>
                </div>
            </div>
        </div>

</section>
@endsection

