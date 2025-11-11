<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email</title>
</head>
<body> 
    <div>   
        <div>
            {!! $templateContent !!}
        </div>
        <div style="text-align: center;  margin-right: 300px;">
            <h4> Please Approve And Reject: </h4>
            <a href="{{ route('frontend.index', ['approval_status' => 1, 'template_id' => $template_id,'approver_id' => $approver_id]) }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="display:inline-block; padding:10px 20px; margin:15px 0; font-size:16px; font-weight:bold; text-align:center; text-decoration:none; color:#ffffff; background-color:#337fd1; border-radius:6px" data-linkindex="0">Approve</a>
            <a href="{{ route('frontend.index', ['approval_status' => 0, 'template_id' => $template_id , 'rejecter_id' => $rejecter_id ]) }}" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="display:inline-block; padding:10px 20px; margin:15px 0; font-size:16px; font-weight:bold; text-align:center; text-decoration:none; color:#ffffff; background-color:#f52b2b; border-radius:6px" data-linkindex="0">Reject</a>
        </div>
    </div>
    
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


</body>
</html>

