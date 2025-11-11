<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="margin: 0px;padding: 0px;background-color:white;font-family: 'Roboto', sans-serif;">
    <div style="margin: 20px auto;width: 600px;">
        <!-- <div style="width: 600px;border-radius: 10px;"> -->
        <table style="width: 600px;border-collapse: collapse;margin: 0px;">
            <tbody>
               
                
                <tr>
                    <td style="text-align:center;width: 600px;">
                        <div style="margin: 20px auto;width:560px;background-color:white; border-radius:13px;padding:10px 10px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                            <h3>Survey Completed by Panelist:</h3>
                            <div style="text-align: left;margin-left: 150px;">
                                <p><strong>Name :</strong> {{$user_name}}</p>
                                <p><strong>Panelist ID :</strong> {{$panelist_id}}</p>
                                <p><strong>Survey Number:</strong> {{$survey_code}}</p>
                                <p><strong>Survey Point: </strong>{{$points}}</p>
                                <p><strong>Respondent ID: </strong>{{$respondentId}}</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>