@extends('backend.layouts.app')

@section('title', __('labels.backend.access.setting.management') . ' | ' . __('labels.backend.access.setting.titles.point_system_title'))

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 pull-left">
                    <label>
                        <h4>
                            {{__('Survey Lucky Draw')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.setting.post.survey_lucky_draw'))->open()}}
        <div class="card-body">
			<table border="1">
				<tr>
					<th>PANELIST ID</th>
					<th>POINTS</th>
					<th>CHECK</th>
				</tr>
				<tr>
					<td>PANELIST 1</td>
					<td>50000</td>
					<td>
						<input type="checkbox" class="form-control" name="unique_ip_check" value="1">
					</td>
				</tr>
				<tr>
					<td>PANELIST 2</td>
					<td>20000</td>
					<td>
						<input type="checkbox" class="form-control" name="unique_ip_check" value="2">
					</td>
				</tr>
				<tr>
					<td>PANELIST 3</td>
					<td>10000</td>
					<td>
						<input type="checkbox" class="form-control" name="unique_ip_check" value="3">
					</td>
				</tr>
			</table>


        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="Update" name="submit">
            <p class="error-message" style="color: red;"></p>

        </div><!--card-footer-->
        {{html()->form()->close()}}
    </div><!--card-->
@endsection