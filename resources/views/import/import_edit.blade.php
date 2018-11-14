@extends('layouts.main')
@section('content')
<div class="row">
	<div class="col-md-8">
	    <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption font-green-seagreen">
	                <i class="fa fa-gg font-green-seagreen"></i>
	                <span class="caption-subject bold uppercase">模板列表</span>
	            </div>
	        </div>
	    
	    <table class="table table-striped table-checkable table-bordered table-hover" id='manuel'>
	        <thead>
	            <tr>
	                <td class="col-md-2">
	                    No.
	                </td>
	                <td class="col-md-4" style="text-align:center;">
	                    模板名稱
	                </td>
	                <td class="col-md-4" style="text-align:center;"> 
	                    最後更新日期
	                </td>
	                <td class="col-md-2" style="text-align:center;">
	                    #
	                </td>
	            </tr>
	        </thead>
	        <tbody>
	        	@foreach($list as $data)
		            <tr>
		                <td class="col-md-2">
		                    {{ $data->id }}
		                </td>
		                <td class="col-md-4" style="text-align:center;">
		                    {{ $data->listname }}
		                </td>
		                <td class="col-md-4" style="text-align:center;"> 
		                    {{ $data->updated_at }}
		                </td>
		                <td class="col-md-2" style="text-align:center;">
		                    <button type="button" class="btn btn-outline btn-circle dark btn-sm black" onclick="delConfirm(this)" data-href="{{URL::route('import_delete',$data->id)}}"><i class="fa fa-trash-o"/></i>
	                        	刪除
	                    	</button>
		                </td>
		            </tr>
	            @endforeach
	        </tbody>
	    </table>
	    </div>
	</div>
</div>
@endsection
@section('script')
@parent
	<script>//彈出對話框確認 
		function delConfirm(QQ){
			console.log(QQ);
			if(confirm("確認刪除此資料？")==true)   
				window.location.href = $(QQ).data('href');
			else  
			return false;}
	</script>
@endsection

