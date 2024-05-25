<h1>
    Product: 
</h1>
<h3>
    {{ $product->name }} | {{ $product->id }}
</h3>

<form action="/products/update/{{$product->id}}" method="POST" enctype="multipart/form-data">
    <div class="px-2 mt-4">
        <label for="image">Profile picture</label>
        <input name="image" class="form-control" type="file">
    </div>
    <div>
        <button type="submit" class="btn btn-dark mb-2 btn-sm"> Update</button>
    </div>
</form>