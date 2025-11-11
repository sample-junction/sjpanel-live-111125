<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="margin: 0px;padding: 0px;background-color:white;font-family: 'Roboto', sans-serif;">
    <div style="margin: 20px auto;width: 600px;">
        <!-- <div style="width: 600px;border-radius: 10px;"> -->
        @php
            $unsubscribeUrl = Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' => $user->email]);

            // Replace any unsubscribe href (any domain)
            $updatedEmailContent = preg_replace(
                '/<a\s+[^>]*href="[^"]*\/user\/unsubscribe[^"]*"([^>]*)>/i',
                '<a href="' . $unsubscribeUrl . '"$1>',
                $emailContent
            );
        @endphp

        {!! $updatedEmailContent !!}
    </div>
</body>

</html>
