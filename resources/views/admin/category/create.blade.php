@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        @include('admin.message')
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{ isset($category) ? 'Update Category' : 'Create Category' }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.categories') }}" class="btn btn-primary">Back</a>
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
                action="{{ isset($category) ? route('admin.categories.update', [$category->id]) : route('admin.categories.store') }}"
                method="post" id="catehoryForm" name="categoryForm">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="category_id" id="category_id"
                                value="{{ @old('category_id', $category->id ?? '') }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ @old('name', $category->name ?? '') }}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                                </div>
                                @error('name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" readonly
                                        value="{{ @old('slug', $category->slug ?? '') }}"
                                        class="form-control @error('slug') is-invalid @enderror" placeholder="Slug">
                                </div>
                                @error('slug')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" id="image_id" name="image_id" value="">
                                    <label for="image">Image</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                    @if (!empty($category->image))
                                        <div>
                                            <img width="200" src="{{ asset('uploads/category/' . $category->image) }}">
                                        </div>
                                    @endif
                                    @error('image')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label><br>
                                    <select name="status" id="status" class="form-controll">
                                        @php $categories = ['Active' => 1,'Block' => 0]; @endphp
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $value }}"
                                                @if (@old('status', $category['status'] == $value)) selected @endif>
                                                {{ $key }}
                                            </option>
                                        @endforeach
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
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            const dropzone = $("#image").dropzone({
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });
                },
                url: "{{ route('temp-images.create') }}",
                maxFiles: 1,
                paramName: 'image',
                addRemoveLinks: true,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    $("#image_id").val(response.image_id);
                    //console.log(response)
                }
            });
        });
    </script>
@endsection
