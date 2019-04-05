@extends('layouts.app')

@section('dashboard-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-dashboard-active')
    m-menu__item--active
@endsection

@section('page-styles') 
    <link href="/template/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Dashboard
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Reports
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                <span class="m-subheader__daterange-label">
                    <span class="m-subheader__daterange-title"></span>
                    <span class="m-subheader__daterange-date m--font-brand"></span>
                </span>
                <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                    <i class="la la-angle-down"></i>
                </a>
            </span>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">

    <div class="row">
        <div class="col-md-12">
                <uib-tabset active="activeForm">
        
                  <uib-tab index="0" heading="Reports">
                    
                  </uib-tab>

                  <uib-tab index="1" heading="IPN">
                    
                  </uib-tab>

                  <uib-tab index="2" heading="Autologin Logs">
                    
                  </uib-tab>

                  <uib-tab index="3" heading="Manual Cancellations">
                    
                  </uib-tab>

                  <uib-tab index="4" heading="Memberium Cancellations">
                    
                  </uib-tab>

                  <uib-tab index="5" heading="Sync Logs">
                    
                  </uib-tab>

                </uib-tabset>
        </div>
    </div>

    <div class="main">
        <div class="card dd-mb-0">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab" aria-controls="report" aria-selected="true">Reports</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="ipn-tab" data-toggle="tab" href="#ipn" role="tab" aria-controls="ipn" aria-selected="false">IPN</a>
                </li>
           
                <li class="nav-item">
                    <a class="nav-link" id="autologin-tab" data-toggle="tab" href="#autologin" role="tab" aria-controls="autologin" aria-selected="false">Autologin Logs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="mancan-tab" data-toggle="tab" href="#mancan" role="tab" aria-controls="mancan" aria-selected="false">Manual Cancellations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="memcan-tab" data-toggle="tab" href="#memcan" role="tab" aria-controls="memcan" aria-selected="false">Memberium Cancellations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sync-tab" data-toggle="tab" href="#sync" role="tab" aria-controls="sync" aria-selected="false">Sync Logs</a>
                </li>
            </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content dd-padding-0">
            <!-- Reports -->
            <div role="tabpanel" class="tab-pane active" id="report">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Reports {{ $period }}</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ url('/home') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input class="form-control fromdatepicker" autocomplete="off" placeholder="Start Date" type="text" name="from">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input class="form-control todatepicker" autocomplete="off" placeholder="End Date" type="text" name="to">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a class="btn btn-md btn-secondary btn-condensed" href="{{ url('home') }}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-md btn-primary btn-condensed"><i class="fa fa-filter"></i> Filter</button><br/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Total Orders</th>
                                    <th>Total Refund</th>
                                    <th>Net Total</th>
                                    <th>Total Order - GA</th>
                                    <th>Total Refund - GA</th>
                                    <th>Net Total - GA</th>
                                    <th>Total Order - FB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>$ {{ $total_order_amt_dis.' ('.$total_order.')' }}</td>
                                    <td>$ {{ str_replace('-','',$total_refund_amt_dis).' ('.$total_refund.')' }}</td>
                                    <td>$ {{ $net_total.' ('.$total_order_count.')' }}</td>
                                    <td>$ {{ $total_order_ga_amt_dis.' ('.$total_order_ga.')' }}</td>
                                    <td>$ {{ $total_refund_ga_amt_dis.' ('.$total_refund_ga.')' }}</td>
                                    <td>$ {{ $net_total_ga. ' ('.$total_ga_count.')' }}</td>
                                    <td>$ {{ $total_order_fb_amt_dis.' ('.$total_order_fb.')' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                            <div class="col-md-6 text-right"><a href="#" class="btn btn-primary">View All Report</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Reports -->
            
            <!-- IPN -->
            <div role="tabpanel" class="tab-pane" id="ipn">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">IPN Logs</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ url('/home') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input class="form-control fromdatepicker" autocomplete="off" placeholder="Start Date" type="text" name="from">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input class="form-control todatepicker" autocomplete="off" placeholder="End Date" type="text" name="to">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-i-cursor"></i></span>
                                        <input class="form-control" autocomplete="off" placeholder="Search Keywords..." type="text" name="search">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group center">
                                        <a class="btn btn-md btn-secondary btn-condensed" href="{{ url('home') }}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-md btn-primary btn-condensed"><i class="fa fa-filter"></i> Filter</button><br/>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>ID</th> 
                                    <th>Receipt</th> 
                                    <th>Email</th> 
                                    <th>Transaction Type</th> 
                                    <th>Total Amount</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Affiliate</th> 
                                    <th>Status GA</th> 
                                    <th>Status FB</th> 
                                    <th>Created at</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ipnFormattedLogs as $ipnLog)
                                     <tr>
                                         <td>{{ $ipnLog->id }}</td>
                                         <td>{{ $ipnLog->receipt }}</td>
                                         <td>{{ $ipnLog->email }}</td>
                                         <td>{{ $ipnLog->trans_type }}</td>
                                         <td>{{ $ipnLog->total_amount }}</td>
                                         <td>{{ $ipnLog->product_id }}</td>
                                         <td>{{ $ipnLog->product_name }}</td>
                                         <td>{{ $ipnLog->affiliate }}</td>
                                         <td>{{ $ipnLog->processed_to_ga == 0 ? 'Pending' : 'Completed' }}</td>
                                         <td>{{ $ipnLog->processed_to_fb == 0 ? 'Pending' : ( $ipnLog->processed_to_fb == 1 ? 'Completed' : 'Skipped') }}</td>
                                         <td>{{ $ipnLog->created_at }}</td>
                                     </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of IPN -->
            
            <!-- Auto Login -->
            <div role="tabpanel" class="tab-pane" id="autologin">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Autologin Logs</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ url('/home') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input class="form-control fromdatepicker" autocomplete="off" placeholder="Start Date" type="text" name="from">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input class="form-control todatepicker" autocomplete="off" placeholder="End Date" type="text" name="to">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-i-cursor"></i></span>
                                        <input class="form-control" autocomplete="off" placeholder="Search Keywords..." type="text" name="search">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group center">
                                        <a class="btn btn-md btn-secondary btn-condensed" href="{{ url('home') }}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-md btn-primary btn-condensed"><i class="fa fa-filter"></i> Filter</button><br/>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: text-top;">ID</th>
                                        <th style="vertical-align: text-top;">Contact ID</th>
                                        <th style="vertical-align: text-top;">Email</th>
                                        <th style="vertical-align: text-top;">Receipt</th>
                                        <th style="vertical-align: text-top;">Redirect URL</th>
                                        <th style="vertical-align: text-top; width: 25px">Date Time</th>
                                        <th style="vertical-align: text-top;">Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($autologin as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>{{ $log->contact_id }}</td>
                                            <td>{{ $log->email }}</td>
                                            <td>{{ $log->receipt }}</td>
                                            <td>{{ wordwrap($log->redirect_url,50,"\n", 'true') }}</td>
                                            <td>{{ wordwrap($log->date_time,50,"\n", 'true') }}</td>
                                            <td>{{ wordwrap($log->result,20,"\n", 'true') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Auto Login -->

            <!-- Manual Cancellation -->
            <div role="tabpanel" class="tab-pane" id="mancan">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Manual Cancellations</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ url('/home') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input class="form-control fromdatepicker" autocomplete="off" placeholder="Start Date" type="text" name="from">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input class="form-control todatepicker" autocomplete="off" placeholder="End Date" type="text" name="to">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-i-cursor"></i></span>
                                        <input class="form-control" autocomplete="off" placeholder="Search Keywords..." type="text" name="search">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group center">
                                        <a class="btn btn-md btn-secondary btn-condensed" href="{{ url('home') }}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-md btn-primary btn-condensed"><i class="fa fa-filter"></i> Filter</button><br/>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: text-top;">ID</th>
                                        <th style="vertical-align: text-top;">Subscription ID</th>
                                        <th style="vertical-align: text-top;">Email</th>
                                        <th style="vertical-align: text-top;">Receipt</th>
                                        <th style="vertical-align: text-top;">Cancellation Date</th>
                                        <th style="vertical-align: text-top;">Processed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($manual_cancellation as $mancan)
                                        <tr>
                                            <td>{{ $mancan->id }}</td>
                                            <td>{{ $mancan->subscription_id }}</td>
                                            <td>{{ $mancan->email }}</td>
                                            <td>{{ $mancan->receipt }}</td>
                                            <td>{{ $mancan->cancellation_date }}</td>
                                            <td>{{ $mancan->processed }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Manual Cancellation -->

            <!-- Memberium Cancellation -->
            <div role="tabpanel" class="tab-pane" id="memcan">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Memberium Cancellation</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ url('/home') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input class="form-control fromdatepicker" autocomplete="off" placeholder="Start Date" type="text" name="from">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input class="form-control todatepicker" autocomplete="off" placeholder="End Date" type="text" name="to">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-i-cursor"></i></span>
                                        <input class="form-control" autocomplete="off" placeholder="Search Keywords..." type="text" name="search">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group center">
                                        <a class="btn btn-md btn-secondary btn-condensed" href="{{ url('home') }}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-md btn-primary btn-condensed"><i class="fa fa-filter"></i> Filter</button><br/>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: text-top;">ID</th>
                                        <th style="vertical-align: text-top;">ClickBank SKU</th>
                                        <th style="vertical-align: text-top;">Receipt</th>
                                        <th style="vertical-align: text-top;">ClickBank Result</th>
                                        <th style="vertical-align: text-top;">Email</th>
                                        <th style="vertical-align: text-top;">Tries</th>
                                        <th style="vertical-align: text-top;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($memberium_cancellation as $mlog)
                                        <tr>
                                            <td>{{ $mlog->id }}</td>
                                            <td>{{ $mlog->cb_sku }}</td>
                                            <td>{{ $mlog->cb_receipt }}</td>
                                            <td>{{ wordwrap(json_encode($mlog->cb_result),25,"\n", 'true') }}</td>
                                            <td>{{ $mlog->email }}</td>
                                            <td>{{ $mlog->tries }}</td>
                                            <td>{{ $mlog->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Memberium Cancellation -->

            <!-- Sync Logs -->
            <div role="tabpanel" class="tab-pane" id="sync">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Memberium Cancellation</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ url('/home') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input class="form-control fromdatepicker" autocomplete="off" placeholder="Start Date" type="text" name="from">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input class="form-control todatepicker" autocomplete="off" placeholder="End Date" type="text" name="to">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-i-cursor"></i></span>
                                        <input class="form-control" autocomplete="off" placeholder="Search Keywords..." type="text" name="search">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group center">
                                        <a class="btn btn-md btn-secondary btn-condensed" href="{{ url('home') }}" title="Refresh"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-md btn-primary btn-condensed"><i class="fa fa-filter"></i> Filter</button><br/>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: text-top;">ID</th>
                                        <th style="vertical-align: text-top;">Transaction</th>
                                        <th style="vertical-align: text-top;">Email</th>
                                        <th style="vertical-align: text-top;">Contact ID</th>
                                        <th style="vertical-align: text-top;">Receipt</th>
                                        <th style="vertical-align: text-top;">INFS Contact</th>
                                        <th style="vertical-align: text-top;">INFS Contact Opt In</th>
                                        <th style="vertical-align: text-top;">GDPR Tag</th>
                                        <th style="vertical-align: text-top;">INFS Subscription</th>
                                        <th style="vertical-align: text-top;">INFS Sub Result</th>
                                        <th style="vertical-align: text-top;">INFS Invoice</th>
                                        <th style="vertical-align: text-top;">INFS Next Billing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sync_logs as $sync)
                                        <tr>
                                            <td>{{ $sync->id }}</td>
                                            <td>{{ $sync->trans_status }}</td>
                                            <td>{{ $sync->email }}</td>
                                            <td>{{ $sync->contact_id }}</td>
                                            <td>{{ $sync->receipt }}</td>
                                            <td>{{ $sync->infs_contact_processing }}</td>
                                            <td>{{ $sync->infs_contact_opt_in }}</td>
                                            <td>{{ $sync->infs_gdpr_tag }}</td>
                                            <td>{{ $sync->infs_subscription_processing }}</td>
                                            <td>{{ $sync->infs_subscription_result }}</td>
                                            <td>{{ $sync->infs_invoice_result }}</td>
                                            <td>{{ $sync->infs_next_billing_result }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Last 24 hours</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Sync Logs -->
        </div>
    </div>

</div>

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