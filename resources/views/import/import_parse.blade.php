@extends('layouts.main')
@section('content')
<script src="http://code.jquery.com/jquery-1.12.0.js"></script> 
        <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.js"></script> 

        <script> 
             $(function() { 
                $('#mytable tbody').sortable({ 
               opacity: 0.6, 
               cursor: 'move', 
              axis:'y', 
                  update: function(event, ui) { 
                     var productOrder = $('#mytable tbody').sortable('toArray').toString(); 
                    $("#mydata").text (productOrder); 
                  } 
               }); 
            }); 
         </script> 

<div class="row">
     <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <form  method="POST" action="{{ route('import_process') }}">
        {{ csrf_field() }}
        <div class="col-md-6">                           
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <script type="text/javascript">
            $('#form-submit').click(function(e){
                e.preventDefault();
                var l = Ladda.create(this);
                l.start();
                $.post("import_process", 
                    { data : data },
                  function(response){
                    console.log(response);
                  }, "json")
                .always(function() { l.stop(); });
                return false;
            });
        </script>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject bold uppercase">Source Data</span>
                    </div>
                </div>
                <div class="form-group form-md-line-input has-info form-md-floating-label">
                    <div class="input-group left-addon">
                        <span class="input-group-addon">
                            <i class="fa fa-file-excel-o"></i>
                        </span>
                        @if($listname == null)
                        <input type="text" class="form-control" name="listname" value="">
                        <label for="form_control_1">Templete Name</label>
                        @else
                        <input type="text" class="form-control" name="listname" value="{{$listname}}" readonly>
                        
                        @endif
                        <span class="input-group-btn btn-right">
                            <button type="text" class="btn red mt-ladda-btn ladda-button btn-circle btn-outline" id="form-submit" data-style="slide-right" data-spinner-color="#333">
                                <span class="ladda-label">
                                    <i class="fa fa-paper-plane"></i> Go</span>
                                <span class="ladda-spinner"></span>
                            </button>
                        </span>
                        </div>
                        <input type="hidden" name="origin_file" value="{{$origin_file}}">
                        <input type="hidden" name="filename" value="{{$origin_file}}">
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-checkable table-bordered table-hover" id='mytable'>    
                        <thead>
                            <tr>
                                
                                <td>
                                    Heading
                                </td>
                                <td>
                                    Column
                                </td>
                                <td>
                                    Rename
                                </td>
                            </tr>
                        </thead>
                        <tbody id="tt"> 
                            @foreach($heading as $head => $hdata)

                                <tr id={{$head}}>
                                
                                    <td>
                                        <input type="hidden" name="{{$hdata}}" value="" >
                                        {{$hdata}}
                                    </td>
                                    <td>   
                                            {{$firstrow->$hdata}}
                                            
                                    </td>
                                    <td>
                                            <select class="form-control" style="padding-left:20px;" name="{{$hdata}}" placeholder="Please Select">
                                                <option value="" disabled selected>Select your option</option>
                                                @foreach ($select as $skey =>$sdata)
                                                	{{$skey}}{{$sdata}}
                                                    @if($hdata == $sdata->header)
                                                        <option value="{{$sdata->header}}" selected='true'>{{$head}}{{$skey}}{{$sdata->header}}</option>
                                                    @else
                                                        <option value="{{$sdata->header}}">{{$skey}}{{$sdata->header}}</option>
                                                    @endif        
                                                @endforeach
                                            </select>
                                    </td>

                                </tr> 
                            @endforeach
                        </tbody> 
                     </table>
                     <div class="btn-group">
                        <button id="sample_editable_1_new" class="btn green" onclick="CreateRow()"> Add New
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>  
                </div>
            </div>
        </div>    
    </form>             <!-- END EXAMPLE TABLE PORTLET-->
</div>     


<script>
    function CreateRow() {

        //$('#mytable').find('tbody').append(
        //"<tr id="+rows+"><td></td><td>"+"<input type='text' name='123' value='' class='form-control' >"+"</td><td></td></tr>" 
        //);
        
        //取array數當ID
		var rows = document.getElementById('mytable').rows.length;		

        var boxes = document.getElementById("tt");
		var clone = boxes.children[1].cloneNode(true);
		console.log(rows);
		clone.id = rows;
		var firstd = clone.firstElementChild;
		firstd.innerHTML = 'New_'+rows;
		var lastd = clone.lastElementChild;
		lastd.lastElementChild.setAttribute('name',rows);
		boxes.appendChild(clone);

    }
    
</script>

@endsection

