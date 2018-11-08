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

			$data = \Excel::load($tmpname)->all();

			$id = Auth::id();



			//附件檔名儲存
            $filename = $request->excel->getClientOriginalName();
            $store = $request->file('excel')->store('public/export');  
            $getorigin = sscanf($store,'public/export/%s',$origin_file);
           	

			$firstrow = $data->first();
			$heading = $data->getHeading();
			$listname = null;

			//return dd($tmpname,$data,$heading,$firstrow);
		
		return view ('/import/import_parse')
				->with('heading',$heading)
				->with('firstrow',$firstrow)
				->with('select',$select)
				->with('data',$data)
				->with('listname',$listname)
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

		$sourcedata = \Excel::load('storage/export/'.$origin_file)->all()->toArray();

		\Storage::delete("/public/export/".$origin_file);

		foreach ($sourcedata as $value) {
			//dd($okey,$value);
		  $tmpdata = array_merge(array_flip($okey),$value);

		  list($okeys, $ovalue) = array_divide($tmpdata);

		  //dd($nkey,$ovalue);

		  $cdata = array_combine($nkey, $ovalue);

		  $newk = array_filter($nkey);

		  $exportdata[] = array_intersect_key($cdata,array_flip($newk));

		  //$exportdata [] = array_splice($stmpdata, offset)

		   //dd($okey,$value,$tmpdata,$nkey,$newk,$ovalue,$exportdata);

		}

		//return dd($exportdata);
		//Storage::delete("/public/export/".$origin_file);

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

    public function Upload_list(Request $request)
	{	

		//return dd($request);

		if ($request->hasFile('excel')){

			$select = Select::all();

			$tmpname = $request->excel->getPathName();

			$data = \Excel::load($tmpname)->all();

			$id = Auth::id();

			//附件檔名儲存
            $filename = $request->excel->getClientOriginalName();
            $store = $request->file('excel')->store('public/export');  
            $getorigin = sscanf($store,'public/export/%s',$origin_file);
           //	$file = new Upload;
           //	$file->user_id = $id;
           	//$file->origin_file = $origin_file;
           //	$file->save();

			$reorder = Reorder::where('user_id','=',Auth::id())
								->where('listname','=',$request->listname)
								->select('jsondata')->first();
								
			$tmpdata = json_decode($reorder->jsondata,true);

			list($okey, $nkey) = array_divide($tmpdata);

			//dd($tmpdata);

			//$heading = array_flip($tmpdata);

			$firstrow = $data->first();

			//$heading = $data->getHeading();
			//$tmpdata = array_merge(array_flip($okey),$value);
		//	dd($firstrow);
		
		return view ('/import/import_parse_list')
				->with('heading',$tmpdata)
				->with('firstrow',$firstrow)
				->with('select',$select)
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

		$sourcedata = \Excel::load('storage/export/'.$origin_file)->all()->toArray();

		\Storage::delete("/public/export/".$origin_file);

		foreach ($sourcedata as $value) {
			//dd($okey,$value);
		  $tmpdata = array_merge(array_flip($okey),$value);

		  list($okeys, $ovalue) = array_divide($tmpdata);

		  //dd($nkey,$ovalue);

		  $cdata = array_combine($nkey, $ovalue);

		  $newk = array_filter($nkey);

		  $exportdata[] = array_intersect_key($cdata,array_flip($newk));

		  //$exportdata [] = array_splice($stmpdata, offset)

		   //dd($okey,$value,$tmpdata,$nkey,$newk,$ovalue,$exportdata);

		}

		//return dd($exportdata);
		//Storage::delete("/public/export/".$origin_file);

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
