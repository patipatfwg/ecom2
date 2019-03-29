<?php
$scripts = [
    'datatables',
    'datatablesFixedColumns',
    'select2',
    'sweetalert',
    'datetimepicker',
    'uniform',
    'bootstrap_multiselect'
];
?>

@extends('layouts.main')

@section('title', 'Treasury Report')

@section('breadcrumb')
<li class="active">Treasury Report</li>
@endsection

@section('header_script')@endsection

@section('content')
<div class="panel">
    <div class="panel-heading bg-gray">
        <h6 class="panel-title">Search</h6>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-lg-12">
            {!! Form::open([
                'autocomplete' => 'off',
                'class'        => 'form-horizontal',
                'id'           => 'search-form'
            ]) !!}
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Store</label>
                        @if(count($stores)!=1)
                            {{ Form::select('store_id', $stores, null, [
                                'id'          => 'store_id',
                                'class'       => 'form-control select2',
                                'placeholder' => 'Select ...'
                            ]) }}
                        @else
                            <input type="hidden" name="store_id" value="{{ $current_store }}">
                            {{ Form::select('store_id', $stores, null, [
                                'id'          => 'store_id',
                                'class'       => 'form-control select2',
                                'disabled'    => true
                            ]) }}
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label>Payment Channel</label>
                        <div class="input-group">
                            <div class="multi-select-full">
                                {{ Form::select('payment_type', $configs, $default_config_select, [
                                    'class'    => 'multiselect-toggle-selection hide',
                                    'multiple' => 'multiple'
                                ]) }}
                            </div>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info multiselect-toggle-selection-button">Select All</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <label>Payment Date (From)</label>
                        <?php
                        $date      = date('Y-m-d 17:00');
                        $newdate   = strtotime ('-1 day', strtotime($date));
                        $date_from = date ('Y-m-d H:i', $newdate);
                        $date_from = convertDateTime($date_from, 'Y-m-d H:i', 'd/m/Y H:i');
                        ?>
                        {{ Form::text('payment_date_from', $date_from, [
                            'id'          => 'payment_date_from',
                            'class'       => 'form-control',
                            'placeholder' => 'Payment Date From'
                        ]) }}
                    </div>
                    <div class="col-md-6">
                        <label>Payment Date (To)</label>
                        {{ Form::text('payment_date_to', date("d/m/Y 17:00"), [
                            'id'          => 'payment_date_to',
                            'class'       => 'form-control',
                            'placeholder' => 'Payment Date To'
                        ]) }}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                {{ Form::button('<i class="icon-search4"></i> Search', array(
                    'type'  => 'submit',
                    'class' => 'pull-right btn bg-teal-400 btn-raised legitRipple legitRipple'
                )) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="panel">
	<div class="panel-body table-responsive">
		<table class="table table-border-gray table-striped datatable-dom-position" id="treasury-table" data-page-length="10" width="160%">
			<thead>
				<tr>
					<th width="80">No.</th>
					<th width="200">Store&nbsp;No.</th>
					<th>Store Name</th>
					<th>Number of Transaction</th>
					<th>Order Amount (vat items)</th>
					<th>Order Amount (vat free items)</th>
                    <th>Delivery Fee</th>
					<th>Coupon Discount</th>
					<th>Order Amount</th>
					<th>Order Amount Exc Vat</th>
					<th>Payment Fee</th>
					<th>VAT of Payment Fee</th>
					<th>Net Amount</th>
					<th>W.H. TAX</th>
                    <th>Payment Gateway</th>
					<th>Payment Channel</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="14" class="text-center"><i class="icon-spinner2 spinner"></i> Loading ...</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@endsection

@section('footer_script')
<script type="text/javascript">
    "use strict";

    $.fn.dataTable.ext.errMode = 'none';

    //set tabel
    var $table = $('#treasury-table');
    var $thead = $table.find('thead');
    var $tbody = $table.find('tbody');

    //set dataTabel
    var oTable = $table.on('error.dt', function(e, settings, techNote, message) {
        new PNotify({ text: 'Error connection', type: 'error' });
    }).DataTable({
        scrollY: true,
        scrollX: '300px',
        fixedColumns:   {
            leftColumns: 2,
            heightMatch: 'none'
        },
        processing: false,
        serverSide: true,
        searching: false,
        retrieve : true,
        destroy : true,
        order: [[ 1, false ]],
        cache: true,
        pageLength: 10,
        lengthMenu: [ 10, 50, 100, 500, 1000 ],
        dom: '<"datatable-header"fl><"datatable-body"t><"datatable-footer"ip>',
        language: {
            lengthMenu: '<span>Show :</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        ajax: {
            url: $("meta[name='root-url']").attr('content') + '/report/treasury/data',
            type: 'POST',
            data: function (d) {
                d.search = $('#search-form').serializeArray();
            },
            error: function(xhr, error, thrown) {
                if(xhr.responseJSON.expired) {
                    swal({
                    title: "Error!",
                    text: 'Session Expired',
                    type: "error",
                    confirmButtonText: "OK"
                    },
                    function(){
                        location.reload();
                    });
                } else {
                    new PNotify({text: 'Error connection', type: 'error' });
                    $tbody.children().remove();
                    $tbody.append('<tr><td class="text-center" colspan="' + $thead.find('tr th').length + '">No Data, please try again later</td></tr>');
                }
            }
        },
        fnServerParams: function(data) {
            data['order'].forEach(function(items, index) {
                data['order'][index]['column'] = data['columns'][items.column]['name'];
            });
        },
        columns: [
            { data: 'number', name: 'number', width: '80px', orderable: false, searchable: false, className: 'text-center' },
            { data: 'store_id', name: 'store_id', width: '200px' },
            { data: 'store_name_th', name: 'store_name.th' },
            { data: 'number_of_transaction', name:'number_of_transaction',className:'text-right' },
            { data: 'total_amount_vat_items', name:'total_amount_vat_items',className:'text-right' },
            { data: 'total_amount_exc_vat_items', name: 'total_amount_exc_vat_items',className:'text-right' },
            { data: 'delivery_fee', name:'delivery_fee', className:'text-right'},
            { data: 'discount', name: 'discount',className:'text-right' },
            { data: 'total_amount', name: 'total_amount',className:'text-right' },
            { data: 'total_amount_exc_vat', name: 'total_amount_exc_vat',className:'text-right' },
            { data: 'payment_fee', name: 'payment_fee',className:'text-right' },
            { data: 'vat_payment_fee', name: 'vat_payment_fee',className:'text-right' },
            { data: 'net_amount', name: 'net_amount',className:'text-right' },
            { data: 'w_h_tax', name: 'w_h_tax',className:'text-right' },
            { data: 'payment_gateway', name: 'payment_gateway' },
            { data: 'payment_type', name: 'payment_type' }
        ]
    });

    $('div.datatable-header').append(`@include('common._print_button')`);

    $('.print-report').on('click', function(event) {
        event.preventDefault();
        var data   = oTable.ajax.params();
        var search = {
            start: data.start,
            length: data.length,
            search: data.search,
            order: data.order,
            report: 'print'
        };
        window.location.replace($("meta[name='root-url']").attr('content') + '/report/treasury/print?' + $.param(search));
    });
    // Initialize
    $('.multiselect-toggle-selection').multiselect();
    $(".styled, .multiselect-container input[type='checkbox']").uniform({ radioClass: 'choice'});
</script>

    @include('report._footer_script')

    @include('common._datetime_range_script', [
        'refer_start'   =>  '#payment_date_from',
        'refer_end'     =>  '#payment_date_to',
        'format_start'  =>  'd/m/Y H:i',
        'format_end'    =>  'd/m/Y H:i',
        'default_start' =>  '17:00',
        'timepicker'    => true,
        'editable'      => true
    ])
    
@endsection