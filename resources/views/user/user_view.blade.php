@extends('layouts.main')
@section('content')
<!-- BEGIN CONTENT HEADER -->

<div class="container" >
  <div class="panel panel-default">
    <div class="panel-heading" >
          <p>帳號資訊</p>
    </div>    
      <div class="panel-body" >
        <div class="upper-content" >
          <div name="pic"class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" >
         
                <div class="">
                  <img src="{{$img}}" alt="" width="150" height="150" style="border-radius:50%;-webkit-border-radius: 50%;"/>
                </div>
       
            <p><label for="test">{{$img}}</label></p>

            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data"> 
                      {{csrf_field()}}
                      <div class="123"  >
                        <div class="123-left" >
                             <input type="file" class="form-control"  name="image" accept=".jpg, .jpeg, .png" value="Upload" >
                        </div>
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-primary" >上傳  <i class="glyphicon glyphicon-arrow-up"></i></button>
                        </div>
                      </div>
            </form>
          </div>

          <div class="form-horizontal form-group" >
              
              <div class="form-group form-horizontal">

              <div class="form-group col-md-12 form-horizontal">
              <label for="user_name" class="col-md-4 control-label" >用戶名稱:</label>
              <div class="col-md-8">
              <input type="text" name="user_name" class=" col-md-8 form-control" value="{{$user->name}}" readonly required>
              </div>
              </div>

              <div class="form-group col-md-12 form-horizontal">         
              <label for="email" class="col-md-4 control-label" >電子郵件:</label>
              <div class="col-md-8">
              <input type="text" name="email" class=" col-md-8 form-control" value="{{$user->email}}" readonly required>            
              </div>
              </div>


          </div>


             
          </div>


        </div><div class="col-md-3">
              <button type="button" class="btn btn-primary" onclick="location.href='{{route('user_index')}}'">
              <i class="glyphicon glyphicon-backward"></i>
                返回
              </button>
          </div>  
        </div>  

  </div>
</div>
             
<!-- END CONTENT HEADER -->

@endsection