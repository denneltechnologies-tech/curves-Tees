@extends('admin.layouts.app')

@section('title', 'Add Clothing Item')
@section('content')
    <div class="card" style="max-width:680px;">
        <div class="page-head">
            <h3 class="page-title">Add Clothing Item</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Back to Items</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:16px;">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Outfit Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Sunkissed Ribbed Bodycon Midi Dress" required>
            </div>

            <div class="form-group">
                <label>Collection / Category</label>
                <select name="category_id">
                    <option value="">Select Collection</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if(old('category_id')==$c->id)selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Description & Sizing Fit Notes</label>
                <textarea name="description" rows="3" placeholder="Describe the fabric, stretch, silhouette, and curve-flattering details">{{ old('description') }}</textarea>
            </div>

            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Price (GH₵) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="e.g. 240.00" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active" @if(old('status','active')==='active')selected @endif>Active (Visible in Store)</option>
                        <option value="inactive" @if(old('status')==='inactive')selected @endif>Inactive (Hidden)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Available Sizes (Comma-separated)</label>
                <input type="text" name="sizes" value="{{ old('sizes', 'UK 10, UK 12, UK 14, UK 16, UK 18, UK 20, UK 22') }}" placeholder="e.g. UK 10, UK 12, UK 14, UK 16">
                <div class="hint">Customers will choose from these sizes on the storefront product page.</div>
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" @if(old('is_featured'))checked @endif style="width:auto;">
                    <span>Feature this item on homepage hero showcase</span>
                </label>
            </div>

            <div class="form-group">
                <label>Product Photo</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Save Clothing Item</button>
            </div>
        </form>
    </div>
@endsection
