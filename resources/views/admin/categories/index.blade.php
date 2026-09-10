@extends('admin.layouts.app')

@section('title', 'Collections')
@section('content')
    <div class="card">
        <div class="page-head">
            <h3 class="page-title">Fashion Collections ({{ $categories->total() }})</h3>
            <div class="toolbar">
                <form method="GET" class="toolbar">
                    <input type="text" class="search-input" name="q" value="{{ request('q') }}" placeholder="Search collections...">
                    <button class="btn btn-secondary">Search</button>
                </form>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Collection</a>
            </div>
        </div>
        @if($categories->isEmpty())
            <p class="muted">No collections found.</p>
        @else
        <div class="table-wrap">
        <table>
            <thead><tr><th>Image</th><th>Collection Name</th><th>Outfits</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>@if($category->image)<img class="img-thumb" src="{{ asset('storage/'.$category->image) }}" alt="">@else<span class="muted">—</span>@endif</td>
                    <td><strong style="color: #181513;">{{ $category->name }}</strong></td>
                    <td><span class="badge badge-gold">{{ $category->products_count }} outfits</span></td>
                    <td>@if($category->status === 'active')<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span>@endif</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Delete this category?');">
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
        <div class="pagination">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
