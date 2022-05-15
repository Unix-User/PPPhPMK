<!DOCTYPE html>
<html>

<head>
    <title><a href="https://unixlocal.ml">Unix.Local</a></title>
</head>

<body>
    <h1>{{ $data['category'] }}</h1>
    <p>{{ __('Essa mensagem foi enviada por:') }} {{ $data['name'] }}</p>

    <p>{{ $data['message'] }}</p>
    <p>{{ __('Favor responder para:') }} {{ $data['email'] }}</p>
    
</body>

</html>