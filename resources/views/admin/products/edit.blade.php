@extends('admin.layouts.app')

@section('title', 'Edit Clothing Item')
@section('content')
    <div class="card" style="max-width:680px;">
        <div class="page-head">
            <h3 class="page-title">Edit Outfit: {{ $product->name }}</h3>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('store.product', $product) }}" target="_blank" class="btn btn-secondary btn-sm">View in Store ↗</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Back to Items</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:16px;">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PATCH')

            <div class="form-group">
                <label>Outfit Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label>Collection / Category</label>
                <select name="category_id">
                    <option value="">No category</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if(old('category_id', $product->category_id) == $c->id)selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Description & Sizing Fit Notes</label>
                <textarea name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Price (GH₵) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active" @if($product->status==='active')selected @endif>Active (Visible in Store)</option>
                        <option value="inactive" @if($product->status==='inactive')selected @endif>Inactive (Hidden)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Available Sizes (Comma-separated)</label>
                <input type="text" name="sizes" value="{{ old('sizes', $product->sizes) }}" placeholder="e.g. UK 10, UK 12, UK 14, UK 16, UK 18">
                <div class="hint">Customers will choose from these sizes on the storefront product page.</div>
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" @if(old('is_featured', $product->is_featured))checked @endif style="width:auto;">
                    <span>Feature this item on homepage hero showcase</span>
                </label>
            </div>

            <div class="form-group">
                <label>Current Photo</label>
                @if($product->image_url)
                    <div style="margin-bottom:8px;">
                        <img class="img-thumb" style="width:100px; height:120px; border-radius:8px;" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*">
                <div class="hint">Leave blank to keep the current photo.</div>
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Update Clothing Item</button>
            </div>
        </form>
    </div>
@endsection
