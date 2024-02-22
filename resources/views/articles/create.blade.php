<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Article</title>
</head>
<body>
<h2>{{$title}}</h2>

<h5>
    @if($auth)
        <span>You're login!</span>
    @else
        <span>You're not login!</span>
    @endif
</h5>

<form action="/article/create" method="POST">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required placeholder="Enter you title">

    <button type="submit">Create Article</button>
</form>
</body>
</html>