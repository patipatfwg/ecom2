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

@endsection

@section('content')
<div class="panel">
    <div class="panel-heading bg-gray">
        <h6 class="panel-title">Register Member</h6>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body search_section">
        <div class="row">
            <!-- -->
            <!-- กรุณากรอกอีเมล หรือเบอร์โทรศัพท์มือถือ 10 หลัก , กรุณากรอกข้อมูลด้วยตัวเอง เนื่องไม่สามารถดึงข้อมูล email จาก Facebook ได้, กรุณาตรวจสอบชื่อผู้ใช้งานก่อนดำเนินการต่อ,  ชื่อผู้ใช้งานนี้ถูกลงทะเบียนแล้ว, ชื่อผู้ใช้งานสามารถใช้งานได้  -->
            <div class="form-group">
                <div class="col-md-4 col-sm-12">
                    <label>E-Mail or Mobile Phone</label>
                    {{ Form::text('text', null, [
                        'id'          => 'txt_username',
                        'class'       => 'form-control',
                        'placeholder' => 'sample@sample.com / 099xxxxxxx'
                    ]) }}
                </div>           
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-4 col-sm-12">
                    <label>Password</label>
                        {{ Form::password('txt_password', null, [
                            'id'          => 'txt_password',
                            'class'       => 'form-control',
                            'placeholder' => 'Input Password'
                    ]) }}
                </div>  
            </div>
        </div>
        <div class="row">
            <div class="form-group">              
                <div class="col-md-4 col-sm-12">
                    <label>Confirm Password</label>
                        {{ Form::password('txt_confirm_password', null, [
                            'id'          => 'txt_confirm_password',
                            'class'       => 'form-control',
                            'placeholder' => 'Input Confirm Password'
                    ]) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

