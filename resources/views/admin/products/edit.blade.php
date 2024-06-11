@component('admin.layouts.content', ['title' => 'Update Product'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin-panel/products">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update Product</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Product</h3>
                </div>
                <!-- /.card-header -->
                <form action="/admin-panel/products/update" method="POST"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group pb-3">
                            <label for="inputName" class="col-sm-2 control-label">Product Name</label>
                            <input type="text" name="name" class="form-control" id="inputName"
                                   placeholder="Enter product's name" autocomplete="name" value="{{ $product->name }}"
                                   required>
                            @if($errors->has('name'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                            <textarea name="description" class="form-control" id="inputDescription"
                                      placeholder="Enter product's description" autocomplete="description"
                                      required>{{ $product->description }}</textarea>
                            @if($errors->has('description'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="inputSpecification" class="col-sm-2 control-label">Specification</label>
                            <textarea name="specification" class="form-control" id="inputSpecification"
                                      placeholder="Enter product's specification" autocomplete="specification"
                                      required>{{ $product->specification }}</textarea>
                            @if($errors->has('specification'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('specification') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="inputImage" class="col-sm-2 control-label">Image</label>
                            <input type="file" name="image" class="form-control" id="inputImage"
                                   placeholder="Enter product's image"
                            @if($errors->has('image'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('image') }}</span>
                            @endif
                            <br>
                            <img src="/storage/app/product/{{ $product->image }}" alt="{{ $product->name }}"
                                 style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="form-group pb-3">
                            <label for="inputPrice" class="col-sm-2 control-label">Price</label>
                            <input type="number" name="price" class="form-control" id="inputPrice"
                                   placeholder="Enter product's price" autocomplete="price"
                                   value="{{ $product->price }}"
                                   required>
                            @if($errors->has('price'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex"
                         style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-info">Update Product</button>
                        <a href="/admin-panel/products" type="submit"
                           class="btn btn-default float-left">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
