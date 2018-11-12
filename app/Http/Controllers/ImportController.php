<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User,App\Select,App\Upload,App\Reorder;



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
			$heading = $sample->getHeading();
			$shead =  $data->getHeading();
			$listname = null;

			//return dd($tmpname,$data,$heading,$firstrow);
		
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
   		//return dd($request);
    	$listname = $request->listname;
    	$origin_file = $request->origin_file;

    	$data = $request->except('_token','exportname','origin_file','filename','listname');
		list($okey, $nkey) = array_divide($data);

		$jsondata = json_encode($data);

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
 		
		$sourcedata = \Excel::load('storage/app/public/export/'.$origin_file)->all()->toArray();

		$addrow = array_diff_key($data,$sourcedata[0]);
		dd($data,$okey, $nkey,$sourcedata[0],$addrow);
		$faddrow = array_flip($addrow);
		
		//$newk = array_flip($data);
	//dd($data,$addrow,$newk);
		foreach ($data as $oskey => $osvalue) {
				$order[$oskey] = $osvalue ;
			foreach ($addrow as $akey => $avalue) {
					//dd($rvalue[$oskey] ,$akey);
				if ($oskey == $akey) {
					$order[$oskey] = $akey ;
				}
			}
		}
		dd($data,$addrow,$order);
		//還沒成功刪除(unfix)
		\Storage::delete('app/public/export/'.$origin_file);

		foreach ($sourcedata as $value) {
		  $nvalue = $value+array_flip($addrow);
		 
		  foreach ($order as $rkey => $rvalue) {
				$ready[$rvalue] = $rvalue ;
			foreach ($nvalue as $nkey => $value) {
				if ($nkey == $rkey) {
					$ready[$rvalue] = $value ;
				}
			}
		  }
		  $exportdata[] = $ready;
		}
		 dd($nvalue,$order,$exportdata);

		$exportname = str_random(40);

    	\Excel::create($exportname, function($excel)use($exportdata) {
	    	$excel->sheet('sheet', function($sheet)use($exportdata) {
	        $sheet->fromArray($exportdata);
	    	})->store('xlsx',storage_path('/app/public/export'));
	    	
	    });

  		return view('/import/start_download')
  				->with('listname',$listname)
  				->with('filepath',$exportname);
            //return $this->Download($listname,$exportname);
    }

    public function Upload_list(Request $request)
	{	

		//return dd($request);

		if ($request->hasFile('excel')){

			//$select = Select::all();

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

			list($okey, $nkey) = array_divide($tmpdata);

			

			$heading = array_filter($nkey);

			$firstrow = $data->first();

			//$heading = $data->getHeading();
			//$tmpdata = array_merge(array_flip($okey),$value);
		//	dd($firstrow);
		
		return view ('/import/import_parse_list')
				->with('heading',$tmpdata)
				->with('firstrow',$firstrow)
				->with('select',$heading)
				->with('data',$data)
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
		
		//還沒成功刪除(unfix)
		\Storage::delete('app/public/export/'.$origin_file);

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

		//\Session::flash(Auth::user()->email, $exportname);

    	\Excel::create($exportname, function($excel)use($exportdata) {
	    	$excel->sheet('sheet', function($sheet)use($exportdata) {
	        $sheet->fromArray($exportdata);
	    	})->store('xlsx',storage_path('/app/public/export'));
	    	
	    });

	   

	   // return redirect()->action('ImportController@Download');
		//$filepath = 'storage/export/'.$exportname;
		
		//dd($filepath);
  		return view('/import/start_download')
  				->with('listname',$listname)
  				->with('filepath',$exportname);
            //return $this->Download($listname,$exportname);

    }

    public function Download($filepath,$listname){

    	//dd($filepath,$listname);

    	$path = 'storage/export/'.$filepath.'.xlsx';

    	return \Response::download($path,$listname.'.xlsx')->deleteFileAfterSend(true);
    }
    
}
