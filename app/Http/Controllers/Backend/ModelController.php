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

class ModelController extends Controller
{
	private $tableName;
    public function __construct()
	{
		parent::__construct();
		$this->tableName = 'models';
		$this->middleware('auth');
	}

	/* === List model Start ===*/
	public function getmodellishting(Request $request)
	{
		$q = Models::select(
					'models.*',
					DB::raw("brands.name")
				);

		$q->join('brands','brands.id','=','models.brand_id');

		if($request->has('search'))
		{
			$search = $request['search'];
			$q->where(function($q) use($search){
				$q->orWhere('models.model_name','like','%'.$search.'%');
				$q->orWhere('brands.name','like','%'.$search.'%');
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

		$recordsPerPage = $this->recordsPerPage("model-listing");
        
        $allModels = $q->paginate($recordsPerPage);
		$page = $request->has('page') ? $request->page : 1;

		$columns = ['model_name', 'active'];
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
        
		return view('admin.model.list',[
				"allModels" => $allModels,
				'sort_columns' => $sort_columns,
            	'isRequestSearch'=>$isRequestSearch
			]);
	}
	// Bulk active/inactive brand/sub-brand
	public function postmodellishting(Request $request)
	{
		if(!empty($request->bulkaction) && !empty($request->selectedIds))
		{
			$bulkAction = $request->bulkaction;
			switch ($bulkAction) {
				case 'active':
						$model = Models::whereIn('id', $request->selectedIds)->update([
                                'active'=>'1'
                            ]);
						return back()->with(array('alert-class'=>'alert-success','message'=>'Selected Models have been activated successfully!'));
					break;
				case 'inactive':
						$model = Models::whereIn('id', $request->selectedIds)->update([
                                'active'=>'0'
                            ]);
						return back()->with(array('alert-class'=>'alert-success','message'=>'Selected Models have been in-activated successfully!'));
					break;
			}
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Select at least one row!'));
		}
	}

	public function getAdminAddModel()
	{
		$mainBrand = Brands::where('active','1')->lists('name','id');
		return view('admin.model.add',compact(
				'mainBrand'
			));
	}

	public function postAdminAddModel(Request $request)
	{
		$this->validate($request, [
			'brand_id' 		=> 'required',
            'model_name'     => 'required|unique:models'
		]);
		
        $data['brand_id'] 		= $request->input('brand_id');
        $data['model_name'] 	= $request->input('model_name');
        $data['active'] 		= $request->input('active');
        if($userId = Common::insert($this->tableName, $data))
        {
        	return back()->with(array('alert-class'=>'alert-success','message'=>'New model added successfully!'));
        }else{
        	return back()->with(array('alert-class'=>'alert-danger','message'=>'Error saving new model, try again!'))->withInput(Input::all());
        }
	}


	public function getAdminEditModel(Request $request, Models $Model)
	{
		$mainBrand = Brands::where('active','1')->lists('name','id');
		return view('admin.model.edit',compact('mainBrand','Model'));
	}

	public function postAdminEditModel(Request $request, Models $Model)
	{
		$this->validate($request, [
			'brand_id' 		=> 'required',
			'model_name'     => "required|unique:models,model_name,".$Model->id
		]);

		$Model = Models::where("id",$Model->id)->first();
		if($Model)
		{
			$Model->brand_id 		= $request['brand_id'];
			$Model->model_name 	= $request['model_name'];
			$Model->active 			= $request['active'];
			$Model->save();

			return back()->with(array('alert-class'=>'alert-success','message'=>'Model updated successfully!'));
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Model does not exists!'));
		}
	}

	public function getAdminDeleteModel(Request $request, Models $Model)
	{
		$ModelDetails = ModelDetails::where('model_id', $Model->id)->first();
		if(empty($ModelDetails))
		{
			$model = Models::where('id', $Model->id)->delete();
			if($model)
				return back()->with(array('alert-class'=>'alert-success','message'=>'Model deleted successfully!'));
			else
				return back()->with(array('alert-class'=>'alert-danger','message'=>'Error deleting Model!'));
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Sorry, the "'.$Model->model_name.'" model is already assigned to sub ModelDetails!'));
		}	
	}

	
	
}
