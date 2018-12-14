@extends('layouts.admin.master',['title'=>'Level','name_content'=>'Level'])
@section('script')
    <script src="{{url('admin/js/admin-level.js')}}"></script>
@stop
@section('content')
  <section class="content">
    <div class="row">
        <div class="col-xs-12">
        <div class="box">
          <div class="col-xs-12 add">
          <!------------Form add level---------->
              <input type="hidden" name='_token' value="{{csrf_token()}}">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="btn-category">
                Add <span><i class="fa fa-plus-square"></i></span>
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title" id="exampleModalCenterTitle">Add level</h3>
                        <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <div class='show-add'></div>
                        <label for="exampleInputEmail1">Name level</label>
                        <input name="name-level" type="text" class="form-control" placeholder="Enter Level">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary close-all" data-dismiss="modal">Close</button>
                      <button type="button" id="btn-add-level" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!-- /.box-header -->

          <div class="box-body">

            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th class="id">ID</th>
                <th class='name'>Name</th>
                <th class='date'>Date</th>
                <th class="delete">Delete</th>
                <th class="edit">Edit</th>
              </tr>
              </thead>
              <tbody>
              @if($data)
                @php $stt = 0@endphp
                @foreach($data as $item)
                  @php $stt++@endphp
                  <tr data-id='{{$item['id']}}'>
                    <td class="id">{{$stt}}</td>
                    <td class='name-level-db'>{{$item['name']}}</td>
                    <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($item['created_at']))->diffForHumans() !!}</td>
                    <td class="delete">
                      <form action="" method="POST">
                       {!! method_field('delete') !!}
                          {!! csrf_field() !!}
                        <a href="javascipt:void(0)"><i data-id='{{$item['id']}}'class="fa fa-trash delete-level" title="Delete"></i></a>
                      </form>
                    </td>
                    <td class="edit">
                      <a href="javascript:void(0)"><i type="button" class="fa fa-pencil btn-edit" data-toggle="modal" data-target="#{{$item['id']}}"  title="Edit"></i>
                      </a>
                     </td>
                      <!------------Edit level------------- -->
                      <div class="modal fade" id="{{$item['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title edit-title" id="exampleModalCenterTitle">Edit level</h3>
                                <span type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                            </div>
                            <div class="modal-body">
                              <div class="show-edit"></div>
                              <div class="form-group">
                                <label class="edit-title">Name level</label>
                                <input type="text" name='edit-level' class="form-control" placeholder="Enter Level" value='{{$item['name']}}'>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary close-all" data-dismiss="modal">Close</button>
                              <button type="button" data-id='{{$item['id']}}' class=" edit-level btn btn-primary">Edit</button>
                            </div>
                          </div>
                        </div>
                      </div>  
                    </td>
                  </tr>
                @endforeach
              @endif 
            </table>
          <!------------Phan trang------------- -->
            {{ $data->links() }}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
      </div>
    </div>
  </section>
@endsection()