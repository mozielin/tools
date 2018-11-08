@extends('layouts.main')
@section('content')
<div class="portlet-body form">
    <!-- BEGIN FORM-->
    <form id="import" action="/import/upload" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group last">
            <label class="control-label col-md-3">Source File</label>
                <div class="col-md-9">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn green btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="excel" accept=".xlsx" value="Upload" required> </span>
                        <span class="fileinput-filename"> </span> &nbsp;
                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                    </div>
                    
                </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <a class="btn green" onclick='document.forms["import"].submit(); return false;'>
                        <i class="fa fa-check"></i> Submit</a>
                    <a href="javascript:;" class="btn btn-outline grey-salsa">Cancel</a>
                </div>
            </div>
        </div>
    </form>
    <!-- END FORM-->
    <div class="col-md-3 col-md-offset-3">
        @if (Session::has('flash_message'))
            <div class="alert alert-info fade in" style="width:300px;text-align:center;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" >&times;
                </button>
                {{ Session::get('flash_message') }}
            </div>
        @endif  
    </div>
    



@endsection