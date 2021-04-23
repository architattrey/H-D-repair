
{!! Form::open(['url' => 'add-update-price-range','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <!-- column 6 -->
        <div class="col-sm-12">
            <!-- id in hidden field -->
            {{ Form::hidden('id',($data->id))}}
            <!-- range -->
            <div class="form-group">
                {{ Form::label('Price Range', ' Price Range', ['class' => 'name']) }}
                {{ Form::text('range',(!empty($data->range))?$data->range:old('range'),['class'=>'form-control','id'=>'price_range','placeholder'=>'Enter Price Range', 'required' => 'required']) }}
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