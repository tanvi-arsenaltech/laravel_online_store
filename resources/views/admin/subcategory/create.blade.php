@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($subCategories) ? 'Update Sub Category' : 'Create Sub Category' }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.subcategories') }}" class="btn btn-primary">Back</a>
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
                action="{{ isset($subCategories) ? route('admin.subcategories.update', [$subCategories->id]) : route('admin.subcategories.store') }}"
                method="POST" name="subCategoryForm" id="subCategoryForm">
                @csrf
                @if (isset($subCategories))
                    @method('PUT')
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ ($subCategories->category_id ?? old('category_id')) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ @old('name', $subCategories->name ?? '') }}" class="form-control"
                                        placeholder="Name">
                                </div>
                                @error('name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" readonly
                                        value="{{ @old('name', $subCategories->slug ?? '') }}" class="form-control"
                                        placeholder="Slug">
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
                                            {{ ($subCategories->status ?? old('status')) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ ($subCategories->status ?? old('status')) == 0 ? 'selected' : '' }}>Block
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($subCategories) ? 'Update' : 'Create' }}</button>
                    <a href="{{ isset($subCategories) ? route('admin.subcategories.edit', [$subCategories->id]) : route('admin.subcategories.create') }}"
                        class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('js')
   @include('admin.layout.slug')
@endsection
