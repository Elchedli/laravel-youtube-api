<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>welcome to users page</h1>
    {{-- <h1>{{ $name }}</h1> --}}
    {{-- <h1>{{ $age }}</h1> --}}
    @foreach ($users as $user)
        <h1>{{ $user }}</h1>
    @endforeach
</body>
</html>