<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Models\Brands;
use App\Models\Models;
use App\Http\Controllers\CommonController as Common;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
	private $tableName;
    public function __construct()
	{
		parent::__construct();
		$this->tableName = 'brands';
		$this->middleware('auth');
	}

	/* === List brand Start ===*/
	public function getbrandlishting(Request $request)
	{
		$q = Brands::select('*');

		if($request->has('search'))
		{
			$search = $request['search'];
			$q->where(function($q) use($search){
				$q->orWhere('name','like','%'.$search.'%');
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
			$q->orderBy('name','asc');
		}

		$recordsPerPage = $this->recordsPerPage("brand-listing");
        
        $allBrands = $q->paginate($recordsPerPage);
		$page = $request->has('page') ? $request->page : 1;

		$columns = ['name', 'active'];
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
        
		return view('admin.brand.list',[
				"allBrands" => $allBrands,
				'sort_columns' => $sort_columns,
            	'isRequestSearch'=>$isRequestSearch
			]);
	}
	// Bulk active/inactive brand/sub-brand
	public function postbrandlishting(Request $request)
	{
		if(!empty($request->bulkaction) && !empty($request->selectedIds))
		{
			$bulkAction = $request->bulkaction;
			switch ($bulkAction) {
				case 'active':
						$Brand = Brands::whereIn('id', $request->selectedIds)->update([
                                'active'=>'1'
                            ]);
						return back()->with(array('alert-class'=>'alert-success','message'=>'Selected Brands have been activated successfully!'));
					break;
				case 'inactive':
						$Brand = Brands::whereIn('id', $request->selectedIds)->update([
                                'active'=>'0'
                            ]);
						return back()->with(array('alert-class'=>'alert-success','message'=>'Selected Brands have been in-activated successfully!'));
					break;
			}
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Select at least one row!'));
		}
	}

	public function getAdminAddnewBrand()
	{
		return view('admin.brand.add');
	}

	public function postAdminAddnewBrand(Request $request)
	{
		$validator = Validator::make($request->all(), [
                        'name'     => 'required|unique:brands',
                    ]);	

        if ($validator->fails())
        {
            return back()->withErrors($validator->errors())->withInput(Input::all());
        }
        
        $data['name'] 	= $request->input('name');
        $data['active'] = $request->input('active');
        if($brandId = Common::insert($this->tableName, $data))
        {
        	return back()->with(array('alert-class'=>'alert-success','message'=>'New Brand added successfully!'));
        }else{
        	return back()->with(array('alert-class'=>'alert-danger','message'=>'Error new brand, try again!'))->withInput(Input::all());
        }
	}


	public function getAdminEditBrand(Request $request, Brands $Brand)
	{
		return view('admin.brand.edit',[
				'Brand' => $Brand
			]);
	}

	public function postAdminEditBrand(Request $request, Brands $Brand)
	{
		$this->validate($request, [
			'name'     => "required|unique:brands,name,".$Brand->id
		]);
		$brand = Brands::where("id",$Brand->id)->first();
		if($brand)
		{
			$brand->name 	= $request['name'];
			$brand->active 	= $request['active'];
			$brand->save();
			return back()->with(array('alert-class'=>'alert-success','message'=>'Brand updated successfully!'));
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Brand does not exists!'));
		}
	}

	public function getAdminDeleteBrand(Request $request, Brands $Brand)
	{
		$ModelDetails = Models::where('brand_id',$Brand->id)->first();
		if(empty($ModelDetails))
		{
			$brand = Brands::where('id', $Brand->id)->delete();
			if($brand)
				return back()->with(array('alert-class'=>'alert-success','message'=>'Brand deleted successfully!'));
			else
				return back()->with(array('alert-class'=>'alert-danger','message'=>'Error deleting brand!'));	
		}else{
			return back()->with(array('alert-class'=>'alert-danger','message'=>'Sorry, the "'.$Brand->name.'" model is already assigned to sub model!'));
		}
	}

}
