
<div class="modal-body">
    <!-- row strat -->
    <div class="row">
        <div class="col-sm-12">
            <div class="listing" style="background-color: white;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>state</th>
                            <th>City</th>  
                        </tr>
                    </thead>
                    <tbody>
                   
                        @if(!empty($appUser) && isset($appUser))
                      
                            @foreach($appUser as $key => $user)
                            @php 
                                $key++;
                            @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$user->name ?ucfirst($user->name):"NA" }}</td>
                                    <td>{{$user->phone_number ? $user->phone_number: "NA" }}</td>
                                    <td>{{$user->email_id ? $user->email_id: "NA" }}</td>
                                    <td>{{$user->gender ? $user->gender: "NA" }}</td>
                                    <td>{{$user->state ? ucfirst($user->state) : "NA" }}</td>
                                    <td>{{$user->city ? ucfirst($user->city): "NA" }}</td>
                                </tr>
                            @endforeach 
                        @else
                        <tr><td><p>User not found</p></td></tr>  
                        @endif  
                    </tbody> 
                </table>    
            </div>
        </div>   
    </div>
    <!--/ row end -->
    
</div>
 
 