<?php
$scripts = [];
?>

@extends('layouts.main')

@section('title', 'Buyers')

@section('breadcrumb')
<li class="active">Buyers</li>
@endsection

@section('header_script')@endsection
@section('footer_script')@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="row">
            Buyers
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-border-gray table-striped datatable-dom-position" id="brands-table" data-page-length="10" width="100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="check-all" autocomplete="off"></th>
                        <th>No.</th>
                        <th>Brand ID</th>
                        <th>Brand Name (TH)</th>
                        <th>Brand Name (EN)</th>
                        <th>Priority</th>
                        <th>Published</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="text-center"><i class="icon-spinner2 spinner"></i> Loading ...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection