<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>@lang('labels.backend.access.questions_answers.tabs.content.overview.question')</th>
                <td>{{ $question->question }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.questions_answers.tabs.content.overview.answer')</th>
                <td>{!! $question->answers[0]->answer !!}</td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>@if(!is_null($question->created_at)){{ \Carbon\Carbon::parse($question->created_at)->format('d-m-Y h:i:s') }}@endif</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>@if(!is_null($question->updated_at)){{ \Carbon\Carbon::parse($question->updated_at)->format('d-m-Y h:i:s') }}@endif</td>
            </tr>
            <!--<tr>
                <th>Created By</th>
                <td>{{ $question->created_by }}</td>
            </tr>-->
        </table>
    </div>
</div><!--table-responsive-->
