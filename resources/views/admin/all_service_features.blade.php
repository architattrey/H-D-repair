@extends('admin.layouts.app')

@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Services</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
           
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">

                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-service-feature','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By Type']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" id="add_more">Add More Service</button>
                </div> 
            </div>
        </div>
    </div>

    <!-- view list of agents -->
    <!-- Main content -->
    <section class="content">
        @if(Session::has('flash_message'))
        <div class="alert alert-success"><strong>Success!</strong>  {!! session('flash_message') !!}</div>
        @elseif(Session::has('flash_error'))
        <div class="alert alert-danger"><strong>Danger!</strong> {!! session('flash_error') !!} </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="listing" style="background-color: white;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sub Category</th>
                                <th>Service Type</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                            @if(!empty($serviceFeatures) && isset($serviceFeatures ))
                                @foreach($serviceFeatures  as $key => $service)
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                      
                                        <td>{{$key}}</td>
                                        <td>{{(!empty($service['subCategories']['sub_category']) && isset($service['subCategories']['sub_category']))?$service['subCategories']['sub_category'] :"NA"}}</td>
                                        <td>{{$service->service_type ? ucfirst($service->service_type): "NA" }}</td>
                                     

                                        <td>{{$service->created_at ? date('d-m-Y',strtotime($service->created_at)): "NA"}}</td>
                                        <td>{{$service->updated_at ? date('d-m-Y',strtotime($service->updated_at)): "NA"}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-pencil update-modal" style="font-size:16px;color:green" data-toggle="tooltip" title="Update Service Feature" id="{{$service->id}}" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a href="#"><i class="fa fa-trash delete-service-feature" style="font-size:16px;color:red" data-toggle="tooltip" title="Delete Service Feature" id="{{$service->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><td><p>Services not found</p></td></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$serviceFeatures->links()}}
                            </div>    
                        </div>     
                   </div>
                </div>
            </div>
        </div>
        <!-- add Filed Boy modal -->
        <div class="modal fade" id="addSubCategory" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want add Services!</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row strat -->
                        <div class="row">
                            {!! Form::open(['url' => 'add-update-service-feature','enctype'=>'multipart/form-data','method'=>'POST']) !!}
                            <!-- column 6 -->
                            <div class="col-sm-6">
                                <!--  Categories -->
                                <div class="form-group">
                                    {{ Form::label('categories', ' Category Name', ['class' => 'name']) }}
                                    <select class="form-control" name="cat_id">
                                        <option value="">Please Select Category First</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->categories}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--/column 6  -->
                            <!-- column 6 -->
                            <div class="col-sm-6">
                               <!--  sub category -->
                               <div class="form-group">
                                    {{ Form::label('sub_category', 'Sub Category Name', ['class' => 'sub_category']) }}
                                    <select class="form-control" name="subcat_id">
                                        <option value="">Please Select Sub Category </option>
                                        @foreach($subCategories as $subcategory)
                                            <option value="{{$subcategory->id}}">{{$subcategory->sub_category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--/column 6  -->  
                        </div>
                        <!--/ row end -->
                        <div class = "row">
                            <div class ='col-sm-12'>
                                <!--  Categories -->
                                <div class="form-group">
                                    {{ Form::label('service_type', 'Service type', ['class' => 'service_type']) }}
                                    {{ Form::text('service_type',old('service_type'),['class'=>'form-control','id'=>'service_type','placeholder'=>'Enter Service Type', 'required' => 'required']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- update Filed Boy modal -->
         <div class="modal fade" id="updateServiceFeature" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want update Sub Category</h4>
                    </div>
                    <div class="append">
                    <!-- you will append the html here -->
                    </div>
                </div>
            </div>
        </div> 
         
    </section>    
    <!-- /.content -->
@endsection
@section('script')
<script>
    
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();  
        $('#add_more').click(function(){
            $('#addSubCategory').modal('show');
        });
        
        // update modal with filed data
        $('.update-modal').click(function(){
            var servicefeatureId =  $(this).attr('id');
            if(servicefeatureId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('update-view-service-feature')}}?servicefeatureId="+servicefeatureId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#updateServiceFeature').modal('show');
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
        // delete data
        $('.delete-service-feature').click(function(){
            var servicefeatureId =  $(this).attr('id');
            if(servicefeatureId != " "){  
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-service-feature')}}?servicefeatureId="+servicefeatureId,
                    success:function(res){   
                        if(res.status == "success"){
                            location.reload();
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
    });
</script>
@endsection	
 
