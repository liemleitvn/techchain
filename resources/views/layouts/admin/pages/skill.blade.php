@extends('layouts.admin.master',['title'=>'Skill','name_content'=>'Skill'])
@section('script')
    <script src="{{url('admin/js/admin-skill.js')}}"></script>
@stop
@section('content')
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
                    <h3 class="modal-title" id="exampleModalCenterTitle">Add skill</h3>
                      <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                  </div>
                  <div class="modal-body">
                    <div class="show-add"></div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name Skill:</label>
                      <input type="text" name='name-skill' class="form-control" placeholder="Enter Skill"></br>

                      <label for="exampleInputEmail1">Number question: </label></br>
                        <input type="number" name='number-of-question' class='number'></br></br>
                      <label for="exampleInputEmail1">Choose can add category: </label>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value='1' >
                          <label class="custom-control-label" for="customRadio1"> True</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value='0' checked>
                          <label class="custom-control-label" for="customRadio2" > False</label>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-all" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-add-skill btn btn-primary">Add</button>
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
                <th class='is_can_add_category'>Can add category</th>
                <th class='number-question'>Number of question</th>
                <th class='date'>Date</th>
                <th class="delete">Delete</th>
                <th class="edit">Edit</th>
              </tr>
              </thead>
              <tbody>
              @if($data)
              @php $stt=0;@endphp
                @foreach($data as $item)
                  @php $stt++;@endphp
                  <tr data-id='{{$item['id']}}'>
                    <td class="id">{{$stt}}</td>
                    <td>
                      <div style="position: relative">
                        <a
                            class="href-question "
                            @if($item['is_can_add_category'] == 0)
                            href="{{ route('questionIndex', ['nameSkill'=>$item['name'], 'nameCate'=>'']) }}"
                            @else 
                                class="dropdown-toggle"
                                data-toggle="dropdown"
                            @endif
                        >   
                            {{$item['name']}}
                            @if($item['is_can_add_category'] && count($categories) > 0)
                                <i class="caret"></i>
                            @endif
                        </a>
                        @if($item['is_can_add_category'])
                            <ul class="dropdown-menu list-skill" aria-labelledby="dropdownMenu1">
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('questionIndex', ['nameSkill'=>$item['name'], 'nameCate'=>$category['name']]) }}"
                                    >
                                        {{ $category['name'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                      </div>
                    </td>
                    <td>
                        {{($item['is_can_add_category'] == 1)? 'True': 'False'}}
                    </td>
                    <td>{{$item['number_of_questions']}}</td>
                    <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($item['created_at']))->diffForHumans() !!}</td>
                    <td class="delete">
                      <form action="" method="POST">
                        @method('delete')
                        @csrf
                        <a href="javascript:void(0)"><i class="delete-skill fa fa-trash" data-id='{{$item['id']}}' title="Delete"></i></a>
                      </form>
                    </td>
                    <td class="edit">
                      <a href="javascript:void(0)"><i type="button" class=" fa fa-pencil btn-edit" data-toggle="modal" data-target="#{{$item['id']}}" data-id='{{$item['id']}}' title="Edit"></i>
                      </a>
                      <div class="modal fade" id="{{$item['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered" role="document">
                         <div class="modal-content">
                           <div class="modal-header">
                             <h3 class="modal-title edit-title" id="exampleModalCenterTitle">Edit skill</h3>
                               <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                           </div>
                           <div class="modal-body">
                            <div class="show-edit"></div>
                             <div class="form-group">
                               <label class="edit-title">Name skill: </label>
                               <input type="text" name='name-skill-edit' class="form-control" placeholder="Enter skill" value='{{$item['name']}}'></br>
                               <label class='lb-skill' for="exampleInputEmail1">Number question: </label></br>
                                <input type="number" name='number-of-question' class='number ip-number-question' value='{{$item['number_of_questions']}}'></br>

                                <!---------Choose can add category------>
                                <label class='lb-rdio-edit' for="">Choose can add category: </label>
                                
                                <fieldset id="group2">
                                  <div class="custom-control custom-radio rdio-edit">
                                    <input @if($item['is_can_add_category']==1){{'checked'}}@endif type="radio" id='#{{$item['name']}}' class="custom-control-input rdio-edit true" value='1' name='{{$item['id']}}'/>
                                    <label class="custom-control-label" for="#{{$item['name']}}" > True</label>
                                  </div>
                          
                                  <div class="custom-control custom-radio rdio-edit">
                                    <input @if($item['is_can_add_category']==0){{'checked'}}@endif type="radio" id='#{{$item['id']}}' class="custom-control-input false" name='{{$item['id']}}' value='0'/>
                                    <label class="custom-control-label" for="#{{$item['id']}}" > False</label>
                                  </div>
                                </fieldset>
                                
                             </div>
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary close-all" data-dismiss="modal">Close</button>
                             <button type="button" data-id='{{$item['id']}}' class="edit-skill btn btn-primary">Edit</button>
                           </div>
                         </div>
                         </div>
                       </div>    
                    </td>
                  </tr>
                  @endforeach
              @endif
            </table>
            <!----------Pagination----------->
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