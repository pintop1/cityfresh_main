<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait GlobalMethods
{
	public $secret_key = 'sk_test_7ce4941d9b00428cabd5f4d180a698df3be16a6b';
  public $public_key = 'pk_test_8e0d0a112bc2bc6dcdc6523647be16f49805a83d';
  //public static $secret_key = 'sk_live_46b7739921e5520a9ad81daf1b3d01b9b8a0fa24';
  //public static $public_key = 'pk_live_57109d3903799da16ece01872bf2c103118af8d2';

  public function paystackGet($url){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
          "authorization: Bearer ".$this->secret_key,
          "content-type: application/json",
          "cache-control: no-cache",
        ],
      ));
      $response = curl_exec($curl);
      return json_decode($response);
  }

  public function paystackPost($url, $param){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode($param),
		CURLOPT_HTTPHEADER => [
		    "authorization: Bearer ".$this->secret_key,
		    "content-type: application/json",
		    "cache-control: no-cache",
		  ],
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$tranx = json_decode($response,true);
		return $tranx;
  }

  public function search_banks($search, $array) { 
      $ret = 0;
      foreach($array as $key => $arr) {
          if($arr->code == ucwords($search)){
              $ret += $key;
          }
      }
      return $ret;
  }

  public function randomId($table, $column = 'code'){
    $id = str_random(8);
    $validator = \Validator::make([$column=>$id],[$column=>'unique:'.$table]);
    if($validator->fails()){
        return $this->randomId();
    }
    return $id;
  }


}
