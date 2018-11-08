@extends('layouts.main')
@section('content')
<div class="portlet-body form">
    <!-- BEGIN FORM-->
    <form id="import" action="/import/upload_list" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label col-md-3">Templete List</label>
            <div class="col-md-3">
                    <select class="form-control" name="listname" required>
                        @foreach($list as $data)
                        <option>{{$data->listname}}</option>
                        @endforeach
                    </select>
                </div>
        </div>
        <div class="form-group last">
            <label class="control-label col-md-3">Source File</label>
                <div class="col-md-9">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn green btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span cass="fileinput-exists"> Change </span>
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



@endsection