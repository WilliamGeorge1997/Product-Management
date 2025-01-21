@extends('common::layouts.master')
@section('title', $product->name . ' Details')

@section('css')
@endsection

@section('content')
@include('common::includes.navbar')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Product Details</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="display-4 mb-4">{{ $product->name }}</h1>

                        <div class="mb-4">
                            <h4 class="text-muted">Description</h4>
                            <p class="lead">{{ $product->description }}</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Price</h5>
                                        <p class="card-text h3">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Quantity in Stock</h5>
                                        <p class="card-text h3">{{ $product->quantity }} PC</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-muted">
                            <p><strong>Created:</strong> {{ $product->created_at->format('F j, Y g:i A') }}</p>
                            <p><strong>Last Updated:</strong> {{ $product->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('products.index') }}" class="btn btn-danger">Back to Products</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
