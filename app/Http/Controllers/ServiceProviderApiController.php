<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\models\User;
use App\models\Appusers;
use App\models\ServiceProvider;
use App\models\UserTransactions;
use App\models\PriceRange;
use App\models\ServiceProviderDocuments;
 
use ValidatorImage,Validator,File;

class ServiceProviderApiController extends Controller
{
    public function serviceProviderLogin(Request $request){
        try{
            if(!empty($request->phone_number)){
                $response['base_url'] = "http://www.projects.estateahead.com/hd_repair/storage/app/public/";
                 
                $response['serviceProvider'] = ServiceProvider::where('phone',$request->phone_number)
                                            ->where('delete_status','1')
                                            ->first();
                $response['documents'] = ServiceProviderDocuments::where('service_provider_id',$response['serviceProvider']['id'])->where('delete_status','1')->get();
                if(!empty($response['serviceProvider'])){
                   
                    ServiceProvider::where('phone',$request->phone_number)->update([
                        'firebase_token'=>$request->firebase_token
                    ]);
                    return response()->json([
                        'message'=>'successfully login.',
                        'status'=>'success',
                        'code'=>200,
                        'response'=>$response
                    ]);
                }else{
                    $model =  new ServiceProvider();
                    $model->phone = $request->phone_number;
                    $model->firebase_token = $request->firebase_token;
                    $model->delete_status = '1';
                    $model->save();
                    if($model->id){
                        $documentModel =  new ServiceProviderDocuments();
                        $documentModel->service_provider_id = $model->id;
                        $documentModel->delete_status = '1';
                        $documentModel->save();
                        if($documentModel->id){
                            $response['serviceProvider'] = ServiceProvider::where('id',$model->id)
                                                                            ->where('delete_status','1')
                                                                            ->first();
                            $response['documents'] = ServiceProviderDocuments::where('service_provider_id',$model->id)
                                                                               ->where('delete_status','1')
                                                                               ->get();
                            return response()->json([
                                'message'=>'successfully registered.',
                                'status'=>'success',
                                'code'=>200,
                                'response'=>$response
                            ]);
                        }else{
                            return response()->json([
                                'message'=>'Information not Saved yet.',
                                'status'=>'error'
                            ]);
                        }
                    }
                }    
            }else{
                return response()->json([
                    'message'=>'Provide phone number and password',
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
    #service Provider profile update
    public function serviceProviderProfileUpdate(Request $request){
        try{
            $response = [];
            $serviceProviderId = $request->service_provider_id;
            //check request have data or not
            if(!empty($serviceProviderId) && isset($serviceProviderId)){
                $serviceProvider = ServiceProvider::where('id',$serviceProviderId)->first();
                //check user is in database
                if(!empty($serviceProvider) && isset($serviceProvider)) {
                    ServiceProvider::where('id',$serviceProviderId)->update([
                        
                       'name'       => $request->name,
                       'phone'      => $request->phone_number,
                       'district'   => $request->district,
                       'state'      => ucfirst($request->state),
                       'pin_code'   => $request->pin_code,
                       'address'    => $request->address,
                       'updated_at' => date("Y-m-d"),
                    ]);
                    
                    $response['serviceProvider'] =  ServiceProvider::where('id', $serviceProviderId)->first();
                    return response()->json([
                        'message'=>'Profile successfully updated',
                        'status'=>'success',
                        'data'=>$response
                    ]);
                }else{
                    return response()->json([
                        'message'=>'service Provider not found',
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
    #image upload
    public function imageUpload(Request $request){
        try{
            //check request have data or not
            if(!empty($request->service_provider_id) && isset($request->service_provider_id)){
                $serviceProvider = ServiceProvider::where('id',$request->service_provider_id)->first();
                //check user is in database
                if (!empty($serviceProvider) && isset($serviceProvider)) {
                    $validator = Validator::make($request->all(), ['image' => 'required']);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);
                    }
                    if($request->image){
                        $file_name = 'public/service_provider_images/_user'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image of user
                            $serviceProvider =   ServiceProvider::where('id', $request->service_provider_id)->first();
                            $serviceProvider->update(['image' => $file_name]);
                            $finalPath = $file_name ? url('/').'/storage/app/'.$file_name : url('/')."/public/dist/img/user-dummy-pic.png";
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
                        'message'=>'Majdoor not found',
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
    #change status
    public function changeStatus(Request $request){
        try{
           // print_r($request->all());die;
            if(!empty($request->service_provider_id)){
                $Data = ServiceProvider::where('id',$request->service_provider_id)
                                        ->where('delete_status','1')
                                        ->first();
                #status will update in enum formate
                if(!empty($Data)){
                    if(($request->status == '1') || ($request->status == '2')){
                        $returnData = ServiceProvider::where('id',$request->service_provider_id)->update(['status'=>$request->status]);
                        if($returnData){
                            return response()->json([
                                'message'=>'status updated.',
                                'status'=>'success',
                                'code'=>200,
                            ]);
                        }else{
                            return response()->json([
                                'message'=>'status not updated yet.',
                                'status' =>'error'
                            ]);
                        }
                    }else{
                        return response()->json([
                            'message'=>'status acceptable only in 1 or 2.',
                            'status' =>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Provider not found in our database.',
                        'status' =>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'Please provide id and status.',
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
    #update firebase token
    public function updateFireBaseToken(Request $request){
        try{
            if($request->serviceProviderId  &&  $request->fireBaseToken){
                $data = ServiceProvider::where('id',$request->serviceProviderId)->first();
                if($data){
                    $updateToken = ServiceProvider::where('id',$request->serviceProviderId)->update([
                        'firebase_token'    => $request->fireBaseToken,
                    ]);
                    if($updateToken){
                        return response()->json([
                            'message'=>"token successfully updated",
                            'status' =>'success',
                            'code' =>200,
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'token is not updated yet. please try again',
                            'status' =>'error',
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'majdoor is not found in database',
                        'status' =>'error',
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>' majdoorId or token not provided',
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
    #get Order Details
    public function getOrderDetails(Request $request){
        try{
            $service_type_ids = [];
            $response['service_type_data'] = [];
            if(!empty($request->service_provider_id)){
               $response['userTransections'] = $userTransections = UserTransactions::where('service_provider_id',$request->service_provider_id)->with(['serviceProvider'])->get();
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
                        'message'=>'All assigned tasks',
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message' => 'No tasks found',
                        'status' => 'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Please provide majdoor id',
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
    #upload doucments
    public function documentsImageUpload(Request $request){
        try{
            //check request have data or not
            if(!empty($request->service_provider_id) && isset($request->service_provider_id)){
                $serviceProvider = ServiceProvider::where('id',$request->service_provider_id)->first();
                //check user is in database
                if (!empty($serviceProvider) && isset($serviceProvider)) {
                    $validator = Validator::make($request->all(), ['image' => 'required']);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);
                    }
                    if($request->image && $request->type=='pan card'){
                        $file_name = 'service_provider_pancard/pancard'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image of user
                            $model = new ServiceProviderDocuments();
                            $model->service_provider_id =  $request->service_provider_id;
                            $model->documents =  $file_name;
                            $model->document_type = 'pan card';
                            $model->created_at = date('Y-m-d');
                            $model->delete_status = '1';
                            $model->save();
                            if($model->id){
                                return response()->json([
                                    'message'=>'Image successfully uploaded',
                                    'status'=>'success',
                                    'response'=>$model->id,
                                    'code'=>200
                                ]);
                            }else{
                                return response()->json([
                                    'message'=>'Something went wrong with uploading document',
                                    'status'=>'error'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'message'=>'Something went wrong with request.Please try again later',
                                'status'=>'error'
                            ]);
                        }
                    }elseif($request->image && $request->type=='adhar card'){
                        $file_name = 'service_provider_adharcard/adharcard'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image of user
                            $model = new ServiceProviderDocuments();
                            $model->service_provider_id =  $request->service_provider_id;
                            $model->documents =  $file_name;
                            $model->document_type = 'adhar card';
                            $model->delete_status = '1';
                            $model->created_at = date('Y-m-d');
                            $model->save();
                            if($model->id){
                                return response()->json([
                                    'message'=>'Image successfully uploaded',
                                    'status'=>'success',
                                    'response'=>$model->id,
                                    'code'=>200
                                ]);
                            }else{
                                return response()->json([
                                    'message'=>'Something went wrong with uploading document',
                                    'status'=>'error'
                                ]);
                            }
                        }else{
                            return response()->json([
                                'message'=>'Something went wrong with request.Please try again later',
                                'status'=>'error'
                            ]);
                        }
                    }elseif($request->image && $request->type=='bank details'){
                        $file_name = 'service_provider_bankdetails/bank_details'.time().'.png';
                        $path = Storage::put($file_name, base64_decode($request->image),'public');
                        if($path==true){
                            //update image of user
                            $model = new ServiceProviderDocuments();
                            $model->service_provider_id =  $request->service_provider_id;
                            $model->documents =  $file_name;
                            $model->document_type = 'bank details';
                            $model->delete_status = '1';
                            $model->created_at = date('Y-m-d');
                            $model->save();
                            if($model->id){
                                return response()->json([
                                    'message'=>'Image successfully uploaded',
                                    'status'=>'success',
                                    'response'=>$model->id,
                                    'code'=>200
                                ]);
                            }else{
                                return response()->json([
                                    'message'=>'Something went wrong with uploading document',
                                    'status'=>'error'
                                ]);
                            }
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
                        'message'=>'service provider not found',
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
    #save details for doc
    public function saveDocuments(Request $request){
        try{
            if($request->document_id && $request->service_provider_id){
                $data = ServiceProviderDocuments::where('id',$request->document_id)->first();
                if($data){
                    $returnData = ServiceProviderDocuments::where('id',$request->document_id)->update([
                                    'name_on_id'=>$request->name_on_id,
                                    'document_number'=>$request->document_number,
                                    'updated_at'=>date('Y-m-d')
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Data saved.',
                            'status'=>'success',
                            'code'=>200
                        ]);
                    }else{
                        return response()->json([
                            'message'=>'Something went wrong.Please contact to administrator.',
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>'Data not found with this document id.',
                        'status'=>'error'
                    ]);
                }
                $model = new ServiceProviderDocuments();
                $model->name_on_id =  $request->name_on_id;
                $model->document_number =  $request->document_number;
                $model->document_type = 'bank details';
                $model->save();
                if($model->id){
                    return response()->json([
                        'message'=>'Image successfully uploaded',
                        'status'=>'success',
                        'response'=>$model->id,
                        'code'=>200
                    ]);
                }else{
                    return response()->json([
                        'message'=>'Something went wrong with uploading document',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'please provide doccument id and service provide id',
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
    #get all Price Range
    public function getAllPriceRange(Request $request){
        try{
            $response['priceRanges'] = PriceRange::where('delete_status','1')->get();
            if($response['priceRanges']){
                return response()->json([
                    'message'=>'Price Range',
                    'status'=>'success',
                    'response'=>$response,
                    'code'=>200
                ]);
            }else{
                return response()->json([
                    'message'=>'Price Ranges not found',
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
    #update service provider id
    public function updatePrice(Request $request){
        try{
            if($request->service_provider_id){
                $data = ServiceProvider::where('id',$request->service_provider_id)->first();
                if($data){

                    $returnData = ServiceProvider::where('id',$request->service_provider_id)->update([
                            "price_range_id"=>$request->price_range_id,
                            "price"=>$request->price
                    ]);
                    if($returnData){
                        return response()->json([
                            "message"=>"Price and Price range is updated.",
                            "status"=>'success',
                            'code'=>200
                        ]);
                    }else{
                        return response()->json([
                            "message"=>"Price and Price range is not updated yet.",
                            "status"=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        "message"=>"Service Provider Not Found",
                        "status"=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    "message"=>"Please provide service provider id",
                    "status"=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                "message" => "Something went wrong. Please contact administrator.".$e->getMessage(),
                "status" =>'error',
            ]);
        }
    }
    # change payment status
    public function changePaymentStatus(Request $request){
        try{
            if($request->transaction_id){
                $transaction = UserTransactions::where('id',$request->transaction_id)->first();
                if($transaction){
                    #status will come in 1 or 2
                    $returnData = UserTransactions::where('id',$request->transaction_id)->update([
                        'dlvry_status'=>$request->status,
                        'updated_at'=> date('Y-m-d')
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Successfully changed the status',
                            'status'=>'success'
                        ]);  
                    }else{
                        return response()->json([
                            'message'=>'Something went wrong.please try again.',
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

}
