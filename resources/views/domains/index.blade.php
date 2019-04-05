@extends('layouts.app')

@section('domains-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-domains-active')
    m-menu__item--active
@endsection

@section('page-styles') 

@endsection

@section('content')

<div domains></div>


<!-- <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
         <form method="POST" action="{{url('domains')}}" id="addDomain"/>
            @csrf
             <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">New Domain</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                   <p class="small">Fill up the form to add a new domain.</p>
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
                        <label class="form-label">{{ __('URL') }}*</label>
                            <input id="url" type="text" required placeholder="{{ __('URL') }}*" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" autofocus>
                            @if ($errors->has('url'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                        <label class="form-label">{{ __('Memberium Auth Key') }}*</label>
                            <input id="memberium" type="text" required placeholder="{{ __('Memberium Auth Key') }}*" class="form-control{{ $errors->has('memberium') ? ' is-invalid' : '' }}" name="memberium" autofocus>
                            @if ($errors->has('memberium'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('memberium') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                        <label class="form-label">{{ __('Password Generated Tag') }}*</label>
                            <input id="tag" type="text" required placeholder="{{ __('Password Generated Tag') }}*" class="form-control{{ $errors->has('tag') ? ' is-invalid' : '' }}" name="tag" autofocus>
                            @if ($errors->has('tag'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('tag') }}</strong>
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
         </form>
    </div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
    <form method="POST" action="{{url('domains/edit')}}" id="editDomain"/>
        @csrf
             <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Domain</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
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
                        <label class="form-label">{{ __('URL') }}*</label>
                            <input id="edit_url" type="text" required placeholder="{{ __('URL') }}*" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" autofocus>
                            @if ($errors->has('url'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                        <label class="form-label">{{ __('Memberium Auth Key') }}*</label>
                            <input id="edit_mem" type="text" required placeholder="{{ __('Memberium Auth Key') }}*" class="form-control{{ $errors->has('memberium') ? ' is-invalid' : '' }}" name="memberium" autofocus>
                            @if ($errors->has('memberium'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('memberium') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-2">
                        <label class="form-label">{{ __('Password Generated Tag') }}*</label>
                            <input id="edit_tag" type="text" required placeholder="{{ __('Password Generated Tag') }}*" class="form-control{{ $errors->has('tag') ? ' is-invalid' : '' }}" name="tag" autofocus>
                            @if ($errors->has('tag'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('tag') }}</strong>
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
            $(document).on('click', '.new-domain-btn', function() {
                $('#modalAdd').modal('show');
            })
            $(document).on('click', '.btn-edit-domain', function() {
                        $('#modalEdit').modal('show');
                        var name =  $(this).attr('data-name');
                        var url =  $(this).attr('data-url');
                        var mem =  $(this).attr('data-mem');
                        var tag =  $(this).attr('data-tag');
                        var id =  $(this).attr('data-id');
                        $('#hiddeneditid').val(id);
                        $('#edit_name').val(name);
                        $('#edit_url').val(url);
                        $('#edit_mem').val(mem);
                        $('#edit_tag').val(tag);

            });
        })();
    </script>
@endsection

@section('page-snippets')
    
@endsection


