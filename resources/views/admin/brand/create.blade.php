@extends('admin.layout.app')
@section('content')
<section class="content-header">		
    @include('admin.message')			
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($brands) ? 'Edit Brand' : 'Create Brand' }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.brand')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form
        action="{{ isset($brand) ? route('admin.brand.update', [$brand->id]) : route('admin.brand.store') }}"
        method="post">
        @csrf
        @if (isset($category))
            @method('PUT')
        @endif
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <input type="hidden" id="brand_id" name="brand_id" value="{{ @old('brand_id', $brands->id ?? '') }}">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{@old('name',$brands->name ?? '')}}" placeholder="Name">	
                            </div>
                            @error('name')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{ @old('slug',$brands->slug ?? '')}}" class="form-control" placeholder="Slug">	
                            </div>
                            @error('slug')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>	
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Status</label><br>
                                <select name="status" id="status" class="form-controll col-md-6">
                                    <option value="1"
                                        {{ ($brands->status ?? old('status')) == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0"
                                        {{ ($brands->status ?? old('status')) == 0 ? 'selected' : '' }}>Block
                                    </option>
                                </select>
                            </div>
                            @error('status')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">{{ isset($brands) ? 'Update' : 'Create' }}</button>
                <a href="{{route('admin.brand.create')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('js')
@include('admin.layout.slug')
@endsection
