@extends('common::layouts.master')

@section('title', 'Products')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @include('common::includes.navbar')
    <div class="container">
        @if (session('success'))
            <div id="success-message" class="mt-3 alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        <div id="success-alert" class="mt-3 alert alert-success text-center d-none"></div>
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mt-5">Products <small>(<span id="products-count"></span>)</small></h1>
            <a href="{{ route('products.create') }}" class="btn btn-success">Create Product</a>
        </div>
        <table id="products-list" class="mt-5 text-center table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="products-list-body">

            </tbody>

        </table>
        <div id="loading-spinner" class="d-none text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="mt-5" id="products-list-footer">

        </div>
    </div>
@endsection

@section('js')
    @include('common::includes.remove-msg-js')

    <script>
        const successMessage = localStorage.getItem('success');
        localStorage.removeItem('success');
        if (successMessage) {
            const successAlert = document.getElementById('success-alert');
            successAlert.textContent = successMessage;
            successAlert.classList.remove('d-none');
            setTimeout(() => {
                successAlert.classList.add('d-none');
            }, 3000);
        }

        const url = window.location.origin;
        const loadingSpinner = document.getElementById('loading-spinner');
        loadingSpinner.classList.remove('d-none');

        async function fetchProducts(page = 1) {
            document.getElementById('products-list-body').innerHTML = '';
            loadingSpinner.classList.remove('d-none');

            try {
                const response = await fetch(`/api/products?page=${page}`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = '/user/login';
                        return;
                    }
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                if (!data) return;
                document.getElementById('products-count').textContent = data.total;

                if (data.total === 0) {
                    document.getElementById('products-list-body').innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <h4 class="text-muted">No products available</h4>
                            </td>
                        </tr>`;
                    document.getElementById('products-list-footer').innerHTML = '';
                } else {
                    data.data.forEach((product, index) => {
                        const row = `<tr>
                            <td class="fw-bold">${(data.per_page * (data.current_page - 1)) + index + 1}</td>
                            <td>${product.name}</td>
                            <td>${product.price}$</td>
                            <td>${product.quantity} PC</td>
                            <td>
                                <a href="${url}/products/${product.id}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 576 512"><path fill="#0d6efd" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></a>
                                <a class="ms-3" href="${url}/products/${product.id}/edit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="#ffc107" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg></a>
                                <a class="ms-3" href="#" onclick="deleteProduct(${product.id}); return false;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 448 512"><path fill="#dc3545" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></a>
                            </td>
                        </tr>`;
                        document.getElementById('products-list-body').innerHTML += row;
                    });

                    // Generate pagination
                    const footer = document.getElementById('products-list-footer');
                    footer.innerHTML = `<nav aria-label="Products pagination">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item ${!data.prev_page_url ? 'disabled' : ''}">
                                <a class="page-link" href="#" onclick="fetchProducts(${data.current_page - 1}); return false;">Previous</a>
                            </li>
                            ${data.links.slice(1, -1).map(link => `
                                                                    <li class="page-item ${link.active ? 'active' : ''}">
                                                                        <a class="page-link" href="#" onclick="fetchProducts(${link.label}); return false;">${link.label}</a>
                                                                    </li>
                                                                `).join('')}
                            <li class="page-item ${!data.next_page_url ? 'disabled' : ''}">
                                <a class="page-link" href="#" onclick="fetchProducts(${data.current_page + 1}); return false;">Next</a>
                            </li>
                        </ul>
                    </nav>`;
                }

                loadingSpinner.classList.add('d-none');
            } catch (error) {
                loadingSpinner.classList.add('d-none');
            }
        }

        function deleteProduct(productId) {
            if (!confirm('Are you sure you want to delete this product?')) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/api/products/${productId}`, {
                    method: 'DELETE',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            window.location.href = '/user/login';
                            return;
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    fetchProducts();
                    alert('Product deleted successfully.');
                })
                .catch(error => {
                    alert('Error deleting product.');
                });
        }

        // Initial load
        fetchProducts();
    </script>
@endsection
