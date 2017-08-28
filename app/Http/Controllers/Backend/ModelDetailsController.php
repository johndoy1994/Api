<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Models\Brands;
use App\Models\Models;
use App\Models\ModelDetails;
use App\Http\Controllers\CommonController as Common;
use Intervention\Image\Facades\Image;
use DB;

class ModelDetailsController extends Controller
{
	private $tableName;
    public function __construct()
	{
		parent::__construct();
		$this->tableName = 'model_details';
		$this->middleware('auth');
	}

	/* === List model Start ===*/
	public function getmodelDetailslishting(Request $request)
	{
		$q = ModelDetails::select(
					'model_details.*',
					DB::raw("models.model_name"),
					DB::raw("brands.name")
				);

		$q->join('models','models.id','=','model_details.model_id');
		$q->join('brands','brands.id','=','models.brand_id');

		if($request->has('search'))
		{
			$search = $request['search'];
			$q->where(function($q) use($search){
				$q->orWhere('models.model_name','like','%'.$search.'%');
				$q->orWhere('brands.name','like','%'.$search.'%');
				$q->orWhere('model_details.from_year','like','%'.$search.'%');
				$q->orWhere('model_details.to_year','like','%'.$search.'%');
				// $q->orWhere('model_details.clyinders','like','%'.$search.'%');
				// $q->orWhere('model_details.liters','like','%'.$search.'%');
				// $q->orWhere('model_details.main_belt','like','%'.$search.'%');
				// $q->orWhere('model_details.power_steering_belt','like','%'.$search.'%');
				// $q->orWhere('model_details.alternator_belt','like','%'.$search.'%');
				// $q->orWhere('model_details.air_con_belt','like','%'.$search.'%');
				

			});
		}

		
		if($request->has('sortBy'))
		{
			$sortOrder = 'asc';
			if($request->has('sortOrder'))
			{
				$sortOrder = $request['sortOrder'];
			}
			$q->orderBy($request['sortBy'],$sortOrder);
		}else{
			$q->orderBy('brands.name','asc');
		}

		$recordsPerPage = $this->recordsPerPage("model-details-listing");
        
        $allModelsDetails = $q->paginate($recordsPerPage);
		$page = $request->has('page') ? $request->page : 1;

		$columns = ['model_name','from_year','to_year', 'active'];
        $sort_columns = [];
        foreach ($columns as $column) {
            $sort_columns[$column]["params"] = [
                'page' => $page,
                'sortBy' => $column
            ];
            if($request->has('sortOrder')) {
                $sort_columns[$column]["params"]["sortOrder"] = $request["sortOrder"] == "asc" ? "desc" : "asc";
                if($sort_columns[$column]["params"]["sortOrder"] == "asc") {
                    $sort_columns[$column]["angle"] = "up";
                } else {
                    $sort_columns[$column]["angle"] = "down";
                }
            } else {
                $sort_columns[$column]["params"]["sortOrder"] = "desc";
                $sort_columns[$column]["angle"] = "down";
            }

            if($request->has("search")) {
                $sort_columns[$column]["params"]["search"] = $request->search;
            }
        }
        $isRequestSearch = $request->has('search');
        
		return view('admin.model-details.list',[
				"allModelsDetails" => $allModelsDetails,
				'sort_columns' => $sort_columns,
            	'isRequestSearch'=>$isRequestSearch
			]);
	}
	// Bulk active/inactive brand/sub-brand
	public function postmodelDetailslishting(Request $request)
	{
		if(!empty($request->bulkaction) && !empty($request->selectedIds))
		{
			$bulkAction = $request->bulkaction;
			switch ($bulkAction) {
				case 'active':
						$model = ModelDetails::whereIn('id', $request->selectedIds)->update([
                                'active'=>'1'
                            ]);
						return back()->with(array('alert-class'=>'alert-success','message'=>'Selected ModelsDetails have been activated successfully!'));
					break;
				case 'inactive':
						$model = ModelDetails::whereIn('id', $request->selectedIds)->update([
                                'active'=>'0'
                            ]);
						return back()->with(array('alert-class'=>'alert-success','message'=>'Selected ModelsDetails have been in-activated successfully!'));
					break;
			}
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Select at least one row!'));
		}
	}

	public function getAdminAddModelDetails()
	{
		$mainBrand = Brands::where('active','1')->lists('name','id');
		return view('admin.model-details.add',compact(
				'mainBrand'
			));
	}

