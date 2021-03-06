@extends('layouts.master')

@section('title')
  <h2 style="margin-top: 2px">修改Role</h2>
@endsection

@section('contentm')

<!--中間選單-->
<div class="container" style="width:780px;height:75px;margin-right:218px;">
  @include('layouts.user_center_block') 
</div>


<div class="container" style="width:780px;height:100%;margin-right:218px;">
  <!--最外框-->
  <div class="panel panel-default">
    <!--第一區塊-->
    <div class="panel-heading" >
      <div class="panel panel-default" > 
        <div class="panel-heading" style="text-align:center; height:40px">
          <!--區塊標題-->
          <label for="id" class="col-md-3" style="text-align:left;">ID:
          {{$data->id}}</label>
          <label for="company_name" class="col-md-6 " style="text-align:center; border-bottom:2px solid; border-bottom-color:#d3e0e9; ">
          Role
          </label>
          <label for="nothing" class="col-md-3" style="text-align:right;">Createby_</label>
        </div>
        <!--區塊內容-->
        <div class="panel-body" style="height:100%">
          <div class="form-horizontal">
          <div class="form-group col-md-12 form-horizontal">
          <form class="form-horizontal" method="POST" onsubmit="return Confirm();" action="{{ route('role_update',$data->id) }}">
                            {{ csrf_field() }}

            <label for="role_name" class="col-md-2 control-label" style="text-align:right;">Role名稱:</label>
              <div class="col-md-4">
                <input type="text" name="role_name" class=" col-md-4 form-control" value="{{$data->name}}" required>
              </div>
            
            <label for="display_name" class="col-md-2 control-label" style="text-align:right;">顯示名稱:</label>
              <div class="col-md-4">
                <input type="text" name="display_name" class=" col-md-4 form-control" value="{{$data->display_name}}" required>
                
              </div>

          </div>

          <div class="form-group col-md-12 form-horizontal">

            <label for="description" class="col-md-2 control-label" style="text-align:right;">描述:</label>
              <div class="col-md-4">
              <input type="text" name="description" class=" col-md-4 form-control ColorOrange"  value="{{$data->description}}"></div>

            <label for="updated_at" class="col-md-2 control-label" style="text-align:right;">更新時間:</label>
            <div class="col-md-4">
              <input type="text" name="updated_at" class="col-md-4 form-control ColorOrange" value="{{$data->updated_at}}" readonly>                
            </div>


          </div>
          
          <div class="col-md-12" style="border-bottom: 2px solid;border-bottom-color:#d3e0e9;margin-bottom:10px;">
          <label for="display_name" class="col-md-2 control-label" style="text-align:right;">Permission:</label>
          <label for="display_name" class="col-md-2 col-md-offset-1 control-label" style="text-align:center;">Name</label>
          <label for="display_name" class="col-md-2 col-md-offset-4 control-label" style="text-align:center;">Description</label>
          </div>

      @foreach($permission as $pedata)  
        <div class="form-group col-md-12 form-horizontal">

           <div class="col-md-2">
            <input type="radio" name="{{$pedata->id}}" id="{{$pedata->id}}" class=" col-md-2 form-control ColorOrange"  value="{{$pedata->id}}">
            </div>

            <div class="col-md-4">
            <input type="text" name="display_name_{{$pedata->id}}" class=" col-md-4 form-control ColorOrange"  value="{{$pedata->display_name}}" readonly required>  
            </div>

            <div class="col-md-4 col-md-offset-2">
            <input type="text" name="description_{{$pedata->id}}" class="col-md-4 form-control ColorOrange" value="{{$pedata->description}}" readonly required>                
            </div>

        </div>  

          @foreach($pdata as $data)
          @if($pedata->id == $data->pivot->permission_id)
            <script type="text/javascript">
              $().ready(function () {
                  $('#{{$pedata->id}}').attr('checked', true);
                  $('#{{$pedata->id}}').attr('checkSelect', 'Y');
               
              });
            </script>
          @endif 
          @endforeach
@endforeach

   
          
            <div class="col-md-12" style="border-top:2px solid; border-top-color:#d3e0e9; padding-top:10px;">
              
              <div class="col-md-2 col-md-offset-1" style="text-align:center;">
                <button type="button" class="btn btn-primary" onclick="history.back()">
                <i class="glyphicon glyphicon-backward"></i>
                返回
                </button>
              </div>

              <div class="col-md-2 col-md-offset-6" style="text-align:center;">
                <button type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-check"></i>
                                    確認修改
                </button>
              </div>
            </div>  
           
          </div><!--區塊內容結束-->
          </form>
        </div>
      </div>
    </div><!--第一區塊結束-->
  </div>
</div>
 <script type="text/javascript">
       $().ready(function () {
       //radio點擊2次取消
           //請幫radioButton加入checkSelect='N' 的屬性，若是已被選取的加上checkSelect='Y'
           $('input[type=radio]').click(function () {
               
               if ($(this).attr('checkSelect') == 'Y') {
                   $(this).attr('checked', false);
                   $(this).attr('checkSelect', 'N');
               }
               else {
                   $(this).attr('checked', true);
                   $(this).attr('checkSelect', 'Y');
               }
           });
       });
   </script>

    @endsection