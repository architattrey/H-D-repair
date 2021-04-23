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
        <li class="active">All Sub Categories</li>
      </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
           
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">

                <div class="col-sm-6">
                    {!! Form::open(['url' => 'search-sub-category','method'=>'GET']) !!}
                        {{ Form::text('search',old('search'),['id'=>'search','placeholder'=>' Search By Name']) }}
                        <button type="submit" class="btn btn-warning" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Search</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" id="add_more">Add More Sub Categories</button>
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
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($subCategories ) && isset($subCategories ))
                                @foreach($subCategories  as $key => $subcat)
                                @php 
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$subcat->sub_category ? ucfirst($subcat->sub_category): "NA" }}</td>
                                        <td>{{$subcat->created_at ? date('d-m-Y',strtotime($subcat->created_at)): "NA"}}</td>
                                        <td>{{$subcat->updated_at ? date('d-m-Y',strtotime($subcat->updated_at)): "NA"}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-pencil update-modal" style="font-size:16px;color:green" data-toggle="tooltip" title="Update Sub Category" id="{{$subcat->id}}" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a href="#"><i class="fa fa-trash delete-sub-category" style="font-size:16px;color:red"  data-toggle="tooltip" title="Delete Sub Category" id="{{$subcat->id}}" aria-hidden="true"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                            <tr><td><p>Sub Categories not found</p></td></tr>  
                            @endif  
                        </tbody> 
                    </table>
                   <div class="row">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <div class ="pagination" style="margin-left: 75px;">
                                {{$subCategories->links()}}
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
                        <h4 class="modal-title">Do you want add Sub Category!</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row strat -->
                        <div class="row">
                            {!! Form::open(['url' => 'add-update-sub-category','enctype'=>'multipart/form-data','method'=>'POST']) !!}
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
                                <!--  Categories -->
                                <div class="form-group">
                                    {{ Form::label('sub_category', 'Sub Category Name', ['class' => 'name']) }}
                                    {{ Form::text('sub_category',old('sub_category'),['class'=>'form-control','id'=>'sub_category','placeholder'=>'Enter Sub Category Name', 'required' => 'required']) }}
                                    
                                </div>
                                
                            </div>
                            <!--/column 6  -->  
                        </div>
                        <!--/ row end -->
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
         <div class="modal fade" id="updateSubCategory" role="dialog">
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
            var subCategoryId =  $(this).attr('id');
            if(subCategoryId != " "){
                $.ajax({
                    type:"GET",
                    url:"{{url('update-view-sub-category')}}?subCategoryId="+subCategoryId,
                    success:function(res){   
                        if(res.status == "success"){
                            $('.append').html(res.html);
                            $('#updateSubCategory').modal('show');
                        }else{
                            swal("Something went wrong!", "Contact to administrator!", "error");
                        }
                    }
                });  
            }else{  
                swal("Something went wrong!", "Contact to administrator!", "error"); 
            } 
        });
        // update modal with filed data
        $('.delete-sub-category').click(function(){
            var subCategoryId =  $(this).attr('id');
            if(subCategoryId != " "){
                 
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-sub-category')}}?subCategoryId="+subCategoryId,
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
 
