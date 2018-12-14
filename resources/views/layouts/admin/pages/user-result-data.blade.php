
<h3><strong>Answer true: {{!empty($data_result['count_question_number_true'])? $data_result['count_question_number_true'] : 0}} / {{$question_number}}</strong></h3>
<hr>
@foreach($data as $key=>$item)
    @php 
        $answer = [];
        $tmp_result = $item['results'];
        $results = json_decode($tmp_result->answer_ids);
        $answer_ids =$tmp_result->answer_ids;
    @endphp
    <h4><strong>(*) {{$item['content']}}</strong> </h4>
    <ul>
        @foreach($item['answers'] as $key => $val)
            @if($val['is_corrected'] == 1)
                @php 
                    $answer[] = json_encode($val->id);
                    $answer_true = implode(',',$answer);
                @endphp
            @endif
            <li>
                <input type="checkbox" 
                    @if(!empty($results))
                        {{ (in_array($val->id, $results)) ? 'checked' : '' }} 
                    @endif
                />
                <i style="color: {{ ($val['is_corrected'] == 1) ? 'green' : 'red'}}; font-weight: bold; ">
                    {{ $val['content'] }}
                </i>
            </li>
        @endforeach
        {!! ($answer_ids == '['.$answer_true.']') ? 
            "<p style='color:red;'>
                ------------------------------------------- Answer True -------------------------------------------
            </p> ": '' 
        !!}
    </ul>
@endforeach
<style>
    hr{border-top: 1px solid red;width:30%;}
    h3{text-align: center}
    li{pointer-events:none}
</style>
