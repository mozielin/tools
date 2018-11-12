@extends('layouts.main')
@section('content')
<script src="https://code.jquery.com/jquery-1.12.0.js"></script> 
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script> 

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
        <div class="col-md-8">                           
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
                        <span class="caption-subject bold uppercase">建立新轉換模板</span>
                    </div>
                </div>
                <div class="form-group form-md-line-input has-info form-md-floating-label">
                    <div class="input-group left-addon">
                        <span class="input-group-addon">
                            <i class="fa fa-file-excel-o"></i>
                        </span>
                        @if($listname == null)
                        <input type="text" class="form-control" name="listname" value="">
                        <label for="form_control_1">輸入轉檔模板名稱</label>
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
                                <td class="col-md-1">
                                    No.
                                </td>
                                <td class="col-md-3" style="text-align:center;">
                                    來源檔案欄位名稱
                                </td>
                                <td class="col-md-4" style="text-align:center;"> 
                                    資料預覽
                                </td>
                                <td class="col-md-3" style="text-align:center;">
                                    對應目標檔案欄位名稱
                                </td>
                            </tr>
                        </thead>
                        <tbody id="tt"> 
                            @foreach($heading as $head => $hdata)

                                <tr id={{$head}}>
                                    <td>
                                        {{$head+1}}
                                    </td>
                                    <td style="text-align:center;">
                                        {{$hdata}}
                                    </td>
                                    <td id="f{{$head}}" style="text-align:center;">
                                    <input type="text" class=" col-md-4 form-control" name="manual[]" value="{{$firstrow->$hdata}}" >   
                                       
                                            
                                    </td>
                                    <td>    <input type="hidden" name="{{$hdata}}" value="null">
                                            <select class="form-control" style="text-align:center;" name="{{$hdata}}" placeholder="Please Select" onchange="Linkfile(this)">
                                                <option value="" disabled selected>無</option>
                                                @foreach ($shead as $sdata)
                                                <option value="{{$sdata}}" key="{{$firstrow->$sdata}}" link="{{$head}}">{{$sdata}}</option>

                                                @endforeach
                                            </select>
                                    </td>

                                </tr> 
                            @endforeach
                        </tbody> 
                     </table>
                    <div class="btn-group">
                        <button id="sample_editable_1_new" class="btn green" onclick="CreateRow()"> 新增欄位
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
		//console.log(rows);
		clone.id = 'nrow_'+rows;
        var rid = clone.id;
		var firstd = clone.firstElementChild;
		firstd.innerHTML = "<i class='fa fa-times btn' onclick='Removerow("+rid+")'></i>";
        var secondd = clone.children[1];
        secondd.innerHTML = "<input type='text'  id='I"+rows+"' value='' onchange='Setname("+rows+")' class='form-control' required>";
        //name='"+rows+"'
		var lastd = clone.lastElementChild;
		lastd.lastElementChild.setAttribute('link',rows);
        lastd.lastElementChild.id = 's_'+rows;
        lastd.lastElementChild.removeAttribute('onchange');
		boxes.appendChild(clone);
        //clone.appendChild("<i class='fa fa-times'><i/>");

    }

    function ChangeOpt(QQ){
        var iname = QQ.getAttribute("link");
        //console.log(iname);
        var svalue = QQ.options[QQ.selectedIndex].value;

        document.getElementById("I"+iname).setAttribute('name',svalue);


        console.log(svalue);

    }

      function Linkfile(QQ){
        var data = QQ.options[QQ.selectedIndex].getAttribute('key');
        var link = QQ.options[QQ.selectedIndex].getAttribute('link');
        //console.log(data);

        //var svalue = QQ.options[QQ.selectedIndex].value;

        document.getElementById("f"+link).innerHTML = data;

        //console.log(svalue);

    }

    function Setname(sid){

        //console.log(sid);

        var ivalue = document.getElementById("I"+sid).value;
        //console.log(ivalue);
        document.getElementById("s_"+sid).setAttribute('name',ivalue);

    }

    function Removerow(rid){
        console.log(rid);
        rid.parentNode.removeChild(rid);
        //console.log(rid);
    }
    
</script>

@endsection

