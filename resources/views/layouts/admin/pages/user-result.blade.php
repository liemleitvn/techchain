@extends('layouts.admin.master',['title'=>'User-result','name_content'=>'User-result'])
@section('script')
    <script src="{{url('admin/js/admin-user-result.js')}}"></script>
@stop
@section('content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
      <!-------------------------Table list question---------------------------------->
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover table-user-result">
              <thead>
                <tr>
                  <th class="id">ID</th>
                  <th>Email</th>
                  <th>Category</th>
                  <th class="phone">Phone</th>
                  <th class="address">Address</th>
                  <th class="">Link CV</th>
                  <th class="is_disable">Is_disable</th>
                  <th class="time">Date</th>
                  <th class="time">Start_time</th>
                  <th class="time">End_time</th>
                </tr>
              </thead>
              <tbody>
                @if($users)
                  @php $stt=0; @endphp
                @foreach($users as $user)
                  @if(!empty($user['start_time']) && !empty($user['end_time']))
                    @php $stt++; @endphp
                    <tr data-toggle="modal" data-target=".{{$user['id']}}" data-id='{{$user['id']}}'>
                      <td class="id">{{$stt}}</td>
                      <td>{{$user['email']}}</td>
                      <td>
                        @php $category = DB::table('categories')->select('name')->where('id',$user['category_id'])->first();@endphp
                        {{$category->name}}
                      </td>
                      <td>@if($user['phone_number']){{$user['phone_number']}} @else{{'NULL'}} @endif</td>
                      <td>@if($user['address']){{$user['address']}} @else{{'NULL'}} @endif</td>
                      <td>@if($user['cv_link']){{$user['cv_link']}} @else{{'NULL'}} @endif</td>
                      <td>{{$user['is_disable']}}</td>
                      <td>
                        {{\Carbon\Carbon::createFromTimeStamp(strtotime($user['created_at']))->diffForHumans()}}
                      </td>
                      <td>@if($user['start_time']){{$user['start_time']}} @else{{'NULL'}} @endif</td>
                      <td>@if($user['end_time']){{$user['end_time']}} @else{{'NULL'}} @endif</td>
                    </tr>
                    <div class="modal fade {{$user['id']}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title edit-title"><strong>User result: </strong>{{$user['email']}}</h3>
                              <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                          </div>
                          <div class="modal-body">
                            <div class='note'>
                              <lable>(*) NOTE:</lable>
                              <input type="checkbox" checked="checked">
                                <i>-> Answer of user</i> |
                              <strong style='color:red'>The answer</strong> <i>-> Answer false</i> |
                              <strong style='color:green'>The answer</strong> <i>-> Answer true</i>
                              <div class="form-group user-result">
                            </div> 
                            </div> 
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
                @endif
          </table>
      <!-------------------------Pagination---------------------------------->    
          {{ $users->links()}}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-------------------------Layout Edit question---------------------------------->
    </div>  
  </section>
@endsection()