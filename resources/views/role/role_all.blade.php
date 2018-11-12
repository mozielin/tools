@extends('layouts.main')
@section('title')
<h2 style="margin-top: 2px;">Role列表</h2>
@endsection
@section('css')
@parent
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('content')

<div class="col-md-8">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box red">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Table </div>
            <div class="actions">
                <a href="{{route('role_create')}}" class="btn btn-default btn-sm">
                    <i class="fa fa-plus"></i> Add </a>
                <a href="javascript:;" class="btn btn-default btn-sm">
                    <i class="fa fa-print"></i> Print </a>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="role_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th> Role </th>
                        <th> Role Name </th>
                        <th> Description </th>
                        <th> Status </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($data as $role)
                    <tr class="odd gradeX">
                    	<td>{{$role->id}}</td>
                        <td> {{$role->name}}</td>
                        <td>{{$role->display_name}}</td>
                        <td>{{$role->description}}</td>
                        <td>{{$role->updated_at}}</td>
                        <td>
                            <span class="label label-sm label-success"> Approved </span>
                        </td>
                    </tr>
                    @endforeach      
                </tbody>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>

@endsection

@section('script')
@parent
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>              
	$('role_table').dataTable({  
	});
</script> 
@endsection