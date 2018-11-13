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
                            @foreach($tmpdata['lookup'] as $head => $hdata)

                                <tr id={{$count++}}>
                                    <td> 
                                        {{$count++}}
                                    </td>
                                    <td style="text-align:center; vertical-align: center;">
                                        
                                            <input type="text" style="text-align:center;" class=" col-md-4 form-control" value="{{$head}}" readonly>
                                        
                                    </td>
                                    <td >
                                        <div class="form-group form-md-line-input has-info form-md-floating-label"  style="margin-bottom:0; padding-top:10;">
                                            <div class="input-group left-addon">
                                                <span class="input-group-addon">
                                                </span>
                                                <input type="text" class="form-control" id="t{{$head}}" name="target[{{$hdata}}]" value="" link="{{$head}}" onchange="Addrow(this)">
                                                @if($firstrow->$hdata)
                                                <label id="label{{$head}}" for="form_control_1">{{$firstrow->$hdata}}</label>
                                                @else
                                                <label id="label{{$head}}" for="form_control_1">未使用此欄位</label>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="hidden" id="l{{$head}}" name="lookup[{{$head}}]" value="{{$hdata}}">
                                        @foreach($tmpdata['addrow'] as $akey => $avalue)
                                            @if($akey == $head)
                                                <input type="hidden" id="a{{$head}}" name="addrow[{{$head}}]" value="{{$avalue}}">
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>    
                                        <select class="form-control" style="text-align:center;" link="{{$head}}"  placeholder="Please Select" onchange="Linkfile(this)">
                                            @foreach ($firstrow as $fkey => $fdata)
                                                @foreach($shead as $skey => $sdata)
                                                    @if($skey == $head)
                                                        <option value="{{$fkey}}" key="{{$fdata}}" selected >{{$fkey}}</option>
                                                        @break
                                                    @else
                                                        <option value="{{$fkey}}" key="{{$fdata}}">{{$fkey}}</option>
                                                        @break
                                                    @endif
                                                @endforeach
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
        secondd.firstElementChild.id = 'I'+rows;
        secondd.firstElementChild.removeAttribute('readonly');
        secondd.firstElementChild.setAttribute('value','');
        secondd.firstElementChild.setAttribute('placeholder','新增欄位名稱');
        secondd.firstElementChild.setAttribute('onchange',"Setrow("+rows+")");

        var third = clone.children[2];
        third.children[0].children[0].children[1].setAttribute('link',rows);
        third.children[0].children[0].children[1].id = 't'+rows;
        third.children[0].children[0].children[1].removeAttribute('disabled');
        third.children[0].children[0].children[2].id = 'label'+rows;
        third.children[0].children[0].children[2].innerHTML = "Input or from Select";
        third.children[1].id = 'l'+rows;
        third.children[2].id = 'a'+rows;
        

       
		var lastd = clone.lastElementChild;
		lastd.lastElementChild.setAttribute('link',rows);
        lastd.lastElementChild.id = 's_'+rows;
        //lastd.lastElementChild.removeAttribute('onchange');
		boxes.appendChild(clone);
        //clone.appendChild("<i class='fa fa-times'><i/>");
         //secondd.innerHTML = "<input type='text'  id='I"+rows+"' value='' onchange='Setrow("+rows+")' class='form-control' required>";
        //third.innerHTML = "<input type='text' class='form-control' id='t"+rows+"' link='"+rows+"' name='target[]' onchange='Addrow(this)' value=''><input type='hidden' id='l"+rows+"' name='lookup[]' value=''><input type='hidden' id='a"+rows+"' name='addrow[]' value=''>";
    }

    function Addrow(IN){
        var ivalue = IN.value;
        var link = IN.getAttribute('link');
        document.getElementById("a"+link).setAttribute('value',ivalue);

    }

      function Linkfile(QQ){
        var data = QQ.options[QQ.selectedIndex].getAttribute('key');
        var svalue = QQ.options[QQ.selectedIndex].value;
        var link = QQ.getAttribute('link');
        var value = QQ.value;

        document.getElementById("t"+link).setAttribute("disabled",true);

        document.getElementById("l"+link).setAttribute('value',svalue);

        //document.getElementById("a"+link).setAttribute('value',data);

        document.getElementById("label"+link).innerHTML = data;

        console.log(value,data);

    }

    function Setrow(sid){

        //console.log(sid);

        var ivalue = document.getElementById("I"+sid).value;
        //console.log(ivalue);
        document.getElementById("l"+sid).setAttribute('name','lookup['+ivalue+']');
        document.getElementById("a"+sid).setAttribute('name','addrow['+ivalue+']');
        //document.getElementById("a"+sid).setAttribute('value',ivalue);


    }

    function Removerow(rid){
        console.log(rid);
        rid.parentNode.removeChild(rid);
        //console.log(rid);
    }
    
</script>

@endsection

