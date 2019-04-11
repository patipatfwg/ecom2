<?php
$scripts = [
    'datatables',
    'datatablesFixedColumns',

    'select2',
    'sweetalert',
    'datetimepicker',
    'bootstrap_multiselect',
    'uniform',
];
?>

@extends('layouts.main')
@section('title', 'Create Member')
@section('breadcrumb')
<li><a href="{{ url('/member') }}">Member</a></li>
<li class="active">Create</li>
@endsection
@section('header_script')
    {{ Html::style('assets/css/dropdown.custom.css') }}
@endsection

@section('content')
<div class="panel">
    <div class="panel-heading bg-gray">
        <h6 class="panel-title">Register Member Form</h6>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
        <div class="panel-body search_section">
            <div class="col-lg-12">
                {!! Form::open([
                    'autocomplete' => 'off',
                    'class'        => 'form-horizontal',
                    'id'           => 'create_member'
                ]) !!}
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label>Email or Mobile Number</label>
                            {{ Form::text('txt_username', null, [
                                'id'          => 'username',
                                'class'       => 'form-control',
                                'placeholder' => 'Username'
                            ]) }}
                        </div>
                        <div class="col-lg-12">
                            <label>Password</label>
                            {{ Form::text('txt_password', null, [
                                'id'          => 'username',
                                'class'       => 'form-control',
                                'placeholder' => 'Username'
                            ]) }}
                        </div>
                        <div class="col-lg-12">
                            <label>Confirm Password</label>
                            {{ Form::text('txt_confirm_password', null, [
                                'id'          => 'username',
                                'class'       => 'form-control',
                                'placeholder' => 'Username'
                            ]) }}
                        </div>
                    
                        <div class="col-sm-12"><i><h4 class="text-muted" style="font-size:80%">Please enter 13 or 14 digits of your Makro Member to continue with your member privilege. If you don’t have Makro Member, please select nearby Makro store.</h4></i></div>

                        <div class="col-lg-12">
                            <label class="radio-inline"><input type="radio" value="card" id="opt_makro_member_card"> Have Makro Member</label>
                            <label class="radio-inline"><input type="radio" value="store" id="opt_makro_member_store"> Don’t have Makro Member</label>
                        </div>
                        <div class="col-lg-12">
                            {{ Form::text('email', null, [
                                'id'          => 'txt_makro_member_card',
                                'class'       => 'form-control form-control-MakroCardID pull-left',
                                'placeholder' => '1019999999999'
                            ]) }}
                        </div>
                    </div>
                </div>
                        <!-- -->
                <div class="clearfix"></div>
                <div class="row">
                    {{ Form::button('<i class="icon-plus-circle2 position-left"></i> Add New', array(
                        'type'  => 'submit',
                        'class' => 'pull-right btn bg-teal-400 btn-raised legitRipple legitRipple'
                    )) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
</div>
@endsection

