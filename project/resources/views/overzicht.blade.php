@extends('layouts.header')

@section('content')

  {{-- Button to navigate to the Producten page --}}
    {{-- Button to navigate to the Producten page --}}
    <div class="mb-3">
      <a href="{{ route('producten.index') }}" class="btn btn-primary">Add / Edit Product</a>
      {{-- Button to export product info --}}
      <a href="{{ route('google.authenticate') }}" class="btn btn-success">Export Products</a>
    </div>

  {{-- Product List Table --}}
  <div class="card">
    <div class="card-header">Overview Product List</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($producten as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category->name ?? 'No Category' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>

@endsection
