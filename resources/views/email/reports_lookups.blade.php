<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Zip lookup activity report</h1>
    @foreach ($data as $user)
        @if($user->has('lookups'))
            <b>Zip lookups done by <i>{{ $user->email}}.</i></b><br/>
        @endif
        @foreach ($user->lookups as $lookup)
        Zip code lookup: <i>{{ $lookup->zip }}</i> | valid response: <i>{!! $lookup->valid_response ? "Yes":"No" !!}</i>, 
        <br/>
        @endforeach
    <br/>
    <br/>
    @endforeach
</body>
</html>