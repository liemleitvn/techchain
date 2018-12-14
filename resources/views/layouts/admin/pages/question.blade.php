@extends('layouts.admin.master',['title'=>'Question','name_content'=>'Question-'.$name.'-'.$category_name])
@section('script')
    <script src="{{url('admin/js/admin-question.js')}}"></script>
@stop
@section('content')
    <input name='skill_id' type="hidden" value="{{($skill_id->id)}}">
    <input name='name-question' type="hidden" value="{{$name}}">
    <input name='name-category' type="hidden" value="{{$category_name}}">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-xs-12 add">
                        {{--Button quick insert question--}}
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quick-insert-modal" id="quick-insert">
                            Quick Insert <span><i class="fa fa-plus-square"></i></span>
                        </button>
                        {{--end button quick insert question--}}

                        <!--Button add-->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="btn-category">
                            Add <span><i class="fa fa-plus-square"></i></span>
                        </button>
                        <!--Button import file-->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import" id="btn-import">
                            Import <span><i class="fa fa-plus-square"></i></span>
                        </button>
                        <!--Modal import file-->
                        <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="">Import file data</h3>
                                        <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                                    </div>

                                    <form action="{{route('questionImport')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <label for="">Choose file Excel or CSV: </label>
                                            <input type="file" name="file">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary import-file">
                                                Import
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--Modal add question-->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalCenterTitle">Add question-{{$name}}</h3>
                                        <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                                    </div>
                                    <div class="modal-body">
                                        <div class="question-notification"></div>
                                        @if($categories)
                                            @php $check_skill = DB::table('skills')->where('name',$name)->first()@endphp
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Choose Skill</label>
                                                <select class="form-control select select-skill">
                                                    <option value="0"> ----- Choose Skill ----- </option>
                                                    @if($check_skill->is_can_add_category ==1)
                                                        @foreach($skills as $skill)
                                                            @if($skill->is_can_add_category == 1)
                                                                <option @if($skill->name == $name){{'selected'}} @endif value="{{$skill->id}}">{{$skill->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($skills as $skill)
                                                            @if($skill->is_can_add_category == 0)
                                                                <option @if($skill->name == $name){{'selected'}} @endif value="{{$skill->id}}">{{$skill->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </select>

                                                <label for="exampleInputEmail1">Choose level</label>
                                                <select class="form-control select select-level">
                                                    <option value="0">------ Chose level ------</option>
                                                    @if($levels)
                                                        @foreach($levels as $level)
                                                            <option value="{{$level->id}}">{{$level->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                {{-- {{$check_skill->is_can_add_category}} --}}
                                                @if($check_skill->is_can_add_category ==1)
                                                    <label for="exampleInputEmail1">Choose category</label>
                                                    <select class="form-control select select-cate">
                                                        <option value="0"> ----- Choose category ----- </option>
                                                        @foreach($categories as $category)
                                                            <option @if($category_name == $category->name){{'selected'}} @endif value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                                <label for="exampleInputEmail1">Content question</label>
                                                <textarea name='content-question' class="form-control content-question" placeholder="Enter Question"></textarea>
                                            </div>
                                    </div>
                                    <div class=" modal-body add-answer" >
                                        <div style=" width: 100%; height: 50px">
                                            <button type="button" class="btn btn-primary btn-add-answer-add" id="btn-category">
                                                Add Answer<span><i class="fa fa-plus-square"></i></span>
                                            </button>
                                        </div>
                                        <!------List answer------>
                                        <div class="question-add">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn-add-question btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Quick insert modal --}}
                        <div class="modal fade" id="quick-insert-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalCenterTitle">Add question-{{$name}}</h3>
                                        <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                                    </div>
                                    <div class="modal-body">
                                        <div class="question-notification"></div>
                                        @if($categories)
                                            @php $check_skill = DB::table('skills')->where('name',$name)->first()@endphp
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Choose Skill</label>
                                                <select class="form-control select select-skill" id="select-skill">
                                                    @if($check_skill->is_can_add_category ==1)
                                                        @foreach($skills as $skill)
                                                            @if($skill->is_can_add_category == 1)
                                                                <option @if($skill->name == $name){{'selected'}} @endif value="{{$skill->id}}">{{$skill->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($skills as $skill)
                                                            @if($skill->is_can_add_category == 0)
                                                                <option @if($skill->name == $name){{'selected'}} @endif value="{{$skill->id}}">{{$skill->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </select>

                                                <label for="exampleInputEmail1">Choose level</label>
                                                <select class="form-control select select-level" id="select-level">
                                                    @if($levels)
                                                        @foreach($levels as $level)
                                                            <option value="{{$level->id}}">{{$level->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if($check_skill->is_can_add_category ==1)
                                                    <label for="exampleInputEmail1">Choose category</label>
                                                    <select class="form-control select select-cate" id="select-cate">
                                                        @foreach($categories as $category)
                                                            <option @if($category_name == $category->name){{'selected'}} @endif value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                                <div id="show-preview-question">

                                                </div>
                                                <label for="exampleInputEmail1">Content question and answers</label>
                                                <textarea
                                                        id="txt-content-question"
                                                        name='content-question'
                                                        class="form-control"
                                                        style="height: 100px"
                                                ></textarea>
                                            </div>
                                    </div>
                                    <div class=" modal-body add-answer" >
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn-add-quick-insert-question btn btn-primary">Add</button>
                                        <button id="btn-preview-question" type="button" class="btn btn-primary">Preview</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---Table list question-->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="question">Question</th>
                                <th >Answer</th>
                                <th class="is_correct">Is_corrected</th>
                                <th class="level">level</th>
                                <th class="date">Date</th>
                                <th class="delete">Delete</th>
                                <th class="edit">Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($questions)
                                @php $stt =0;@endphp
                                @foreach($questions as $question)
                                    @if(($question->skill_id == $skill_id->id && $question->category_id == NULL) ||
                                        ($question->skill_id == $skill_id->id ))
                                        @php $stt ++;@endphp
                                        <tr data-id='{{$question->id}}'>
                                            <td class="id">{{$stt}}</td>
                                            <td>{{$question->content}}</td>
                                            <td>
                                                <ul>
                                                    @foreach($answers as $answer)
                                                        @if($answer->question_id == $question->id)
                                                            <li value="{{$answer->id}}">{{$answer->content}}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach($answers as $answer)
                                                        @if($answer->question_id == $question->id)
                                                            <li>
                                                                @if($answer->is_corrected == 1){{'True'}}
                                                                @else {{'False'}} @endif
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                @php $level = DB::table('levels')->where('id',$question['level_id'])->first(); @endphp
                                                {{ $level->name }}
                                            </td>
                                            <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($question['created_at']))->diffForHumans() !!}</td>
                                            <td class="delete">
                                                <a href="javascript:void(0)">
                                                    <i class="delete-question fa fa-trash" data-id='{{$question->id}}' title="Delete"></i>
                                                </a>
                                            </td>
                                            <td class="edit">
                                                <a href="javascript:void(0)"><i type="button" class="fa fa-pencil btn-edit" data-toggle="modal" data-target="#{{$question->id}}" title="Edit"></i>
                                                </a>
                                                <!--Modal edit question-->
                                                <div class="modal fade" id="{{$question->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title edit-title" id="exampleModalCenterTitle">Edit question {{$name}}</h3>
                                                                <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class='show-question-edit'></div>
                                                                <div class="form-group">
                                                                    <!--------Choose skill-------->
                                                                    <label class='edit-title'>Choose Skill</label>
                                                                    <select class="form-control select select-skill-edit">
                                                                        <option value="0"> ----- Choose Skill ----- </option>
                                                                        @if($check_skill->is_can_add_category ==1)
                                                                            @foreach($skills as $skill)
                                                                                @if($skill->is_can_add_category == 1)
                                                                                    <option @if($skill->name == $name){{'selected'}} @endif value="{{$skill->id}}">{{$skill->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @foreach($skills as $skill)
                                                                                @if($skill->is_can_add_category == 0)
                                                                                    <option @if($skill->name == $name){{'selected'}} @endif value="{{$skill->id}}">{{$skill->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                    <!--Choose level-->
                                                                    <label class="edit-title" >Choose level</label>
                                                                    <select class="form-control select select-level-edit">
                                                                        <option value="0">------ Chose level ------</option>
                                                                        @if($levels)
                                                                            @foreach($levels as $level)
                                                                                <option @if($level->id == $question->level_id){{'selected'}} @endif value="{{$level->id}}">{{$level->name}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                    <!--Choose category-->
                                                                    @if($check_skill->is_can_add_category ==1)
                                                                        <label class='edit-title' >Choose category</label>
                                                                        <select class="form-control select select-cate-edit">
                                                                            <option value="0"> ----- Choose category ----- </option>
                                                                            @foreach($categories as $category)
                                                                                <option @if($category_name == $category->name){{'selected'}} @endif value="{{$category->id}}">{{$category->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif

                                                                    <label class="edit-title">Content question {{$name}}</label>
                                                                    <textarea name='content-question-edit' class="form-control content-question-edit" placeholder="Enter Question">{{$question->content}}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                            <div class=" modal-body add-answer" >
                                                                <div style=" width: 100%; height: 50px">
                                                                    <button type="button" class="btn btn-primary btn-add-answer-edit" id="btn-category">
                                                                        Add Answer<span><i class="fa fa-plus-square"></i></span>
                                                                    </button>
                                                                </div>
                                                                <!--DIV show answer current-->
                                                                <div class="question-edit">
                                                                    @foreach($answers as $answer)
                                                                        @if($answer->question_id == $question->id)
                                                                            <div class='answer-edit'>
                                                                                <input type='text' data-id-answer='{{$answer->id}}' name='content-answer-edit' class='form-control ip-answer' placeholder='Enter Answer' value="{{$answer->content}}"><i data-id-answer='{{$answer->id}}' class='fa fa-times correct-delete'></i>
                                                                                <input @if($answer->is_corrected == 1){{'checked'}} @endif class='correct-edit' type='checkbox'>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" data-id-question='{{$question->id}} ' class="btn btn-primary edit-question">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>
                        <!--Pagination-->
                        {{ $questions->links() }}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection()