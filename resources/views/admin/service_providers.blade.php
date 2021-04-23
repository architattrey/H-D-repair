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
        <li class="active">All Services Providers</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
           
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">

                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-service-providers','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By Pin Code']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" id="add_more">Add More Service Providers</button>
                    <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="#"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Emport xls file</button></a>
                    <a href="{{route('download-file')}}"><button type="button" class="btn btn-warning" style="margin:15px 0px 0px 37px;"><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; Export xls file</button></a>
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
                           
                                <th width="1%">#</th>
                                <th width="5%">Category</th>
                                <th width="5%">Sub Category</th>
                                <th width="5%">Name</th>
                                <th width="5%">Contact Number</th>
                                <th width="35%">Address</th>
                                <th width="5%">District</th>
                                <th width="5%">state</th>
                                <th width="5%">Pin Code</th> 
                                <th width="5%">Price</th> 
                                <th width="5%">Price Range</th> 
                                <th width="5%">Ratings</th> 
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                            @if(!empty($serviceProviders) && isset($serviceProviders ))
                                @foreach($serviceProviders  as $key => $provider)
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$provider->cat ?ucfirst($provider->cat):"NA" }}</td>
                                        <td>{{$provider->sub_cat ? ucfirst($provider->sub_cat): "NA" }}</td>
                                        <td>{{$provider->name ? ucfirst($provider->name): "NA" }}</td>
                                        <td>{{$provider->phone ? ucfirst($provider->phone): "NA" }}</td>
                                        <td><textarea class="form-control" row="3" disabled>{{$provider->address ? $provider->address: "NA" }}</textarea></td>
                                        <td>{{$provider->district ? ucfirst($provider->district): "NA" }}</td>
                                        <td>{{$provider->state ? ucfirst($provider->state) : "NA" }}</td>
                                        <td>{{$provider->pin_code ? $provider->pin_code : "NA" }}</td>
                                        <td>{{$provider->price ? $provider->price : "NA" }}</td>
                                        <td>{{$provider->priceRange['range'] ? $provider->priceRange['range'] : "NA" }}</td>
                                        <td>{{$provider->ratings ? $provider->ratings : "NA" }}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-pencil update-modal" style="font-size:16px;color:green" data-toggle="tooltip" title="Update Service Provider" id="{{$provider->id}}" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a href="#"><i class="fa fa-trash delete-service-provider" style="font-size:16px;color:red" data-toggle="tooltip" title="Delete Service Provider" id="{{$provider->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><td><p>Services Provider not found</p></td></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$serviceProviders->links()}}
                            </div>    
                        </div>     
                   </div>
                </div>
            </div>
        </div>
        <!-- add service providers modal -->
        <div class="modal fade" id="addServiceProvider" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want add Services Provider!</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row strat -->
                        <div class="row">
                            {!! Form::open(['url' => 'add-update-service-provider','enctype'=>'multipart/form-data','method'=>'POST']) !!}
                            <!-- column 6 -->
                            <div class="col-sm-6">
                                <!--  Categories -->
                                <div class="form-group">
                                    {{ Form::label('categories', ' Category Name', ['class' => 'name']) }}
                                    <select class="form-control" name="cat">
                                        <option value="">Please Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->categories}}">{{$category->categories}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- name -->
                                <div class="form-group">
                                    {{ Form::label('name', 'Name', ['class' => 'name']) }}
                                    {{ Form::text('name',old('name'),['class'=>'form-control','id'=>'name','placeholder'=>'Enter Name', 'required' => 'required']) }}
                                </div>
                                <!-- district -->
                                <div class="form-group">
                                    {{ Form::label('district', 'District', ['class' => 'district']) }}
                                    {{ Form::text('district',old('district'),['class'=>'form-control','id'=>'district','placeholder'=>'Enter District', 'required' => 'required']) }}
                                </div>
                                <!-- pin code -->
                                <div class="form-group">
                                    {{ Form::label('pin_code', 'Pin Code', ['class' => 'pin_code']) }}
                                    {{ Form::number('pin_code',old('pin_code'),['class'=>'form-control','id'=>'pin_code','placeholder'=>'Enter Pin code', 'required' => 'required']) }}
                                </div>
                                <!-- price -->
                                <div class="form-group">
                                    {{ Form::label('price', 'Price', ['class' => 'price']) }}
                                    {{ Form::number('price',old('price'),['class'=>'form-control','id'=>'price','placeholder'=>'Enter Price', 'required' => 'required']) }}
                                </div>
                            </div>
                            <!--/column 6  -->
                            <!-- column 6 -->
                            <div class="col-sm-6">
                               <!--  sub category -->
                               <div class="form-group">
                                    {{ Form::label('sub_category', 'Sub Category Name', ['class' => 'sub_category']) }}
                                    <select class="form-control" name="sub_cat">
                                        <option value="">Please Select Sub Category </option>
                                        @foreach($subCategories as $subcategory)
                                            <option value="{{$subcategory->sub_category}}">{{$subcategory->sub_category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    {{ Form::label('contact_number', 'Contact Number', ['class' => 'contact_number']) }}
                                    {{ Form::text('phone',old('phone'),['class'=>'form-control','id'=>'phone','placeholder'=>'Enter Contact Number', 'required' => 'required']) }}
                                </div>
                                <!--  states -->
                                <div class="form-group">
                                    {{ Form::label('state', 'State Name', ['class' => 'state']) }}
                                    <select class="form-control" name="subcat_id">
                                        <option value="">Please Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->state}}">{{$state->state}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--  address -->
                                <div class="form-group">
                                    {{ Form::label('address', 'Address', ['class' => 'address']) }}
                                    {{ Form::textarea('address', old('address'), ['rows'=> 3,'class'=>'form-control','id'=>'address','placeholder'=>'Enter Address', 'required' => 'required']) }}
                                </div>
                            </div>
                            <!--/column 6  -->  
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
         <div class="modal fade" id="updateServiceProvider" role="dialog">
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
        <!-- modal open for import file -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Import Bulk Data of Service provider</h4>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['url' => 'import-file','enctype'=>'multipart/form-data']) !!}
                        {{ Form::file('file',['class'=>'custom-file-input']) }}   
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- modal close -->
    </section>    
    <!-- /.content -->
@endsection
@section('script')
<script>

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();  
        $('#add_more').click(function(){
            $('#addServiceProvider').modal('show');
        });
        // update modal with filed data
        $('.update-modal').click(function(){
            var serviceProviderId =  $(this).attr('id');
            if(serviceProviderId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('update-view-service-provider')}}?serviceProviderId="+serviceProviderId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#updateServiceProvider').modal('show');
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
        $('.delete-service-provider').click(function(){
            var serviceProviderId =  $(this).attr('id');
            if(serviceProviderId != " "){  
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-service-provider')}}?serviceProviderId="+serviceProviderId,
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
 
