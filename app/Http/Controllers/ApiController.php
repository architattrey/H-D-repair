<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\models\User;
use App\models\Appusers;
use App\models\Category;
use App\models\SubCategory;
use App\models\AppBanner;
use App\models\ServiceFeature;
use App\models\ServiceFeatureType;
use App\models\ServiceProvider;
use App\models\Cart;
use App\models\UsersDeliveryAddress;
use App\models\UserTransactions;
use App\models\PriceRange;
use App\models\ReferalCode;
use App\models\Wallet;
use App\models\City;
use App\models\State;
use App\models\UsersFeedbacks;

use HTML,Form,Validator,Mail,Response,Session,DB,Redirect,Image,Password,Cookie,File,View,JsValidator,URL,Excel;

class ApiController extends Controller
{
    #user login or register
    public function login(Request $request){
        try{
            $appUsers = new Appusers();
            #login with phone number  
            if(!empty($request->phone_number)){
                #get data of user if phone_number will match
                $response['appusers']= $appuser = Appusers::where('phone_number',$request->phone_number)->first();
                if(!empty($response['appusers']) && isset($response['appusers'])) {
                    $updateToken = Appusers::where('id',$appuser->id)->update([
                        'firebase_token'    => $request->firebase_token,
                    ]);
                    #send response
                    return response()->json([
                        'message'=>'login successfully.',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    #register if user not found in database
                    //$appUsers->user_type = $appUsers->user_type;
                    // $appUsers->id            = "U";
                    $appUsers->name           = " ";
                    $appUsers->email_id       = " ";
                    $appUsers->phone_number   = $request->phone_number;
                    $appUsers->firebase_token = $request->firebase_token;
                    $appUsers->gender         = " ";
                    $appUsers->state          = " ";
                    $appUsers->city           = " ";                   
                    $appUsers->dob            = " ";
                    $appUsers->image          = " ";
                    $appUsers->delete_status  = "1";
                    $appUsers->created_at     = date("Y-m-d");
                    $appUsers->save();
                    if($appUsers->id){
                        $response['appusers'] = Appusers::where('id',$appUsers->id)->first();
                        return response()->json([
                            'message'=>'Registered successfully.',
                            'code'=>200,
                            'data' => $response,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong contact with administrator.",
                            'status'=>'error'
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'message'=>"Please provide atleast one login detail",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #app user profile update
    public function appUserProfileUpdate(Request $request){
        try{
            $appUserId = $request['user_id'];
            //check request have data or not
            if(!empty($appUserId) && isset($appUserId)){
                $appUser = Appusers::where('id',$appUserId)->first();
                //check user is in database
                if(!empty($appUser) && isset($appUser)) {
                    Appusers::where('id',$appUserId)->update([
                        
                       'name'         => $request->name,
                       'email_id'     => $request->email_id,
                       'phone_number' => $request->phone_number,
                       'gender'     => $request->gender,
                       'state'      => ucfirst($request->state),
                       'city'       => ucfirst($request->city),
                       'dob'        => $request->dob,
                       'updated_at' => date("Y-m-d"),
                    ]);
                    $response = [];
                    $response['appUser'] =  Appusers::where('id', $appUserId)->first();
                    return response()->json([
                        'message'=>'Profile successfully updated',
                        'status'=>'success',
                        'data'=>$response
                    ]);
                }else{
                    return response()->json([
                        'message'=>'User not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }        
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "status" =>'error',
            ]);
        }
    }
    # user image upload
    public function imageUpload(Request $request){
        try{

            $appUserId = $request['user_id'];
            //check request have data or not
            if(!empty($appUserId) && isset($appUserId)){
                $appUser = Appusers::where('id',$appUserId)->first();
                //check user is in database
                if (!empty($appUser) && isset($appUser)) {
                    $validator = Validator::make($request->all(), ['image' => 'required']);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);
                    }
                    if($request->image){
                        $file_name = 'public/user_images/_user'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image of user
                            $appUsers =   Appusers::where('id', $appUserId)->first();
                            $appUsers->update(['image' => $file_name]);
                            $finalPath = $file_name ? $file_name : "/public/dist/img/user-dummy-pic.png";
                            return response()->json([
                                'message'=>'Image successfully uploaded',
                                'status'=>'success',
                                'response'=>$finalPath,
                                'code'=>200
                            ]);

                        }else{
                            return response()->json([
                                'message'=>'Something went wrong with request.Please try again later',
                                'status'=>'error'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Please provide image for uploading',
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'User not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "error" =>true,
            ]);
        }
    }
    #update firebase token
    public function updateFireBaseToken(Request $request){
        try{
            if($request->id  &&  $request->fireBaseToken){
                $appUsers = Appusers::where('id',$request->id)->first();
                if($appUsers){
                    $updateToken = Appusers::where('id',$request->id)->update([
                        'firebase_token'    => $request->fireBaseToken,
                    ]);
                    if($updateToken){
                        return response()->json([
                            'agent_customers'=>"token successfully updated",
                            'status' =>'success',
                            'code' =>200,
                        ]);
                    }else{
                        return  response()->json([
                            'message'=>'token is not updated yet. please try again',
                            'status' =>'error',
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'user is not found in database',
                        'status' =>'error',
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>' userId or token not provided',
                    'status' =>'error',
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"something went wrong.Please contact administrator.".$e->getMessage(),
                'error' =>true,
            ]);
        }
    }
    #get all categories
    public function getAllCategories(Request $request){
        try{
            $allProducts = [];
            $categories = Category::where('delete_status','1')->get();
            $response['categories'] = $categories;
            if(!empty($response['categories'])){
                $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
                #send response
                return response()->json([
                    'message'=>'All Categories',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"no Categories found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get all sub categories
    public function getAllSubCategories(Request $request){
        try{
            if(!empty($request->cat_id)){
                $subcategories = SubCategory::where('cat_id',$request->cat_id)->where('delete_status','1')->get();
                $response['subcategories'] = $subcategories;
                if(!empty($response['subcategories'])){
                    $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
                    #send response
                    return response()->json([
                        'message'=>'All  Sub Categories',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no Sub Categories found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide category id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get all banners
    public function getAllBanners(Request $request){
        try{
            $response['appBanners'] =  $appBanners = AppBanner::all();
            if(count($appBanners) !=0){
                $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
                #send response
                return response()->json([
                    'message'=>'All banners',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"No data found.",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get all Service Features
    public function getAllServiceFeatures(Request $request){
        try{
            if(!empty($request->subcat_id)){
                $serviceFeatures = ServiceFeature::where('subcat_id',$request->subcat_id)
                                                 ->where('cat_id',$request->cat_id)
                                                 ->where('delete_status','1')
                                                 ->get();
                if(count($serviceFeatures) != 0){
                    #send response
                    return response()->json([
                        'message'=>'All Sub Categories Service features',
                        'code'=>200,
                        'data'=>$serviceFeatures,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"Features not found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide sub category id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get all Service Features types
    public function getAllServiceFeaturesTypes(Request $request){
        try{
            if(!empty($request->service_feature_id)){
                $serviceFtrType = ServiceFeatureType::where('service_features_id',$request->service_feature_id)
                                                     ->where('delete_status','1')
                                                     ->get();
                if(count($serviceFtrType) != 0){
                    #send response
                    return response()->json([
                        'message'=>'All Service features type with price',
                        'code'=>200,
                        'data'=>$serviceFtrType,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"Feature type not found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide service features id id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #add cart 
    public function addToCart(Request $request){
        try{
            if(!empty($request->service_type_id) && !empty($request->user_id)){
                $cart =  new Cart();
                $cart->service_type_id = $request->service_type_id;
                $cart->user_id = $request->user_id;
                $cart->created_at = date('Y-m-d');
                $cart->save();
                if($cart->id){
                    return response()->json([
                        'message'=>"service has been successfully added in the cart",
                        "code"=>200,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"Sorry we cant add product in the cart. Please try again.",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide service type  and user id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #view cart 
    public function viewCartOfUser(Request $request){
        try{
            $userCartProducts = [];
           
            if(!empty($request->user_id)){
                $appUser = Appusers::where('id',$request->user_id)->first();
                if(!empty($appUser)){
                    $cart = Cart::where('user_id',$request->user_id)->get(); 
                    for($i=0; $i<count($cart); $i++){
                        $product = ServiceFeatureType::where('id',$cart[$i]['service_type_id'])->with(["getCart"])->get();
                        
                        if($product != NULL){
                            array_push($userCartProducts,$product);
                        }
                    }
                    $response['user_services'] =  $userCartProducts;
                    if(!empty($response['user_services'])){
                        #send response
                        return response()->json([
                            'message'=>'user services',
                            'code'=>200,
                            'data'=>$response,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"Product not found in the database please provide excisting user id",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"User not found in the database please provide excisting user id",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide user id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #delete product from the cart
    public function deleteserviceFromCart(Request $request){
        try{
            $carts = FALSE;
            if($request->cart_id){
                for($i=0; $i<count($request->cart_id); $i++){
                    $cart_id       = $request->cart_id[$i]['id'];
                    $productsPrice = DB::table('cart')->where('id',$cart_id)->get();
                    if(count($productsPrice) != 0){
                        $cart = DB::table('cart')->where('id',$cart_id)->delete();
                        $carts = $cart;
                        break;
                    } 
                } 
                if($carts==TRUE){
                    #send response
                    return response()->json([
                        'message'=>'Deleted successfully',
                        'code'=>200,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"cart not deleted yet.Please try again later.",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide Cart id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #add delivery address of user
    public function AddUsersDeliveryAddress(Request  $request){
        try{
            if(!empty($request->user_id) && !empty($request->dlvry_address)){
                $model = new UsersDeliveryAddress();
                $model->user_id       = $request->user_id;
                $model->dlvry_address = $request->dlvry_address;
                $model->lat = $request->lat;
                $model->lng = $request->lng;
                $model->created_at    = date("Y-m-d");
                $model->save();
                if($model->id){
                    #send response
                    return response()->json([
                        'message'=>'address successfully added',
                        'code'=>200,
                        'status'=>'success'
                    ]); 
                }else{
                    return response()->json([
                        'message'=>"address not successfully added",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide all ids first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get delivery address of user 
    public function getDeliveryAddress(Request $request){
        try{
            if(!empty($request->user_id)){
                $response['deliveryAddress'] = UsersDeliveryAddress::where('user_id',$request->user_id)->get();
                if($response['deliveryAddress']){
                    #send response
                    return response()->json([
                        'message'=>'All address of this user.',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message' => ' Delivery address not found of this user',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide user id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    # delete delivery 
    public function deleteDeliveryAddress(Request $request){
        try{
            if(!empty($request->dlvry_id) && !empty($request->user_id)){
                $dlvryAddress = UsersDeliveryAddress::where('id',$request->dlvry_id)
                                                      ->where('user_id',$request->user_id)
                                                      ->get();
                if(!empty($dlvryAddress)){
                    $action = DB::table('users_delivery_addresses')->where('id',$request->dlvry_id)->delete();
                    if($action==TRUE){
                        #send response
                        return response()->json([
                            'message'=>'Deleted successfully',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"Delivery address not deleted yet.Please try again later.",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"Delivery address not found in the database",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Please provide dlvry id and user id",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    # get all service provider for user
    public function getServiceProvider(Request $request){
        try{
            $data = [];
            $data_subcat = [];
            $subcat_ids = [];
            $subcat_names = [];
            $service_providers = [];
            if($request->lat && $request->lng){
                #get service feature ids from service feature type table
                for($i=0; $i<count($request->service_type_id); $i++){
                    $service_type_ids = $request->service_type_id[$i]['id'];
                    $service_feature_id = ServiceFeatureType::where('id',$service_type_ids)->pluck('service_features_id')->first();
                    array_push($data,$service_feature_id); 
                }
               // print_r($data);die;
                #get subcat id from service feature table
                for($i=0; $i<count($data); $i++){
                    $subcat_id = ServiceFeature::where('id',$data[$i])->where('delete_status','1')->pluck('subcat_id')->first();
                    array_push($subcat_ids,$subcat_id);
                }
                // print_r($subcat_ids);die;
                #get subcat name from subcat table
                for($i=0; $i<count($subcat_ids); $i++){
                    $subcat_name = SubCategory::where('id',$subcat_ids[$i])->where('delete_status','1')->pluck('sub_category')->first();
                    array_push($subcat_names,$subcat_name);
                }
                #get service provider data
                for($i=0; $i<count($subcat_names); $i++){
                    $service_provider = ServiceProvider::where('sub_cat',$subcat_names[$i])->where('delete_status','1')->orderBy('ratings','DESC')->get();
                } 
                //echo count($service_provider);die;
                // print_r($service_provider);die;
                for($i=0; $i<count($service_provider);$i++){
                    //echo $service_provider[$i]['address']."--------------";
                    #get lat lng of service provider
                    $getPlace=str_replace(" ","+",$service_provider[$i]['address']);
                    $getDistrict=str_replace(" ","+",$service_provider[$i]['district']);
                    $getState=str_replace(" ","+",$service_provider[$i]['state']);
                    // echo $getPlace."<br>";                    
                    $url='https://maps.googleapis.com/maps/api/geocode/json?address='.$getPlace.$getDistrict.$getState.'&key=AIzaSyAsIP_aIzGh8Qlcap9VQrBa9B_W_TJId0k';
                    //echo $url;die;
                    $ch = curl_init();
                    $timeout = 5;
                    
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

                    $data = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($data);
                   
                    #save lat long in the variables;
                    //echo " ".$i." lat=".$provider_lat."      "."lng=".$provider_lng;
                    if($data->results!=NULL){
                        $provider_lat = $data->results[0]->geometry->location->lat;
                        $provider_lng = $data->results[0]->geometry->location->lng;
                        #difference btwn user and provider
                        if($provider_lat !=0 && $provider_lng!=0){
                            $difference = $this->distance($request->lat, $request->lng, $provider_lat, $provider_lng, "K");
                            if(round($difference) < '20'){
                                #get service providers for user according to requirement
                                if($i<10){
                                    array_push($service_providers,$service_provider[$i]);  
                                }else{
                                    break;
                                }
                            }
                        }
                    } 
                }
                if(count($service_providers)!=0){
                    #send response
                    return response()->json([
                        'message'=>'service Providers in your area.',
                        'status' =>'success',
                        'code'=>200,
                        'response'=>$service_providers
                    ]);
                }else{
                    return response()->json([
                        'message'=>'No service Provider Found in your area.',
                        'status' =>'error'
                    ]);
                }
                //print_r($service_providers);die;
            }else{
                return response()->json([
                    'message'=>'Please provide users lat lng',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #difference btwn lat lng
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        // return $lat1." ".$lon1.' '.$lat2." ".$lon2." ".$unit;
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
        }else{
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
        
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
    #save transactions of user
    public function submitTransaction(Request $request){
        //try{
            $data = [];
           // print_r($request->all());die;
            if($request->order_id){
                #save transaction
                for($i=0; $i<count($request->service_type_id); $i++){
                    $service_type_ids = $request->service_type_id[$i]['id'];
                    array_push($data,$service_type_ids);
                }
                $model = new UserTransactions();
                $model->order_id = $request->order_id;
                $model->user_id  = $request->user_id;
                $model->service_provider_id = $request->service_provider_id;
                $model->service_type_id = json_encode($data);
                $model->invoice_id      = rand(10,1000);
                $model->amount          = $request->amount;
                $model->phone_number    = $request->phone_number;
                $model->dlvry_address   = $request->dlvry_address;
                $model->lat  = $request->lat;
                $model->lng  = $request->lng;
                $model->dlvry_status = "0";
                $model->created_at   = date('Y-m-d');
                $model->save();
                 
                #update cart as well
                if($model->id){
                    $response['serviceProvider'] = ServiceProvider::where('id',$request->service_provider_id)->first();
                    
                    # send sms to user
                        $authKey = "782a3998b8c705c6f6a650897f4f3403";
                        $mobileNumber =  $response['serviceProvider']->phone;
                        $senderId = "REPAIR";
                        $message = "You have received new request of user from ".$request->dlvry_address. " Check on your mobile application.";
                        $route = "4";
                        //Prepare you post parameters
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $mobileNumber,
                            'message' => $message,
                            'sender'  => $senderId,
                            'route'   => $route
                        );
                        //API URL
                        $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                        // init the resource
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                            //,CURLOPT_FOLLOWLOCATION => true
                        ));
                        //Ignore SSL certificate verification
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        //get response
                        $output = curl_exec($ch);
                        //Print error if any
                        if (curl_errno($ch)) {
                            return response()->json([
                                'message'=>'Something went wrong with sms gateway. so we are unable to send sms to user.',
                                'status'=>'error'
                            ]);  
                        }
                        curl_close($ch);
                    DB::table('cart')->where('user_id',$request->user_id)->delete();
                    return response()->json([
                        'message'=>'Transaction successfully added.',
                        'code'=>200,
                        'transactionId'=>$model->id,
                        'serviceProvider'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Transaction not saved yet. Please try again later',
                        'status' =>'error'
                    ]);
                }   
            }else{
                return response()->json([
                    'message'=>'No any service provider in your area.',
                    'status' =>'error'
                ]);
            }       
        // }catch(\Exception $e){
        //     return response()->json([
        //         'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
        //         'status' =>'error'
        //     ]);
        // }
    }
   
    #update transactions status
    public function updateTransaction(Request $request){
        try{
            if(!empty($request->id)){
                $returnData = UserTransactions::where('id',$request->id)->update([
                    'dlvry_address'=> '1',
                    'updated_at'=> date('Y-m-d')
                ]);
                if($returnData){
                    return response()->json([
                        'message'=>'Transaction successfully updated.',
                        'code'=>200,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'something went wrong with update the data.Please try again.',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Please provide transaction id',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }

    }
    #old Transactions
    public function oldTransactions(Request $request){
        try{
            $service_type_ids = [];
            $response['service_type_data'] = [];
            if(!empty($request->user_id)){
               $response['userTransections'] = $userTransections = UserTransactions::where('user_id',$request->user_id)->with(['serviceProvider'])->get();
                for($i=0; $i<count($userTransections); $i++){
                    $service_type_id =  json_decode($userTransections[$i]->service_type_id);
                    array_push($service_type_ids,$service_type_id);
                }
                for($i=0; $i<count($service_type_ids); $i++){
                    for($j=0; $j<count($service_type_ids[$i]); $j++){
                       
                        $serviceType = ServiceFeatureType::where('id', $service_type_ids[$i][$j])->where('delete_status','1')->first();
                        array_push($response['service_type_data'],$serviceType);
                    }
                }
                if($response){
                    #send response
                    return response()->json([
                        'message'=>'All transections of this user.dlvry status key will come with 2 integer value 0=placed, 1=success',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message' => 'Transections not found of this user',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide user id',
                    'status' => 'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #generate referal code
    public function addReferalCode(Request $request){
        try{
            if(!empty($request->user_id)){
                $model = new ReferalCode();
                $model->user_id      = $request->user_id;
                $model->referal_code =  "";
                $model->redmeed_id   =  $request->redmeed_id;
                $model->delete_status = '1';
                $model->created_at = date('Y-m-d');
                $model->save();
                if($model->id){
                    $referal_code = "HD-ID".$request->user_id."-".rand(10000,20000);
                    $returnData = ReferalCode::where('id',$model->id)->update([
                        'referal_code' => $referal_code,
                    ]);
                    if($returnData){
                        #send response
                        return response()->json([
                            'message'=>'new referal code for this user',
                            'code'=>200,
                            'data'=>$referal_code,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'Something went wrong.Please contact to administrator.',
                            'status' =>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Referal code is not inserted yet.Please contact to administrator.',
                        'status' =>'error'
                    ]);
                }  
            }else{
                return response()->json([
                    'message'=>'please provide the user id',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #insert redemed data
    public function addRedemeedData(Request $request){
        try{
            if(!empty($request->redemeed_id) && !empty($request->referal_code)){
                 
                $findReferalCode = ReferalCode::where('referal_code',$request->referal_code)->first();
                //$findRdmdId = ReferalCode::where('redmeed_id',$request->redemeed_id)->first();
               // print_r($findReferalCode['redmeed_id']);die;

				#check redmeed id is exist ot not
                if(($findReferalCode['redmeed_id'] != $request->redemeed_id) && ($findReferalCode['user_id'] != $request->redemeed_id)){
                         
                    if(empty($findReferalCode->redmeed_id)){
                        #inseert redmeed if
                        $returnData = ReferalCode::where('referal_code',$request->referal_code)->update([
                            'redmeed_id'=> $request->redemeed_id,
                            'updated_at'=> date('Y-m-d')
                        ]);
                        if($returnData){
                            #add data in wallet
                            $model = new Wallet();
                            $model->user_id = $findReferalCode->user_id;
                            $model->redmeed_id = $request->redemeed_id;
                            $model->amount  = 20;
                            $model->method  = "by referal";
                            $model->transaction_type = "Credit";
                            $model->created_at = date('Y-m-d');
                            $model->save();
                            if($model->id){
                                $appUser = Appusers::where('id',$findReferalCode->user_id)->first();
                                #send notification for update wallet balance
                                //Your authentication key
                                $authKey = "782a3998b8c705c6f6a650897f4f3403";
                                //Multiple mobiles numbers separated by comma
                                $mobileNumber = $appUser->phone_number;
                                //Sender ID,While using route4 sender id should be 6 characters long.
                                $senderId = "REPAIR";
                                //Your message to send, Add URL encoding here.
                                $message = "Congratulation! 20Rs credited in your wallet check now: http://bit.ly/2J7Zdw4";
                                //Define route 
                                $route = "4";
                                //Prepare you post parameters
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender'  => $senderId,
                                    'route'   => $route
                                );
                                //API URL
                                $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                                // init the resource
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                //Ignore SSL certificate verification
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                //get response
                                $output = curl_exec($ch);
                                //Print error if any
                                if (curl_errno($ch)) {
                                    return response()->json([
                                        'message'=>curl_error($ch)."sms did not send but all operation has been successful",
                                        'status' =>'error'
                                    ]);
                                }
                                curl_close($ch);
                                #send response
                                return response()->json([
                                    'message'=>'add money in the wallet also update redmeed_id',
                                    'code'=>200,
                                    'status'=>'success'
                                ]);
                            }else{
                                return response()->json([
                                    'message'=>'updated redmeed id but not saved data in wallet.Pease Contact to administrator',
                                    'status' =>'error'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'message'=>'Something went wrong.Please try again',
                                'status' =>'error'
                            ]);
                        } 
                    }else{
                        return response()->json([
                            'message'=>'Referal code already used.',
                            'status' =>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'You cant apply more than one time and also can not apply same user',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide the redemeed id and referal code.',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get all amount of wallet for particular id
    public function getAllWalletAmount(Request $request){
        try{
            $appUsers = [];
            if(!empty($request->user_id)){
                $walletData = Wallet::where('user_id',$request->user_id)->get();
                for($i=0; $i<count($walletData); $i++){
                    $userId = $walletData[$i]['redmeed_id'];
                    $userData = Appusers::where('id',$userId)->get();                          
                    if($userData != NULL){
                        array_push($appUsers,$userData);
                    }
                }
                $response['walletData'] = $walletData;
                $response['redmeedUsers'] = $appUsers;
                if(count($walletData)!= 0 && count($walletData)!= 0 ){
                    #send response
                    return response()->json([
                        'message'=>'Wallet',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Provide user id first',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Provide user id first',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #search
    public function searchBySubCategory(Request $request){
        try{
            if(!empty($request->search)){
                $response['subCategory'] = SubCategory::where('delete_status','1')
                                           ->where('sub_category','LIKE','%'.$request->search.'%')
                                           ->get();
                if(!empty($response['subCategory'])){
                    #send response
                    $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
                    return response()->json([
                        'message'=>'Wallet',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }
                else{
                    return response()->json([
                        'message'=>"no Sub Categories found",
                        'status'=>'error'
                    ]);  
                }             
            }else{
                $response['subCategory'] = SubCategory::where('delete_status','1')->get();
                if(!empty($response['subCategory'])){
                    $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
                    #send response
                    return response()->json([
                        'message'=>'Wallet',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }
                else{
                    return response()->json([
                        'message'=>"no Sub Categories found",
                        'status'=>'error'
                    ]);  
                }
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #addition of amount of services
    public function additionOfAmount(Request $request){
        try{
            $productsPrices = [];
            $addition = 0;
            if($request->user_id){
                $carts = Cart::where('user_id',$request->user_id)->get();
                
                #get products price
                for($i=0; $i<count($carts); $i++){
                    $product_id  = $carts[$i]->service_type_id;
                    $productsPrice = DB::table('service_feature_types')->where('id',$product_id)
                                                          ->select('price')
                                                          ->get();
                    if($productsPrice != NULL){
                        array_push($productsPrices,$productsPrice);
                    }
                }
               
                #get sum of prices
                for($i=0; $i<count($productsPrices); $i++){
                    $addition = $addition + $productsPrices[$i][0]->price;
                }
                $response['totalAmount'] = $addition;
                if(!empty($response['totalAmount'])){
                    #send response
                    return response()->json([
                        'message'=>'Total amount',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>'No Amount found.',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Please provide user id',
                    'status' =>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
    #get states
    public function getAllStates(Request $request){
        try{
            $response['states'] = State::all();
            if(!empty($response['states'])){
                #send response
                return response()->json([
                    'message'=>'All states',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"no states found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get cities based on state id
    public function getAllCities(Request $request){
        try{
            if($request->state_id){
                $response['cities'] = City::where('state_id',$request->state_id)->get();
                if(!empty($response['cities'])){
                    #send response
                    return response()->json([
                        'message'=>'All Cities',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"no cities found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Please provide state id first",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #Add feedbacks of user
    public function addFeedbacks(Request $request){
        try{
            if(!empty($request->user_id) && !empty($request->transaction_id) && !empty($request->provider_id)){
                if($request->status =="2"){
                    $model = new UsersFeedbacks();
                    $model->user_id        = $request->user_id;
                    $model->transaction_id = $request->transaction_id;
                    $model->feedbacks      = $request->feedbacks;
                    $model->created_at     = date('Y-m-d');
                    $model->save();
                    if($model->id){
                        $returnData = UserTransactions::where('id',$request->transaction_id)->update([
                            'dlvry_status'=>$request->status,
                        ]);
                        #send sms for user and provider
                        if($returnData){
                            $appUser = Appusers::where('id',$request->user_id)->first();
                            if(!empty($appUser)){
                                //Your authentication key
                                $authKey = "782a3998b8c705c6f6a650897f4f3403";
                                //Multiple mobiles numbers separated by comma
                                $mobileNumber = $appUser->phone_number;
                               // $mobileNumber = 9568083266;
                                //Sender ID,While using route4 sender id should be 6 characters long.
                                $senderId = "REPAIR";
                                //Your message to send, Add URL encoding here.
                                $message = "You have been successfully cancelled Your order.";
                                //Define route 
                                $route = "4";
                                //Prepare you post parameters
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender'  => $senderId,
                                    'route'   => $route
                                );
                                //API URL
                                $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                                // init the resource
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                //Ignore SSL certificate verification
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                //get response
                                $output = curl_exec($ch);
                                //Print error if any
                                if (curl_errno($ch)) {
                                    return response()->json([
                                        'message'=>curl_error($ch)."sms did not send but all operation has been successful",
                                        'status' =>'error'
                                    ]);
                                }
                                curl_close($ch);
                            }else{
                                return response()->json([
                                    'message'=>"transaction has been updated but something went wrong with find the user for the phone number"
                                ]);
                            }
                            $appProvider = ServiceProvider::where('id',$request->provider_id)->first();
                            if(!empty($appProvider)){
                                //Your authentication key
                                $authKey = "782a3998b8c705c6f6a650897f4f3403";
                                //Multiple mobiles numbers separated by comma
                                //$mobileNumber = $appProvider->phone_number;
                                $mobileNumber = 9568083266;
                                //Sender ID,While using route4 sender id should be 6 characters long.
                                $senderId = "REPAIR";
                                //Your message to send, Add URL encoding here.
                                $message = $appUser->name." has calncelled the order";
                                //Define route 
                                $route = "4";
                                //Prepare you post parameters
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender'  => $senderId,
                                    'route'   => $route
                                );
                                //API URL
                                $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
                                // init the resource
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                //Ignore SSL certificate verification
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                //get response
                                $output = curl_exec($ch);
                                //Print error if any
                                if (curl_errno($ch)) {
                                    return response()->json([
                                        'message'=>curl_error($ch)."sms did not send but all operation has been successful",
                                        'status' =>'error'
                                    ]);
                                }
                                curl_close($ch);
                                #send response
                                return response()->json([
                                    'message'=>'Feedback successfully added. Transaction also updated with cancelation',
                                    'code'=>200,
                                    'status'=>'success'
                                ]);

                            }else{
                               #send response
                                return response()->json([
                                    'message'=>'Feedback successfully added.',
                                    'code'=>200,
                                    'status'=>'success'
                                ]);
                            }
                        }else{
                            #send response
                            return response()->json([
                                'message'=>'Feedback successfully added.',
                                'code'=>200,
                                'status'=>'success'
                            ]);
                        }  
                    }else{
                        return response()->json([
                            'message'=>'feedback not saved yet. Please try again later',
                            'status' =>'error'
                        ]);  
                    }
                }else{
                    # if feedback comes after transaction success
                    $model = new UsersFeedbacks();
                    $model->user_id    = $request->user_id;
                    $model->transaction_id = $request->transaction_id;
                    $model->feedbacks   = $request->feedbacks;
                    $model->created_at = date('Y-m-d');
                    $model->save();
                    if($model->id){ 
                        #send response
                        return response()->json([
                            'message'=>'Feedback successfully added.',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'feedback not saved yet. Please try again later',
                            'status' =>'error'
                        ]);  
                    }
                }
            }else{
                return response()->json([
                    'message'=>'Please provide data',
                    'status' =>'error'
                ]);   
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }  
    }
    # get users feedbacks
    public function getUsersFeedback(Request $request){
        try{
            $response = [];
            $usersFeedbacks = []; 
            $users = Appusers::all();

            for($i=0; $i<count($users); $i++){

                $feedbacks = Appusers::where('id',$users[$i]['id'])->with(["getUsersFeedbacks"])->get();
                
                if(count($feedbacks) != 0){
                    array_push($usersFeedbacks,$feedbacks);
                }
            }
            $response['users_feedbacks'] =  $usersFeedbacks;
            $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
            if(!empty($response['users_feedbacks'])){
                #send response
                return response()->json([
                    'message'=>'Users Feedbacks',
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"data not found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong. Please contact administrator.'.$e->getMessage(),
                'status' =>'error'
            ]);
        }
    }
}
