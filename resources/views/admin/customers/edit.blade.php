@extends('admin.layouts.app')

@section('title', 'Edit Customer: ' . $user->name)
@section('content')
    <div style="max-width: 780px; margin: 0 auto;">
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <a href="{{ route('admin.customers.show', $user) }}" style="color: #a86c3d; text-decoration: none; font-size: 13.5px; font-weight: 600;">← Back to Customer Profile</a>
                <h2 style="font-size: 22px; font-weight: 800; color: #191614; margin-top: 6px;">Edit Customer Profile</h2>
                <p class="muted" style="margin: 0;">Update contact information, preferred curvy sizing, address, and notes for {{ $user->name }}.</p>
            </div>
        </div>

        <div class="card" style="padding: 28px;">
            <form method="POST" action="{{ route('admin.customers.update', $user) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Full Name <span style="color: #b91c1c;">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                        @error('name')<div style="color: #b91c1c; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">WhatsApp / Phone Number <span style="color: #b91c1c;">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                        @error('phone')<div style="color: #b91c1c; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                        @error('email')<div style="color: #b91c1c; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Preferred Curvy Size</label>
                        <select name="preferred_size" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px; background: #fff;">
                            <option value="">Select Curvy Size</option>
                            @foreach(['UK 10' => 'UK 10 (US 6 / S-M)', 'UK 12' => 'UK 12 (US 8 / Medium)', 'UK 14' => 'UK 14 (US 10 / Large)', 'UK 16' => 'UK 16 (US 12 / XL)', 'UK 18' => 'UK 18 (US 14 / 1X)', 'UK 20' => 'UK 20 (US 16 / 2X)', 'UK 22' => 'UK 22 (US 18 / 3X)'] as $val => $label)
                                <option value="{{ $val }}" {{ old('preferred_size', $user->preferred_size) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">City / Town</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Madina / Accra" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Account Status</label>
                        <select name="status" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px; background: #fff;">
                            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Delivery Address / Residential Location</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="e.g. Madina Estate, near Rawlings Circle" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Stylist Notes & Fit Preferences</label>
                    <textarea name="notes" rows="4" placeholder="Fit notes, styling preferences, VIP details..." style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">{{ old('notes', $user->notes) }}</textarea>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 20px;">
                    <a href="{{ route('admin.customers.show', $user) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="background: #191614; color: #fff; padding: 11px 24px; font-weight: 700;">
                        Update Customer Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
