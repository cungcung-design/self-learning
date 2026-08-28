@extends('layouts.admin')

@section('title', 'Add Featured Category | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="border-0 shadow-lg card">
                        <div class="text-white card-header bg-primary">
                            <h3 class="mb-0">
                                <i class="fa fa-tag"></i> Add Featured Category
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.featured_categories.store') }}" method="POST">
                                @csrf

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="name">Category Name</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Enter category name" required>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="slug">Slug</label>
                                    <input id="slug" type="text" name="slug" class="form-control"
                                        value="{{ old('slug') }}" placeholder="category-slug" required>
                                    <small class="text-muted">Used in URLs. Use lowercase letters, numbers, and hyphens only.</small>
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.featured_categories.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
