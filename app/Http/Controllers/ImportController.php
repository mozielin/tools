<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use Exception;

use App\User,
	App\Select,
	App\Upload,
	App\Reorder;



class ImportController extends Controller
{	

	public function __construct(){
    	// 执行 auth 认证
   		$this->middleware('auth');
	}

	public function getImport()
    {
        return view('/import/import');
    }

    public function Importfromlist()
    {	

    	$list = Reorder::where('user_id','=',Auth::id())->get();

    	//dd($list);

    	if (!$list->isEmpty()) {
    		return view('import/import_list')->with('list',$list);
    	
    	}

    	else{
    		\Session::flash('flash_message', 'Please Create New Temptele First!');
    		return view('import/import');
    	}

    }

    public function Upload(Request $request)
	{	
		
		//return dd($request);
		if ($request->hasFile('excel')){

			try {

			$select = Select::all();

			$tmpname = $request->excel->getPathName();
			$tmpsname = $request->sample->getPathName();
		
			$data = \Excel::load($tmpname)->all();
			$sample = \Excel::load($tmpsname)->all();  	

			$id = Auth::id();

			//附件檔名儲存
            $filename = $request->excel->getClientOriginalName();
            $store = $request->file('excel')->store('public/export');  
            //dd($store);
            $getorigin = sscanf($store,'public/export/%s',$origin_file);
 
			$firstrow = $data->first();
			$filsample = $sample->getHeading();
			$heading = array_filter($filsample);
			$shead =  $data->getHeading();
			$listname = null;

			} catch (Exception $exception) {
			
			 	return back()->withError('上傳檔案內容格式不正確，請重新上傳!'.$exception->getMessage())->withInput();
			} 

			//return dd($tmpname,$data,$sample,$heading,$firstrow);
		
		return view ('/import/import_parse')
				->with('heading',$heading)
				->with('firstrow',$firstrow)
				->with('select',$select)
				->with('data',$data)
				->with('listname',$listname)
				->with('shead',$shead)
				->with('origin_file',$origin_file);
			
		}
	}

    public function ProcessImport(Request $request)
    {
   		//取模板名稱跟原始檔案
    	$listname = $request->listname;
    	$origin_file = $request->origin_file;
    	//去掉多餘
    	$data = $request->except('_token','exportname','origin_file','filename','listname');
		list($okey, $nkey) = array_divide($data);
		//轉成json存資料庫
		$jsondata = json_encode($data);
		if($request->listname != null){  
            $savedata = Reorder::firstOrCreate(
                ['listname' => $request->listname,'user_id' => Auth::id()],
                ['jsondata' => $jsondata,]
            );
            $savedata -> listname = $request->listname;
			$savedata -> jsondata = $jsondata;
			$savedata -> user_id = Auth::id();
			$savedata ->save();
        }
 		//讀取來源檔轉array
		$sourcedata = \Excel::load('storage/app/public/export/'.$origin_file)->all()->toArray();
		//刪除上傳檔案(fix)先看路徑dd(Storage::path($origin_file));
		Storage::delete('public/export/'.$origin_file);
		//分拆array
		$lookup = $data['lookup'];
		$addrow = array_filter($data['addrow']);
		//1.先把來源檔資料run一遍
		//2.把目標標頭run一遍(會依此為輸出標頭)
		//3.跑一圈有選取對照的，比較是否有選取(若有放進值)
		//4.跑一圈有新增標頭的，比較後放值
		//5.將結果存成2維
		foreach ($sourcedata as $svalue) {
  			foreach ($lookup as $lkey => $lvalue) {
  				$result[$lkey] = $lvalue;
  				foreach ($svalue as $skey => $ssvalue) {
					if ($skey == $lvalue) {
						$result[$lkey] = $ssvalue ;
					}
				}
				foreach ($addrow as $akey => $avalue) {
					if($akey == $lkey)
						$result[$lkey] = $avalue ;
				}
		  	}
		  	$exportdata[] = $result;
		}
		//取亂數檔名暫放
		$exportname = str_random(40);
		//存檔
    	\Excel::create($exportname, function($excel)use($exportdata) {
	    	$excel->sheet('sheet', function($sheet)use($exportdata) {
	        $sheet->fromArray($exportdata);
	    	})->store('xlsx',storage_path('/app/public/export'));
	    	
	    });
    	
  		return view('/import/start_download')
  				->with('listname',$listname)
  				->with('filepath',$exportname);
    }

