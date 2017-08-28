<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\ModelDetails;
use App\Models\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CommonController as Common;

class APIController extends Controller
{
    private $request;
    private $msg = 'Failed';
    private $code = 0;
    private $responseData = array();
    private $tableName = "";

    public function __construct()
    {   
    	parent::__construct();

    	$json = file_get_contents('php://input');
        $objRequest = (json_decode($json) != NULL) ? json_decode($json,TRUE) : $_REQUEST;
        $this->request = $objRequest;
        
        if(empty($this->request['api_key']) || $this->request['api_key'] != $this->API_KEY)
        { 
            $this->msg =  "Invalid request api key!";
            $this->code = 0;
            Common::output($this->code, $this->msg, $this->responseData);
        }
        unset($this->request['api_key']);
    }

    public function validateApiToken()
    {
        $getApiToken = empty($this->request['api_token']) ? "" : $this->request['api_token'];
        if(isset($this->request['api_token']))
            unset($this->request['api_token']);

        $newApiToken = $this->generateApiToken($this->request);
        
        if($getApiToken != $newApiToken)
        {
            $this->msg =  "Invalid request token!";
            $this->code = 0;
            Common::output($this->code, $this->msg, $this->responseData);
        }
    }

    public function getMakeDetails()
    {   
        $allBrands = Brands::where('active','1')->orderBy('name','asc')->get();
        $this->responseData = $allBrands;
        $this->msg =  "Success";
        $this->code = 1; 
        Common::output($this->code, $this->msg, $this->responseData);
    }

    public function getModels()
    {   
        $this->validateApiToken();
        $brand_id  = $this->request['brand_id'];
        $q = Brands::select(
                    "brands.*",
                    DB::raw('models.id as model_id'),
                    DB::raw('models.model_name')
                );
            $q->join('models', 'models.brand_id', '=', 'brands.id');
            $q->where('models.brand_id',$brand_id);
            $q->where('models.active','1');
            $q->orderBy('models.model_name','asc');
            $getModel = $q->get();

        if(!empty($getModel)){
            $this->responseData = $getModel;
            $this->msg =  "Success";
            $this->code = 1;     
        }else{
            $this->msg =  "Model record not founds!";
        }    
        
        Common::output($this->code, $this->msg, $this->responseData);
    }

    public function getModelDetails()
    {   
        // $this->validateApiToken();
        $model_id  = $this->request['model_id'];
        //$from_year  = !empty($this->request['from_year']) ? $this->request['from_year'] :"";
        //$to_year  = !empty($this->request['to_year']) ? $this->request['to_year'] : "";

        $q = Brands::select(
                    "brands.name",
                    DB::raw('models.id as model_id'),
                    DB::raw('models.model_name'),
                    DB::raw('model_details.*')
                    
                );
            $q->join('models', 'models.brand_id', '=', 'brands.id');
            $q->join('model_details', 'model_details.model_id', '=', 'models.id');
            $q->where('model_details.model_id',$model_id);
            // if($from_year !="" && $to_year !=""){
            //     $q->where('model_details.from_year',$from_year);
            //     $q->where('model_details.to_year',$to_year);
            // }
            $q->where('model_details.active','1');
            $q->orderBy('model_details.from_year','desc');
            $getModelDetails = $q->get();

            foreach ($getModelDetails as $key => $value) {
                if(!empty($value->image))
                {
                    $filePath = $this->USER_BASE_PATH.$value->category_image;
                    if(!empty($value->image) && file_exists($filePath))
                    {
                        $value->image = $this->USER_BASE_URL.'/'.$value->image;
                    }else{
                        $value->image = "";
                    }
                }
            }

        if(!empty($getModelDetails) && (count($getModelDetails) > 0)){
            $this->responseData = $getModelDetails;
            $this->msg =  "Success";
            $this->code = 1;     
        }else{
            $this->msg =  "ModelDetails record not founds!";
        }    
        
        Common::output($this->code, $this->msg, $this->responseData);
    }
}