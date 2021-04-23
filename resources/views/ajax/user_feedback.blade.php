
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <div class="col-sm-12">
            <div class="listing" style="background-color: white;">
                @if(!empty($usersFeedback) && isset($usersFeedback))
                    @foreach($usersFeedback as $feedback)
                <textarea class="form-control" row="3" disabled>{{(!empty($feedback->feedbacks) && isset($feedback->feedbacks)) ? $feedback->feedbacks:"NA"}}</textarea>
                    @endforeach
                @else
                <p>No feedbacks given by the user.</p>
                @endif
            </div>
        </div>   
    </div>
    <!--/ row end -->
</div>
 
 