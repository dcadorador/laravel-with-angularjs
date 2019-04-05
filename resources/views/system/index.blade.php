@extends('layouts.app')

@section('system-settings-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-system-settings-active')
    m-menu__item--active
@endsection

@section('page-styles') 

@endsection

@section('content')
    <div system-settings></div>
@endsection


@section('page-scripts')
    <script type="text/javascript">
         $(window).on('load', function() {
            $('body').removeClass('m-page--loading');         
        });
    </script>
@endsection

@section('page-snippets')
    
@endsection