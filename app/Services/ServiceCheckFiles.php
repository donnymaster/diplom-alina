<?php

namespace App\Services;

class ServiceCheckFiles{
    public static function check($request, $old_files){

        $array_files = array();
        $new_files = array();

        if(!isset($request['file-0']) && $old_files != array()){
            return array();
        }

        if(isset($request['file-0'])){
            $iter = 0;
           while(isset($request['file-'.$iter])){
               array_push($array_files, $request['file-'.$iter]);
               $iter++;
           }
           for($j = 0; $j < count($old_files); $j++)
            {
                foreach ($array_files as $value) {
                    if($old_files[$j]->link == $value){
                        array_push($new_files, $old_files[$j]);
                    }
                }
            }
            return $new_files;
        }else{
            return false;
        }
    }
}