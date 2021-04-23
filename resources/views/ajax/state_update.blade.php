
{!! Form::open(['url' => 'add-update-state','enctype'=>'multipart/form-data','method'=>'POST']) !!}
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <!-- column 6 -->
        <div class="col-sm-12">
            <!-- id in hidden field -->
            {{ Form::hidden('id',($data->id))}}
            <!-- state -->
            <div class="form-group">
                {{ Form::label('states', ' State Name', ['class' => 'name']) }}
                {{ Form::text('state',(!empty($data->state))?$data->state:old('state'),['class'=>'form-control','id'=>'state','placeholder'=>'Enter State Name', 'required' => 'required']) }}
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