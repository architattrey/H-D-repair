<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\models\User;
use App\models\Appusers;
use App\models\Category;
use App\models\SubCategory;
use App\models\AppBanner;
use App\models\ServiceFeature;
use App\models\ServiceFeatureType;
use App\models\Cart;
use App\models\UsersDeliveryAddress;
use App\models\UserTransactions;
use App\models\ReferalCode;
use App\models\Wallet;
use App\models\PriceRange;
use App\models\ServiceProvider;
use App\models\UsersFeedbacks;
use App\models\State;
use App\models\City;
 
 

use DateTime;
use HTML,Form,Validator,Mail,Response,Session,DB,Redirect,Image,Password,Cookie,File,View,Hash,JsValidator,Input,URL;

class AjaxController extends Controller
{
    #delete field boy
    public function deleteCategory(Request $request, $categoryId =NULL){
        try{
            if($request->categoryId){
               
                $category = Category::where('id', $request->categoryId)
                                    ->Where('delete_status','1')
                                    ->first();
                if(!empty($category)){
                    $result =  Category::where('id',$request->categoryId)->orWhere('delete_status',1)->update([
                      'delete_status' => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    # get update view for client
    public function RenderCategoryUpdateView(Request $request){
        try{
            if($request->categoryId){
                $data = Category::where('id',$request->categoryId)->first();
                
                if(!empty($data)){
                    $view = view("ajax.category_update",compact('data'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    #delete field boy
    public function deleteSubCategory(Request $request, $subCategoryId =NULL){
        try{
            if($request->subCategoryId){
               
                $subCategory = SubCategory::where('id', $request->subCategoryId)
                                    ->Where('delete_status','1')
                                    ->first();
                if(!empty($subCategory)){
                    $result =  SubCategory::where('id',$request->subCategoryId)->orWhere('delete_status',1)->update([
                      'delete_status' => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    # get update view for client
    public function RenderSubCategoryUpdateView(Request $request){
        try{
            if($request->subCategoryId){
                $data = SubCategory::where('id',$request->subCategoryId)->first();
                $categories = Category::where('delete_status','1')->get();
                $cat_name =Category::where('delete_status','1')->where('id',$data->cat_id)->first();
                
                if(!empty($data)){
                    $view = view("ajax.sub_category_update",compact('data','categories','cat_name'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    # get update view for service
    public function RenderServiceUpdateView(Request $request){
        try{
            if($request->servicefeatureId){
                $data = ServiceFeature::where('id',$request->servicefeatureId)->first();
                $categories = Category::where('delete_status','1')->get();
                $subCategories = SubCategory::where('delete_status','1')->get();
                $cat_name = Category::where('delete_status','1')->where('id',$data->cat_id)->first();
                $sub_cat_name = SubCategory::where('delete_status','1')->where('id',$data->subcat_id)->first();
                
                if(!empty($data)){
                    $view = view("ajax.service_feature_update",compact('data','categories','subCategories','cat_name','sub_cat_name'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    #delete Service
    public function deleteServiceFeature(Request $request, $servicefeatureId =NULL){
        try{
            if($request->servicefeatureId){
               
                $subCategory = ServiceFeature::where('id', $request->servicefeatureId)
                                    ->Where('delete_status','1')
                                    ->first();
                if(!empty($subCategory)){
                    $result =  ServiceFeature::where('id',$request->servicefeatureId)->orWhere('delete_status',1)->update([
                      'delete_status' => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    #render service type page
    public function RenderServiceTypeUpdateView(Request $request){
        try{
            if($request->serviceTypeId){
                $data = ServiceFeatureType::where('id',$request->serviceTypeId)->first();
                $service_type_name = ServiceFeature::where('delete_status','1')->where('id',$data->service_features_id)->first();
                $serviceFeature  = ServiceFeature::where('delete_status','1')->get();
                
                if(!empty($data)){
                    $view = view("ajax.service_type_update",compact('data','serviceFeature','service_type_name'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }

    }
    #delete Service type
    public function deleteServiceType(Request $request, $serviceTypeId =NULL){
        try{
            if($request->serviceTypeId){
               
                $type = ServiceFeatureType::where('id', $request->serviceTypeId)
                                    ->Where('delete_status','1')
                                    ->first();
                if(!empty($type)){
                    $result =  ServiceFeatureType::where('id',$request->serviceTypeId)->orWhere('delete_status',1)->update([
                      'delete_status' => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    #delete App Users
    public function deleteAppUsers(Request $request, $appUserId =NULL){
        try{
            if($request->appUserId){
                
               
                $appUser = Appusers::where('id', $request->appUserId)
                                    ->Where('delete_status','1')
                                    ->first();
                if(!empty($appUser)){
                    $result =  Appusers::where('id',$request->appUserId)->update([
                      'delete_status' => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    # render service provider page
    public function RenderServiceProviderUpdateView(Request $request){
        try{
            if($request->serviceProviderId){
                $data = ServiceProvider::where('delete_status','1')->where('id',$request->serviceProviderId)->first();
                $categories = Category::where('delete_status','1')->get();
                $subCategories = SubCategory::where('delete_status','1')->get();
                $states =  State::all();
               
                if(!empty($data)){
                    $view = view("ajax.service_provider_update",compact('data','categories','subCategories','states'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }

    }
     #delete Service
     public function deleteServiceProvider(Request $request, $serviceProviderId =NULL){
        try{
            if($request->serviceProviderId){
               
                $serviceProvider = ServiceProvider::where('id', $request->serviceProviderId)
                                    ->Where('delete_status','1')
                                    ->first();
                if(!empty($serviceProvider)){
                    $result =  ServiceProvider::where('id',$request->serviceProviderId)->update([
                      'delete_status' => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    # render assigned service provider 
    public function getAssignedServiceProviders(Request $request){
        try{
           
            if($request->serviceProviderId){
                $serviceProviders = ServiceProvider::where('delete_status','1')->where('id',$request->serviceProviderId)->get();
                
                if(!empty($serviceProviders)){
                    $view = view("ajax.assigned_service_provider",compact('serviceProviders'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }

    }  
    # render assigned user 
    public function getAssignedUser(Request $request){
        try{
            if($request->serviceUserId){
                $appUser = Appusers::where('delete_status','1')->where('id',$request->serviceUserId)->get();
              // dd($appUsers);
                if(count($appUser)!=0){
                    $view = view("ajax.assigned_user",compact('appUser'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please user id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }

    }
    # change payment status
    public function changePaymentStatus(Request $request){
        try{
            if($request->data){
                $transaction = UserTransactions::where('id',$request->data)->first();
                if($transaction){
                    $returnData = UserTransactions::where('id',$request->data)->update([
                        'dlvry_status'=>'1',
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Successfully changed the status',
                            'status'=>'success'
                        ]);  
                    }else{
                        return response()->json([
                            'message'=>'Something went wrong>please try again.',
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>'transactions not found.',
                        'status'=>'error'
                    ]);                
                }
            }else{
                return response()->json([
                    'message'=>'please transaction id',
                    'status'=>'error'
                ]);
            }  
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    # feedback of user
    public function viewFeedback(Request $request){
        try{
            if($request->transactionId){
                $usersFeedback = UsersFeedbacks::where('transaction_id',$request->transactionId)->get();
              // dd($usersFeedback);
                if(count($usersFeedback)!=0){
                    $view = view("ajax.user_feedback",compact('usersFeedback'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please user id',
                    'status'=>'error'
                ]);
            }

        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    # get update view for state
    public function RenderStateUpdateView(Request $request){
        try{
            if($request->stateId){
                $data = State::where('id',$request->stateId)->first();
                
                if(!empty($data)){
                    $view = view("ajax.state_update",compact('data'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    #delete state
    public function  deleteState(Request $request, $stateId =NULL){
        try{
            if($request->stateId){
                
                $state = State::where('id', $request->stateId)->first();
                if(!empty($state)){
                    $result =  State::where('id',$request->stateId)->delete();
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    #city update view
    public function RenderCityUpdateView(Request $request){
        try{
            if($request->cityId){
                $data = City::where('id',$request->cityId)->first();
                $state = State::where('id',$data->state_id)->first();
                $states =  State::all();
                
                if(!empty($data)){
                    $view = view("ajax.city_update",compact('data','state','states'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    #delete city
    public function  deleteCity(Request $request, $cityId =NULL){
        try{
            if($request->cityId){
                
                $city = City::where('id', $request->cityId)->first();
                if(!empty($city)){
                    $result =  City::where('id',$request->cityId)->delete();
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
    # get update view for price range
    public function RenderPriceRangeUpdateView(Request $request){
        try{
            if($request->priceRangeId){
                $data = PriceRange::where('id',$request->priceRangeId)->first();
                
                if(!empty($data)){
                    $view = view("ajax.price_range_update",compact('data'))->render();
                    return response()->json([
                        'status'=>'success',
                        'html'=>$view
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Data not found',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide id',
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'There is something wrong. Please contact administrator.'.$e->getMessage(),
                'status'=> 'error',
            ]);
        }
    }
    #delete price range
    public function deletePriceRange(Request $request, $priceRangeId =NULL){
        try{
            if($request->priceRangeId){
                $range = PriceRange::where('id', $request->priceRangeId)->first();
                if(!empty($range)){
                    $result =  PriceRange::where('id',$request->priceRangeId)->delete();
                    if($result){
                        return response()->json([
                            'message'=>'successfully deleted',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong.",
                            'status'=>'error'
                        ]);  
                    }
                }else{
                    return response()->json([
                        'message'=>"something went wrong.Please try again",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"something went wrong.Please try again",
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
