<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Document</title> --}}
</head>

<body style="background-color:white; font-family: 'Roboto', sans-serif;">

	<div style="margin:auto;width:600px;height:auto; border-radius:10px; background-color:white; box-sizing: border-box; border: 1px solid rgba(233, 233, 233, 1);">

		<h3>Hi Amarjit !!</h3>
		
		<p>Panelist {{ $data['name'] }} has uploaded a file please check.</p>
		<p>Panelist Id : {{ $data['panelist_id'] }}</p>
		<p>Click <a href="{{ $data['pageLink']}}" target="_blank">here</a> to visit the page.</p>
	</div>
    
</body>
</html>
