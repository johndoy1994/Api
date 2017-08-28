<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Http\Requests;
use DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Mail;

class CommonController extends Controller
{
    public static function output($code=0, $msg='', $responseData=array())
    {
    	header("Content-Type:text/json");
        
        $outputData = array(
            "code"		=>$code,
            "msg"		=>$msg,
            "response"	=>$responseData
        );
        
        echo json_encode($outputData);
        exit;
    }    

    public static function insert($table, $data)
    {
        $current_date = date("Y-m-d h:s:i");
        $data["created_at"] = $current_date;
        $data["updated_at"] = $current_date;
        
        $result = DB::table($table)->insertGetId($data);
        
        if($result > 0)
            return $result;
        else
            return false;
    }

    public static function updateById($table, $data, $id)
    {
        $current_date = date("Y-m-d h:s:i");
        $data["updated_at"] = $current_date;
        
        $result = DB::table($table)->where('id', $id)->update($data);
        if($result)
            return true;
        else
            return false;
    }

    public static function isExistEmail($email)
    {
    	$count = Users::where('email',$email)->count();
    	if($count > 0)
    		return true;
    	else
    		return false;
    }

   

    public static function isExistUserWithEmail($email)
    {   
        $result = Users::where('email',$email)->first();
        if(count($result) > 0)
            return $result;
        else
            return array();
    }

    public function getChangeStatus(Request $request)
    {
        $table_name  = $request->table_name;
        $status = $request->status;
        $rawId  = $request->rawId;

        if($status == "1"){
            DB::table($table_name)->where('id', $rawId)->update(['active'=>'0']);
            $status = "0";
        }else{
            DB::table($table_name)->where('id', $rawId)->update(['active'=>'1']);
            $status = "1";
        }
        return $status;
    }

    
    public static function sendMail($data)
    {
    	Mail::send($data['templateName'], array("data" => $data), function($message) use ($data)
        {
            $message->to($data['email'], $data['name'])->subject($data['subject']);
        });    
    }

    // Resize image to 100x100
    public static function resizeBase64ImageTo($size, $imageName, $imageData, $imagePath)
    {
        $background = Image::canvas($size, $size);
        $imageResized = Image::make(base64_decode($imageData))->resize($size, $size, function($c){
            $c->aspectRatio();
            $c->upsize();
        });
        $background->insert($imageResized, 'center');
        $background->save($imagePath.$size.'/'.$imageName);
    }

    public static function uploadBase64ProfilePicture($imageName, $image, $imagePath)
    {
        $savedImage = Image::make(base64_decode($image));
        $savedImage->save($imagePath.$imageName);

        if($savedImage) {
            //Resize image to 100x100 and 200x200
            // self::resizeImageTo(100,$imageName, $image, $imagePath);
            // self::resizeImageTo(200,$imageName, $image, $imagePath);
            return true;
        }else{
            return false;
        }
    }

    // Resize image to 100x100
    public static function resizeImageTo($size, $imageName, $imageFile, $imagePath)
    {
        $thumb_img = Image::make($imageFile->getRealPath())->resize($size, $size,function($constraint){
             $constraint->aspectRatio();
         });
         $thumb_img->save($imagePath.'/'.$imageName);
        return true;
    }
    public static function uploadProfilePicture($data)
    {
        $imgName            = !empty($data['imageName']) ? $data['imageName'] : "";
        $imgFile            = !empty($data['imageFile']) ? $data['imageFile'] : "";
        $destPath           = !empty($data['destPath']) ? $data['destPath'] : "";
        $resizeDestPath     = !empty($data['resizeDestPath']) ? $data['resizeDestPath'] : "";
        $resizeOriginal     = !empty($data['resizeOriginal']) ? $data['resizeOriginal'] : false;
        if(!empty($resizeDestPath)) // make thumbnail image
        {
            // resize 100x100
            self::resizeImageTo(100,$imgName, $imgFile, $resizeDestPath);
        }
        if($resizeOriginal) // resize original image
            $savedImage = self::resizeImageTo(300,$imgName, $imgFile, $destPath);
        else
            $savedImage = $imgFile->move($destPath, $imgName);
        
        if($savedImage)
            return true;
        else{
            return false;
        }
    }

    public static function removeOldFile($oldImageName, $destPath, $resizeDestPath = "")
    {
        $result = false;
        if(!empty($oldImageName))
        {
            $fileName = $destPath.$oldImageName;
            if(file_exists($fileName))
            {
                if(!empty($resizeDestPath) && file_exists($resizeDestPath.$oldImageName))
                {
                    unlink($resizeDestPath.$oldImageName);    
                }
                unlink($fileName);
                $result = true;
            }
        }
        return $result;
    }

    

    public function getRecordPerPage(Request $request) {
        $json = ['success'=>false, 'message'=>"Invalid request, try again"];

        if($request->has("target") && $request->has("value")) {
            Controller::recordsPerPage($request->target, $request->value);
            $json["success"] = true;
        }

        return response()->json($json);
    }

    public static function generateCode($length = 8) {
       $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
       $ret = '';
       for($i = 0; $i < $length; ++$i) {
         $random = str_shuffle($chars);
         $ret .= $random[0];
       }
       return $ret;
    }

}
