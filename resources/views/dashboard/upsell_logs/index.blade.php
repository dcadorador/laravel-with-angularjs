@extends('layouts.app')

@section('dashboard-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-upsell-logs-active')
    m-menu__item--active
@endsection

@section('page-styles') 

@endsection

@section('content')

	<div upsell-logs></div>

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
