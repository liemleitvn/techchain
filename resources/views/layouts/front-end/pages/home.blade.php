@extends('layouts.front-end.master')
@section('content')
    <div class="section">
        @php 
            $url = json_decode($data['questions_result']->toJson()) ;
            $next_page = $url->current_page +1;
            $prev_page = $url->current_page -1;
            $paginator = $data['questions_result'];
        @endphp
        <div class="error col-md-4"></div>
        <div class="finish-test">
            <button data-user-id="{{Auth::user()->id}}" class="finish btn btn-primary" id='finish' data-toggle="modal" data-target="#finish-exam">Finish</button>
            <!--Modal confirm-->
            <div class="modal fade" id="finish-exam" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{Lang::get('messages.confirm')}}</h5>
                      <span class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</span>
                    </div>
                  
                    <div class="modal-footer">
                    <button type="button" class="false btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="true btn btn-primary" data-dismiss="modal">Yes</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        
        <div class="content-question">
            @include('layouts.front-end.layouts.content-question')
        </div>
        <div class="paginate-left">
            @if ($paginator->lastPage() > 1)
               @foreach ($data_results as $key=>$data)
                    <div class=" paginate-item border">
                        <a class="paginate-link hover link {{($url->current_page == $key+1) ? 'is_active': ''}}"  href="javascript:void(0)" page='{{$key+1}}' data-id ="{{$data->question_id}}">
                            {{$key+1}}
                            <span class="is_answered" data-id ="{{$data->question_id}}" ></span>
                        </a>
                    </div>
               @endforeach
            @endif    
        </div>
        <div class="next-question">
            <div class="next {{($next_page > $url->last_page )? 'disablebtn':'' }}">
                <a class="link" href='javascript:void(0)' page="{{$next_page}}">
                    <img src="{{asset('images/next_1.png')}}" alt="">
                </a>
            </div>
            <div class="prev {{($prev_page == 0)? 'disablebtn':'' }}">
                <a class="link" href='javascript:void(0)' page="{{$prev_page}}">
                    <img src="{{asset('images/prev_1.png')}}" alt="">
                </a>
            </div>
        </div>
    </div>
    <script>
        var last_page = {{$url->last_page}};
    </script>
@endsection