	public function postAdminAddModelDetails(Request $request)
	{
		$validator = Validator::make($request->all(), [
                        'model_id'     => 'required',
                        'from_year'     => 'required',
                        'to_year'     => 'required',
                        'clyinders'     => 'required',
                        'liters'     => 'required',
                        'image'    => 'required|image|mimes:jpeg,jpg,png'
                    ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator->errors())->withInput(Input::all());
        }

        if($request->input('from_year') > $request->input('to_year')){
        	return back()->withErrors("Please enter from year less then to year")->withInput(Input::all());	
        }
        
        $data['model_id'] 			= trim($request->input('model_id'));
        $data['from_year'] 			= trim($request->input('from_year'));
        $data['to_year'] 			= trim($request->input('to_year'));
        $data['clyinders'] 			= trim($request->input('clyinders'));
        $data['liters'] 			= trim($request->input('liters'));
        $data['main_belt'] 			= trim($request->input('main_belt'));
        $data['power_steering_belt']= trim($request->input('power_steering_belt'));
        $data['alternator_belt'] 	= trim($request->input('alternator_belt'));
        $data['air_con_belt'] 		= trim($request->input('air_con_belt'));
        $data['active'] 			= trim($request->input('active'));

        if($userId = Common::insert($this->tableName, $data))
        {
        	if($request->hasFile('image'))
        	{
	        	$imageFile = $request->file('image');
	        	$data['imageName']      = time().'.'.$imageFile->getClientOriginalExtension();
	            $data['imageFile']      = $imageFile;
	            $data['destPath']       = $this->USER_BASE_PATH;
	            $data['resizeDestPath'] = $this->USER_BASE_PATH."resize/";
	            //$data['resizeOriginal'] = true;

	        	$success = Common::uploadProfilePicture($data);
	        	if($success)
	        	{
	        		$ModelDetails = ModelDetails::find($userId);
		        	$ModelDetails->image = $data['imageName'];
		        	$ModelDetails->save();	
	        	}
        	}
        	return back()->with(array('alert-class'=>'alert-success','message'=>'Model details added successfully!'));
        }else{
        	return back()->with(array('alert-class'=>'alert-danger','message'=>'Error saving model details, try again!'))->withInput(Input::all());
        }
	}



	public function getAdminEditModelDetails(Request $request, ModelDetails $ModelDetails)
	{
		$mainBrand = Brands::where('active','1')->lists('name','id');
		$mainModel = Models::where('active','1')->where('id',$ModelDetails->model_id)->lists('model_name','id');
		$onemainBrand = Models::where('active','1')->where('id',$ModelDetails->model_id)->first();
		
		//$GetBrandId = $ModelDetails->getBrandId($ModelDetails->model_id);
		return view('admin.model-details.edit',compact('mainBrand','ModelDetails','mainModel','onemainBrand'));
	}

	public function postAdminEditModelDetails(Request $request, ModelDetails $ModelDetails)
	{
		$this->validate($request, [
			'model_id'     => 'required',
            'from_year'     => 'required',
            'to_year'     => 'required',
            'clyinders'     => 'required',
            'liters'     => 'required',
            'image'    => 'image|mimes:jpeg,jpg,png'
		]);
		if($request->input('from_year') > $request->input('to_year')){
        	return back()->withErrors("Please enter from year less then to year")->withInput(Input::all());	
        }
		$ModelDetails = ModelDetails::where("id",$ModelDetails->id)->first();
		if($ModelDetails)
		{
			$ModelDetails->model_id 	= trim($request['model_id']);
			$ModelDetails->from_year 			= trim($request['from_year']);
			$ModelDetails->to_year 			= trim($request['to_year']);
			$ModelDetails->clyinders 			= trim($request['clyinders']);
			$ModelDetails->liters 			= trim($request['liters']);
			$ModelDetails->main_belt 			= trim($request['main_belt']);
			$ModelDetails->power_steering_belt 			= trim($request['power_steering_belt']);
			$ModelDetails->alternator_belt 			= trim($request['alternator_belt']);
			$ModelDetails->air_con_belt 			= trim($request['air_con_belt']);
			$ModelDetails->active 			= trim($request['active']);
			$ModelDetails->save();
			if($request->hasfile('image'))
			{
				$oldImageName = $ModelDetails->image;
				$imageFile = $request->file('image');
				
	        	$data['imageName']      = time().'.'.$imageFile->getClientOriginalExtension();
	            $data['imageFile']      = $imageFile;
	            $data['destPath']       = $this->USER_BASE_PATH;
	            $data['resizeDestPath'] = $this->USER_BASE_PATH."resize/";
	            //$data['resizeOriginal'] = true;

	        	$success = Common::uploadProfilePicture($data);
	        	if($success)
	        	{
	        		$result = Common::removeOldFile($oldImageName, $data['destPath'], $data['resizeDestPath']);
        			$ModelDetails->image = $data['imageName'];
	        		$ModelDetails->save();		
	        	}
			}

			return back()->with(array('alert-class'=>'alert-success','message'=>'ModelDetails updated successfully!'));
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'ModelDetails does not exists!'));
		}
	}

	public function getAdminDeleteModelDetails(Request $request, ModelDetails $ModelDetails)
	{
		
	    $result = Common::removeOldFile($ModelDetails->image, $this->USER_BASE_PATH, $this->USER_BASE_PATH."resize/");
		$model = ModelDetails::where('id', $ModelDetails->id)->delete();
		if($model)
			return back()->with(array('alert-class'=>'alert-success','message'=>'Model Details deleted successfully!'));
		else
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Error deleting Model Details!'));	
	}

	public function getAjaxModel(Request $request)
	{
		$subCategories = [];
		if($request->has('parentId'))
		{
			$parentId = $request->parentId;
			$subCategories = Models::where("brand_id",$parentId)->where('active','1')->lists('model_name','id');
		}
		return response()->json($subCategories);
	}

	
	
}
