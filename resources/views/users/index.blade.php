@extends('layouts.app')

@section('users-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-users-active')
    m-menu__item--active
@endsection

@section('page-styles') 
   
@endsection

@section('content')


<div users></div>

    
<!-- <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{url('users')}}" id="addUser"/>
            @csrf
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">New User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       <p class="small">Fill up the form to create a new user.</p>
                       <br/>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                            <label class="form-label">{{ __('Name') }}*</label>
                                <input id="name" type="text" required placeholder="{{ __('Name') }}*" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                            <label class="form-label">{{ __('Password') }}*</label>
                                <input id="password" type="password" required placeholder="{{ __('Password') }}*" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autofocus>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                            <label class="form-label">{{ __('Email') }}*</label>
                                <input id="email" type="text" required placeholder="{{ __('Email') }}*" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{url('users/edit')}}" id="editUser"/>
            @csrf
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       <br/>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                            <label class="form-label">{{ __('Name') }}*</label>
                                <input id="edit_name" type="text" required placeholder="{{ __('Name') }}*" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                            <label class="form-label">{{ __('Password') }}*</label>
                                <input id="password" type="password" required placeholder="{{ __('Password') }}*" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autofocus>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-2">
                            <label class="form-label">{{ __('Email') }}*</label>
                                <input id="edit_email" type="text" required placeholder="{{ __('Email') }}*" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="hiddeneditid" name="id"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </div>
        </div>
        </form>
    </div>
</div> -->

@endsection


@section('page-scripts')
    <script type="text/javascript">
         $(window).on('load', function() {
            $('body').removeClass('m-page--loading');         
        });
    </script>

    <script>
        (function(){
            $(document).on('click', '.new-user-btn', function() {
                $('#modalAdd').modal('show');
            })
            $(document).on('click', '.btn-edit-user', function() {
                $('#modalEdit').modal('show');
                var email =  $(this).attr('data-email');
                var name =  $(this).attr('data-name');
                var id =  $(this).attr('data-id');
                $('#hiddeneditid').val(id);
                $('#edit_name').val(name);
                $('#edit_email').val(email);
            });
        })();
    </script>
@endsection

@section('page-snippets')
 
@endsection

