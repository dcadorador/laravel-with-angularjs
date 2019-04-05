@extends('layouts.app')

@section('dashboard-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-report-active')
    m-menu__item--active
@endsection

@section('page-styles') 
    <link href="/template/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<!-- Report's Directive / Component -->
<div reports></div>

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
