<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asset Track | {{ $title }}</title>
</head>

<body>
    <h2 style="text-align:center;">{{ $title }}</h2>
    <center><img src="https://api.qrserver.com/v1/create-qr-code/?data={{ route('asset-info-index', $id) }}&amp;size=500x500"
        alt="item-qr-code" title="{{ $ass->asset_code }}" style="text-align:center;"></center>
</body>

</html>
