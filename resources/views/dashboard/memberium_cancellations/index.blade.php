@extends('layouts.app')

@section('dashboard-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-memberium-active')
    m-menu__item--active
@endsection

@section('page-styles') 
    
@endsection

@section('content')

<div memberium-cancellations></div>

@endsection


@section('page-scripts')
    <script src="/template/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>    
    <script type="text/javascript">
         $(window).on('load', function() {
            $('body').removeClass('m-page--loading');         
        });
    </script>
@endsection

@section('page-snippets')

@endsection
