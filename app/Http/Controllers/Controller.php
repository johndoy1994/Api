<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    // IMAGE PATH
    public $USER_BASE_PATH = "";
    public $USER_BASE_URL = "";
    public $API_KEY = "HCF5WOFP0GRAV33P2SFU";

    public function __construct()
    {
        $this->USER_BASE_PATH       = storage_path().'/app/belt/';
        $this->USER_BASE_URL        = url('storage/app/belt/');
        
        View::share('USER_BASE_PATH',$this->USER_BASE_PATH);
        View::share('USER_BASE_URL',$this->USER_BASE_URL);
        
    	View::share('recordsPerPage', [
            '0' => "0",
            '1' => "10",
            '2' => "20",
            '3' => "50",
            '4' => "100",
            '5' => "200",
            '6' => "500",
            '7' => "1000"
        ]);

    }

    /* == Generate Unique token ==*/
    public function generateApiToken($request)
    {
        $exclude_key = array();
        $temp_request = $request;
        ksort($temp_request);
        foreach ($exclude_key as $key => $value) {
            if(in_array($value, $this->request))
                unset($temp_request[$value]);
        }
        
        $data = implode("|", $temp_request);
        $data = $data."|";
        $data = substr($data , 0,100);
        $uniuqeToken = hash_hmac("sha1", $data, $this->API_KEY);
        return $uniuqeToken;
    }

    public static function recordsPerPage($page, $new=null) {
    	if(session()->has($page)) {
            if(isset($new)) {
                session()->put($page, $new);
            }
        } else {
            if(isset($new)) {
                session()->put($page, $new);
            } else {
                session()->put($page, env('DEFAULT_ROWSIZE_PERPAGE'));
            }
        }
        return session()->get($page) == 0 ? PHP_INT_MAX : session()->get($page);
    }
}