    public function Upload_list(Request $request)
	{	
		//return dd($request);
	

		if ($request->hasFile('excel')){

			//$select = Select::all();
			try {

			$tmpname = $request->excel->getPathName();

			$data = \Excel::load($tmpname)->all();

			$id = Auth::id();

			//附件檔名儲存
            $filename = $request->excel->getClientOriginalName();
            $store = $request->file('excel')->store('public/export');  
            $getorigin = sscanf($store,'public/export/%s',$origin_file);
           // dd($origin_file);
			$reorder = Reorder::where('user_id','=',Auth::id())
								->where('listname','=',$request->listname)
								->select('jsondata')->first();
								
			$tmpdata = json_decode($reorder->jsondata,true);

			//dd(array_filter($tmpdata['lookup']));

			//list($heading, $shead) = array_divide($tmpdata['lookup']);

			$shead = array_filter($tmpdata['lookup']);

			$firstrow = $data->first();
			$count = 0;
			$addrow = $tmpdata['addrow'];
			$heading = $tmpdata['lookup'];
			//$tmpdata = array_merge(array_flip($okey),$value);
			//dd($tmpdata,$heading,$addrow,$tmpdata['addrow'],$firstrow, $shead);
			} catch (Exception $exception) {
				
				 return back()->withError('上傳檔案內容格式不正確，請重新上傳!'.$exception->getMessage())->withInput();
			} 

		return view ('/import/import_parse_list')
				->with('tmpdata',$tmpdata)
				->with('heading',$heading)
				->with('firstrow',$firstrow)
				->with('shead',$shead)
				->with('count',$count)
				->with('addrow',$addrow)
				->with('listname',$request->listname)
				->with('origin_file',$origin_file);
			
		}
	}

    public function ProcessImport_list(Request $request)
    {
   		//return dd($request);
    	$listname = $request->listname;
    	$origin_file = $request->origin_file;
    	$data = $request->except('_token','exportname','origin_file','filename','listname');
		list($okey, $nkey) = array_divide($data);

		$jsondata = json_encode($data);
		//dd($jsondata);
		 if($request->listname != null){  
            $savedata = Reorder::firstOrCreate(
                ['listname' => $request->listname,'user_id' => Auth::id()],
                ['jsondata' => $jsondata,]
            );
            //return dd($data);
            $savedata -> listname = $request->listname;
			$savedata -> jsondata = $jsondata;
			$savedata -> user_id = Auth::id();

			$savedata ->save();
        }

		//return dd($data,$okey, $nkey,$jsondata);

		$sourcedata = \Excel::load('storage/app/public/export/'.$origin_file)->all()->toArray();
		//dd($sourcedata);
		$addrow = array_diff_key($data,$sourcedata[0]);
		$faddrow = array_flip($addrow);
		//$gg = $addrow+array_flip($okey);
		$newk = array_flip(array_filter($data));

		foreach ($newk as $oskey => $osvalue) {
				$order[$oskey] = $osvalue ;
			foreach ($addrow as $akey => $avalue) {
					//dd($rvalue[$oskey] ,$akey);
				if ($oskey == $akey) {
					$order[$oskey] = $akey ;
				}
			}
		}
		
		return dd($origin_file); 
		//還沒成功刪除(unfix)
		\Storage::delete('/storage/export/app/'.$origin_file);

		foreach ($sourcedata as $value) {
		  $nvalue = $value+array_flip($addrow);
		  foreach ($order as $rkey => $rvalue) {
				$ready[$rkey] = $rvalue ;
			foreach ($nvalue as $nkey => $value) {
				if ($nkey == $rvalue) {
					$ready[$rkey] = $value ;
				}
			}
		  }
		  $exportdata[] = $ready;
		}

		$exportname = str_random(40);

    	\Excel::create($exportname, function($excel)use($exportdata) {
	    	$excel->sheet('sheet', function($sheet)use($exportdata) {
	        $sheet->fromArray($exportdata);
	    	})->store('xlsx',storage_path('/app/public/export'));
	    	
	    });
		
  		return view('/import/start_download')
  				->with('listname',$listname)
  				->with('filepath',$exportname);
    }

    public function Download($filepath,$listname){
    	$time = Carbon::now()->toDateString(); 
    	$path = 'storage/app/public/export/'.$filepath.'.xlsx';
    	return \Response::download($path,$listname.'_'.$time.'.xlsx')->deleteFileAfterSend(true);
    }

    public function EditView(){
    	$list = Reorder::where('user_id','=',Auth::id())->get(); 
    	return view('import/import_edit')->with('list',$list);
    }
    
    public function Delete($id){
    	$delete = Reorder::find($id)->delete();

    	$list = Reorder::where('user_id','=',Auth::id())->get();
    	return redirect()->action('ImportController@EditView'); 
    }
}
