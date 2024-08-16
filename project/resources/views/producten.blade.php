@extends('layouts.header')

@section('content')
<div class="container">
    <h1>Manage Products</h1>

    {{-- Add New Product Form --}}
    <div class="card mb-4">
        <div class="card-header">Add New Product</div>
        <div class="card-body">
            <form method="POST" action="{{ route('producten.store') }}">
                @csrf
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category_id" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-secondary mt-2" data-toggle="modal" data-target="#createCategoryModal">
                        Add New Category
                    </button>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>

    {{-- Product List Table --}}
    <div class="card">
        <div class="card-header">Product List</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($producten as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                        <td>
                            {{-- Edit Button --}}
                            <button type="button" class="btn btn-warning btn-sm edit-button"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->product_name }}"
                                data-quantity="{{ $product->quantity }}"
                                data-category="{{ $product->category->id ?? '' }}">
                                Edit
                            </button>

                            {{-- Delete Form --}}
                            <form method="POST" action="{{ route('producten.destroy', $product->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create Category Modal --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createCategoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_category_name">Category Name</label>
                        <input type="text" class="form-control" name="name" id="new_category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Product Modal --}}
<div id="edit-form-container" class="modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Product</h5>
                <button type="button" class="close" onclick="document.getElementById('edit-form-container').style.display='none'">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('producten.update', $product->id) }}" id="edit-product-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="product-id">

                <div class="form-group">
                    <label for="edit-product-name">Product Name</label>
                    <input type="text" class="form-control" id="edit-product-name" name="product_name" required>
                </div>

                <div class="form-group">
                    <label for="edit-quantity">Quantity</label>
                    <input type="number" class="form-control" id="edit-quantity" name="quantity" required>
                </div>

                <div class="form-group">
                    <label for="edit-category">Category</label>
                    <select class="form-control" id="edit-category" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
