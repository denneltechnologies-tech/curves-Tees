@extends('admin.layouts.app')

@section('title', 'Add Collection')
@section('content')
    <div class="card" style="max-width:600px;">
        <div class="page-head">
            <h3 class="page-title">Add Collection</h3>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">Back to Collections</a>
        </div>
        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:16px;">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group"><label>Collection Name *</label><input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Dresses & Jumpsuits" required></div>
            <div class="form-group"><label>Description</label><textarea name="description" rows="3" placeholder="Collection highlights">{{ old('description') }}</textarea></div>
            <div class="form-group"><label>Status</label>
                <select name="status"><option value="active" @if(old('status','active')==='active')selected @endif>Active (Visible)</option><option value="inactive" @if(old('status')==='inactive')selected @endif>Inactive</option></select>
            </div>
            <div class="form-group"><label>Collection Banner Image</label><input type="file" name="image" accept="image/*"></div>
            <button type="submit" class="btn btn-primary">Save Collection</button>
        </form>
    </div>
@endsection
