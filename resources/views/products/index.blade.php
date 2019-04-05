@extends('layouts.app')

@section('products-active')
    m-menu__item--active  m-menu__item--active-tab
@endsection

@section('sub-header-products-active')
    m-menu__item--active
@endsection

@section('page-styles') 

@endsection

@section('content')

<div products></div>

@endsection


@section('page-scripts')
    <script type="text/javascript">
         $(window).on('load', function() {
            $('body').removeClass('m-page--loading');         
        });
    </script>

    <script>
        (function(){
            $(document).on('click', '.new-prod-btn', function() {
                $('#modalAdd').modal('show');
            })

            $(document).on('click', '.btn-edit-prod', function() {
                $('#modalEdit').modal('show');
                var evnt_chg_id =  $(this).attr('data-evnt-chg');
                var evnt_rfnd_id =  $(this).attr('data-evnt-rfnd');
                var evnt_sale_id =  $(this).attr('data-evnt-sale');
                var evnt_in_id =  $(this).attr('data-evnt-in');
                var sub_in_id =  $(this).attr('data-sub-in');
                var sub_act_id =  $(this).attr('data-sub-act');
                var mem_tag =  $(this).attr('data-mem-tag');
                var infs_sub_id =  $(this).attr('data-infs-sub');
                var infs_prd_id =  $(this).attr('data-infs-prod');
                var cb_sku =  $(this).attr('data-cb-sku');
                var domain_id =  $(this).attr('data-domain-id');
                var prod_name =  $(this).attr('data-name');
                var prod_id =  $(this).attr('data-id');
                $('#hiddeneditid').val(prod_id);
                $('#edit_name').val(prod_name);
                $('#edit_domain').val(domain_id);
                $('#edit_cbsku').val(cb_sku);
                $('#edit_infs_prod_id').val(infs_prd_id);
                $('#edit_infs_sub_id').val(infs_sub_id);
                $('#edit_memberium').val(mem_tag);
                $('#edit_sub_ac_tag').val(sub_act_id);
                $('#edit_sub_in_tag').val(sub_in_id);
                $('#edit_evnt_in_tag').val(evnt_in_id);
                $('#edit_evnt_sale_tag').val(evnt_sale_id);
                $('#edit_evnt_rfnd_tag').val(evnt_rfnd_id);
                $('#edit_evnt_charge_tag').val(evnt_chg_id);
            });
        })();
    </script>
@endsection

@section('page-snippets')
    
@endsection



