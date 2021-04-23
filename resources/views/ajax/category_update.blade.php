
  {!! Form::open(['url' => 'add-update-category','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
       
        <!-- column 6 -->
        <div class="col-sm-12">
            <!-- id in hidden field -->
            {{ Form::hidden('id',($data->id))}}
            <!-- First Name -->
            <div class="form-group">
                {{ Form::label('categories', 'Category Name', ['class' => 'categories']) }}
                {{ Form::text('categories',(!empty($data->categories))?$data->categories:old('categories'),['class'=>'form-control','id'=>'categories','placeholder'=>'Category Name', 'required' => 'required']) }}
            </div>
            
        </div>
        <!--/column 12 -->
    </div>
    <!--/ row end -->
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">Update</button>
    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
    
</div>
{!! Form::close() !!}
@section('script')
 
@endsection