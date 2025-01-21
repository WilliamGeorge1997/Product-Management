@extends('common::layouts.master')
@section('title','Edit ' . $product->name)

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@include('common::includes.navbar')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Edit Product</h2>
            </div>
            <div class="card-body">
                <form id="edit-product-form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}">
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                    </div>

                    <div id="error-messages" class="alert alert-danger d-none"></div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="submit" class="btn btn-primary" id="submit-btn">Update Product</button>
                            <div id="loading-spinner" class="d-none spinner-border spinner-border-sm text-primary ms-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('edit-product-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = document.getElementById('submit-btn');
                const loadingSpinner = document.getElementById('loading-spinner');
                const errorDiv = document.getElementById('error-messages');

                // Disable submit button and show spinner
                submitBtn.disabled = true;
                loadingSpinner.classList.remove('d-none');
                errorDiv.classList.add('d-none');

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const formData = {
                    name: document.getElementById('name').value,
                    price: document.getElementById('price').value,
                    quantity: document.getElementById('quantity').value,
                    description: document.getElementById('description').value,
                    _token: csrfToken
                };

                fetch(`/api/products/{{ $product->id }}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        errorDiv.innerHTML = data.errors.join('<br>');
                        errorDiv.classList.remove('d-none');
                        submitBtn.disabled = false;
                        loadingSpinner.classList.add('d-none');
                    } else {
                        window.location.href = '/products';
                        localStorage.setItem('success', 'Product updated successfully');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    loadingSpinner.classList.add('d-none');
                    errorDiv.innerHTML = 'An unexpected error occurred. Please try again.';
                    errorDiv.classList.remove('d-none');
                });
            });
        </script>
</div>
@endsection

@section('js')
@endsection
