@extends('admin.layouts.app')

@section('title', 'Clothing Items')
@section('content')
    <div class="card">
        <div class="page-head">
            <h3 class="page-title">Boutique Clothing Catalog ({{ $products->total() }})</h3>
            <div class="toolbar">
                <form method="GET" class="toolbar">
                    <input type="text" class="search-input" name="q" value="{{ request('q') }}" placeholder="Search dresses, tees, sets...">
                    <button class="btn btn-secondary">Search</button>
                </form>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Clothing Item</a>
            </div>
        </div>

        @if($products->isEmpty())
            <p class="muted">No clothing items found.</p>
        @else
        <div class="table-wrap">
        <table>
            <thead><tr><th>Photo</th><th>Outfit Name</th><th>Collection</th><th>Sizes</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->image_url)
                            <img class="img-thumb" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <span class="muted" style="font-size:20px;">👗</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if($product->is_featured)
                            <span class="badge badge-warning" style="margin-left:6px; font-size:10px;">Featured</span>
                        @endif
                    </td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td><span class="muted" style="font-size:12px;">{{ $product->sizes ?: 'UK 10 - 22' }}</span></td>
                    <td><strong>GH₵ {{ number_format($product->price, 2) }}</strong></td>
                    <td>@if($product->status === 'active')<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span>@endif</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('store.product', $product) }}" target="_blank" class="btn btn-secondary btn-sm" title="View on store">Live ↗</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this clothing item?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="pagination">{{ $products->links() }}</div>
        @endif
    </div>
@endsection
