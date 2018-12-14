
<section class="show-content-exam">
    @if(Session::has('error'))
        <div class='show-notification col-md-3 alert-danger'>{{Session('error')}}</div>
    @endif
    <div class="content container">
        <h4>Question: <span class="indexof-question">1</span></h4>
        <div class="content_question">
            <textarea  rows="2" cols="77%">{{$data['question']->content}}</textarea>
        </div>
        <table class='table'>
            <tbody>
                @foreach($data['answer'] as $answer)
                    <tr>
                      <td for="{{$answer->id}}" class="table-td">
                        <input id ='{{$answer->id}}' type="checkbox" data-id-answer='{{$answer->id}}' data-id-question='{{$data['question']->id}}'>
                        <label for="{{$answer->id}}" class='label-content'> &nbsp;&nbsp;{{$answer->content}}</label>
                      </td>
                    </tr>
                @endforeach
          </tbody>
        </table>
    </div>
    <style>
        .label-content { width: 97% ; margin: 0px !important; padding: 5px;}
        .table-td { padding: 10px !important;}
        ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 7px;
        }
        ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0,0,0,.5);
            box-shadow: 0 0 1px rgba(255,255,255,.5);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #484545; 
        }
    </style>
</section>


