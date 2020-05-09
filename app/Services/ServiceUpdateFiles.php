<?php

namespace App\Services;

use App\Models\User;

class ServiceUpdateFiles{
    public static function update($request, $valid, $result_files){
        if(isset($request['attachment'])){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('works', User::where('employee_id', '=', $valid['employee_id'])->first()->id); 
            $end_result_json = json_encode(array_merge($json, $result_files));
           }else{
               if($result_files == array()){
                $end_result_json = null;
               }else{
                $end_result_json = json_encode($result_files);
               }
           }
           return $end_result_json;
    }
}