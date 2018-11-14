@extends('layouts.main')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-blue">
            <i class="fa fa-files-o font-blue"></i>
            <span class="caption-subject bold uppercase">透過模板轉換</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form id="import" action="/import/upload_list" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="control-label col-md-3">選擇已建立之模板</label>
                <div class="col-md-3">
                        <select class="form-control" name="listname" required>
                            @foreach($list as $data)
                            <option>{{$data->listname}}</option>
                            @endforeach
                        </select>
                </div>
                <a href="javascript:;" class="close" > </a>
            </div>
            <div class="form-group last">
                <label class="control-label col-md-3">選擇欲轉換之「來源」格式檔案</label>
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn blue btn-file">
                            <span class="fileinput-new"><i class="fa fa-file-excel-o"></i> 選擇檔案 </span>
                            <span class="fileinput-exists"> 更換 </span>
                            <input type="file" name="excel" accept=".xlsx" value="Upload" required> </span>
                            <span class="fileinput-filename"> </span> &nbsp;
                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                        </div>
                    </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <label class="control-label col-md-3" style="text-align: center;">檔案支援&nbsp;.xls&nbsp;.xlsx</label>
                    <div class="col-md-9">
                        <a class="btn blue" onclick='document.forms["import"].submit(); return false;'>
                            <i class="fa fa-check"></i>轉換</a>
                        <a href="javascript:;" class="btn btn-outline grey-salsa">取消</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
@endsection