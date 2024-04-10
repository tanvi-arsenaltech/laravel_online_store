@extends('admin.layout.app')
@section('content')
<section class="content-header">	
    @include('admin.message')							
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($products) ? 'Edit Product' : 'Create Product' }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.product')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form method="post" action="{{route('admin.product.store')}}">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                            <input type="hidden" name="product_id" id="product_id">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" value="{{old('title',$products->title ?? '')}}" class="form-control" placeholder="Title">	
                                    </div>
                                    @error('title')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" value="{{old('title',$products->slug ?? '')}}" class="form-control" placeholder="Slug">	
                                    </div>
                                    @error('slug')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" value="{{old('title',$products->description ?? '')}}" class="summernote" placeholder="Description"></textarea>
                                    </div>
                                    @error('description')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>								
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">    
                                    <br>Drop files here or click to upload.<br><br>                                            
                                </div>
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="row" id="product-gallery">

                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" value="{{old('title',$products->price ?? '')}}" class="form-control" placeholder="Price">	
                                    </div>
                                    @error('price')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" value="{{old('title',$products->compare_price ?? '')}}" id="compare_price" class="form-control" placeholder="Compare Price">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" value="{{old('title',$products->sku ?? '')}}" class="form-control" placeholder="sku">	
                                    </div>
                                    @error('sku')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" value="{{old('title',$products->barcode ?? '')}}" class="form-control" placeholder="Barcode">	
                                    </div>
                                    @error('barcode')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>   
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                        </div>
                                        @error('track_qty')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" value="{{old('title',$products->qty ?? '')}}" class="form-control" placeholder="Qty">	
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1"
                                        {{ ($products->status ?? old('status')) == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0"
                                        {{ ($products->status ?? old('status')) == 0 ? 'selected' : '' }}>Block
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select category</option>
                                    @foreach ($data['categories'] as $category)
                                        <option value="{{ $category->id }}" {{ ($products->category_id ?? old('category_id')) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="subcategory" id="subcategory" class="form-control">
                                    <option value="">Select Subcategory</option>
                                </select>
                                @error('subcategory')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    @foreach ($data['brands'] as $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>                                                
                                </select>
                            </div>
                        </div>
                    </div>                                 
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{route('admin.product.create')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
    <!-- /.card -->
</section>
@endsection

@section('js')

    <script type="text/javascript">
   Dropzone.autoDiscover = false;
        $(document).ready(function() {
            const dropzone = $("#image").dropzone({
                // init: function() {
                //     this.on('addedfile', function(file) {
                //         if (this.files.length > 1) {
                //             this.removeFile(this.files[0]);
                //         }
                //     });
                // },
                url: "{{ route('temp-images.create') }}",
                maxFiles: 10,
                paramName: 'image',
                addRemoveLinks: true,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    // $("#image_id").val(response.image_id);
                    //console.log(response)
                    var html = `<div class="col-md-3" id="image-row-${response.image_id}"><div class="card">
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                    <img src="${response.ImagePath}" class="card-img-top" alt="">
                    <div class="card-body">
                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                    </div>
                    </div></div>`
                    $('#product-gallery').append(html);
                }
            });
        });
        function deleteImage(id)
        {
            $('#image-row-'+id).remove();
        }
        $('#category').change(function() {
            var categoryId = $(this).val();
            $.ajax({
                url: "{{ route('subcategories.get', ':category_id') }}".replace(':category_id', categoryId),
                method: 'GET',
                success: function(response) {
                    $('#subcategory').empty();
                    $.each(response, function(key, value) {
                        $('#subcategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                complete: function (file) {
                    this.removeFile(file);
                }
            });
        });
        $('#title').on('change keyup', function() {
        element = $(this);
        var title = element.val();
        console.log(element.val());
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route('getSlug') }}',
            type: 'get',
            data: {
                title
            },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true) {
                    $('#slug').val(response['slug']);
                }
            }
        });
    });
    </script>
@endsection
