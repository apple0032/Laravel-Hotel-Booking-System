<?php
namespace App\Helpers;

class AppHelper
{
      public function bladeHelper($someValue)
      {
             return "increment $someValue";
      }

     public function startQueryLog()
     {
           \DB::enableQueryLog();
     }

     public function showQueries()
     {
          dd(\DB::getQueryLog());
     }

     public static function instance()
     {
         return new AppHelper();
     }
     
     public function ObjectToArrayMap($object,$pk,$field){
         
        $array = array();
        foreach($object as $object_field){
            $array[$object_field[$pk]] = $object_field[$field];
        }
         
         return $array;
     }
}