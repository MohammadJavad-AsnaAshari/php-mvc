<h2><?= $title ?></h2>
<form action="/article/create" method="POST">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required placeholder="Enter you title">

    <button type="submit">Create Article</button>
</form>