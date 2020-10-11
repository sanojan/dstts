@extends('inc.layout')

@section('sidebar')
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li >
                        <a href="{{route('home')}}">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>Letters</span>
                        </a>
                        <ul class="ml-menu">
                            
                                    <li class="active">
                                        <a href="{{route('letters.index')}}">View Letter</a>
                                    </li>
                                    <li >
                                        <a href="{{route('letters.create')}}">Add Letter</a>
                                    </li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">playlist_add_check</i>
                            <span>Tasks</span>
                            @if($new_tasks > 0)
                            <span class="badge bg-red">{{$new_tasks}} New</span>
                            @endif
                        </a>
                        <ul class="ml-menu">
                            
                                    <li>
                                        <a href="pages/widgets/cards/basic.html">View Task(s)</a>
                                    </li>
                                    @if(Gate::allows('sys_admin') || Gate::allows('admin') || Gate::allows('div_sec'))
                                    <li>
                                        <a href="pages/widgets/cards/colored.html">Assign Task</a>
                                    </li>
                                    @endif
                        </ul>
                    </li>
                    @if(Gate::allows('sys_admin'))
                    <li >
                        <a href="index.html">
                            <i class="material-icons">group</i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>System Data</span>
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
                    <li >
                        <a href="index.html">
                            <i class="material-icons">help</i>
                            <span>Help</span>
                        </a>
                    </li>
                    <li >
                        <a href="index.html">
                            <i class="material-icons">group</i>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li >
                        <a href="index.html">
                            <i class="material-icons">contact_phone</i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy;2020 <a href="javascript:void(0);">District Secretariat - Ampara</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.1
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
      
    </section>
@endsection

@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>EDIT LETTER DETAILS</h2>
            </div>
            <div class="card">
                <div class="body">
                    <form action="{{ route('letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data" id="letter_edit_form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }} 
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="letter_no" class="form-control" name="letter_no" value="{{ $letter->letter_no }}">
                                        <label class="form-label">Letter Number</label>
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
                                    <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="letter_date" name="letter_date" value="{{ $letter->letter_date }}">
                                    <label class="form-label">Letter Date</label> 
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
                                        <input type="text" id="letter_sender" class="form-control" name="letter_sender" value="{{ $letter->letter_from }}">
                                        <label class="form-label">Letter Sender</label>
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
                                        <input type="text" id="letter_title" class="form-control" name="letter_title" value="{{ $letter->letter_title }}" />
                                        <label class="form-label">Letter Title</label>
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
                                        <textarea rows="3" class="form-control no-resize" name="letter_content">{{ $letter->letter_content }}</textarea>
                                        <label class="form-label">Letter Content</label>
                                    </div>
                                    @error('letter_content')
                                            <label class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($letter->letter_scanned_copy)
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-float">
                                        <a type="button" class="btn btn-default btn-xs waves-effect" style="margin-right:10px" href="{{ Storage::url('scanned_letters/' . $letter->letter_scanned_copy) }}" target="_blank">
                                            <i class="material-icons">file_download</i>
                                        </a> 
                                        <label class="form-label">Click to view attached scanned copy</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-float">
                                    <label class="form-label">Letter Scanned Copy</label>
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
                        <a class="btn bg-grey waves-effect" style="margin-right:10px" href="{{route('letters.show', $letter->id)}}">
                            <i class="material-icons">keyboard_backspace</i>
                            <span>BACK</span>
                        </a>

                        <button type="submit" class="btn btn-success waves-effect" style="margin-right:10px">
                            <i class="material-icons">save</i>
                            <span>SAVE CHANGES</span>
                        </button>
                    </form> 
                </div>
            </div>
        </div>
</section>
@endsection