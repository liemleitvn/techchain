@extends('layouts.admin.master',['title'=>'Category','name_content'=>'Category'])
@section('script')
    <script src="{{url('admin/js/admin-category.js')}}"></script>
@stop
@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="col-xs-12 add">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="btn-category">
              Add <span><i class="fa fa-plus-square"></i></span>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalCenterTitle">Add Category</h3>
                      <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                  </div>
                  <div class="modal-body">
                    <div class='show-add'></div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Choose skill</label>
                      <select class="form-control select">
                        <option value="0"> ----- Choose skill ----- </option>
                        @if($data_skill)
                          @foreach($data_skill as $item)
                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                          @endforeach
                        @endif
                      </select>
                      <label for="exampleInputEmail1">Name Category</label>
                      <input type="text" name='name-cate' class="form-control" placeholder="Enter Category">

                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-add" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-add-category btn btn-primary">Add</button>
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
                  <th>Name</th>
                  <th class="skill-category">Skill</th>
                  <th class="date">Date</th>
                  <th class="delete">Delete</th>
                  <th class="edit">Edit</th>
                </tr>
              </thead>
              <tbody>
                @if($data_cate)
                  @php $stt=0;@endphp
                  @foreach($data_cate as $itemcate)
                    @php $stt++;@endphp
                    <tr data-id ='{{$itemcate['id']}}'>
                      <td class="id">{{$stt}}</td>
                      <td>{{$itemcate['name']}}</td>
                      <td class="skill-category">
                        @php $skill = DB::table('skills')->where('id',$itemcate['skill_id'])->first(); @endphp
                        {{ $skill->name }}
                      </td>
                      <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($itemcate['created_at']))->diffForHumans() !!}</td>
                      <td class="delete">
                        <form action="" method="POST">
                          @method('delete')
                          @csrf
                          <a href="javascript:void(0)"><i class="delete-category fa fa-trash" title="Delete" data-id='{{$itemcate['id']}}'></i></a>
                        </form>
                      </td>
                      <td class="edit">
                        <a href="javascript:void(0)"><i type="button" class=" fa fa-pencil btn-edit" data-toggle="modal" data-target="#{{$itemcate['id']}}" title="Edit" ></i></a>
                        <div class="modal fade" id="{{$itemcate['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content">
                             <div class="modal-header">
                               <h3 class="modal-title edit-title" id="exampleModalCenterTitle">Edit category</h3>
                                 <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                             </div>
                             <div class="modal-body">
                              <div class="show-edit"></div>
                               <div class="form-group">
                                <label class="edit-title" >Choose level</label>
                                <select class="option-edit form-control select">
                                  <option value="0"> ----- Choose level ----- </option>
                                  @if($data_skill)
                                    @foreach($data_skill as $item)
                                      <option 
                                        @if($itemcate['skill_id'] == $item['id']) {{'selected'}}@endif 
                                        value="{{$item['id']}}">{{$item['name']}}
                                      </option>
                                    @endforeach
                                  @endif
                                </select>
                                <label class="edit-title">Name category</label>
                                <input type="text" name='name-category-edit' class="form-control" placeholder="Enter category" value="{{$itemcate['name']}}">
                              </div>
                            </div>
                            <div class="modal-footer">
                             <button type="button" class="btn btn-secondary close-all" data-dismiss="modal">Close</button>
                             <button type="button" data-id='{{$itemcate['id']}}' data-id-skill='{{$itemcate['skill_id']}}'class="edit-category btn btn-primary">Edit</button>
                            </div>
                            </div>
                          </div>
                        </div>    
                      </td>
                    </tr>
                  @endforeach
                @endif
              </table>
              {{ $data_cate->links()}}
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

<!-- /.content -->
</div>
@endsection()