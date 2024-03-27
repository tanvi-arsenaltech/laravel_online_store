@extends('admin.layout.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> {{ isset($category) ? 'Update Category' : 'Create Category' }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="categories.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{isset($category) ? route('admin.categories.update',[$category->id]) : route('admin.categories.store') }}" method="post" id="catehoryForm" name="categoryForm">
        @csrf
        @if(isset($category))
        @method('PUT')
        @endif
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ @old('name',$category->name ?? '')}}" class="form-control" placeholder="Name">	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ @old('slug',$category->slug ?? '')}}" class="form-control" placeholder="Slug">	
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-controll">
                                @php $categories = ['Active' => 1,'Block' => 0]; @endphp
                                @foreach ($categories as $key => $value)
                                <option  value="{{ $value }}" @if(@old('status',$category['status'] == $value)) selected @endif>
                                    {{ $key}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>									
                </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($category) ? 'Update' : 'Create' }}
            </button>
            <a href="#" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
        </form>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('js')
@endsection