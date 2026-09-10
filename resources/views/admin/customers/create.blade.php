@extends('admin.layouts.app')

@section('title', 'Add New Customer')
@section('content')
    <div style="max-width: 780px; margin: 0 auto;">
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <a href="{{ route('admin.customers.index') }}" style="color: #c58b2b; text-decoration: none; font-size: 13.5px; font-weight: 700;">← Back to Customer Directory</a>
                <div style="display: flex; align-items: center; gap: 12px; margin-top: 6px;">
                    <div style="background: #ffffff; padding: 4px 10px; border-radius: 8px; border: 1.5px solid rgba(197, 139, 43, 0.4); display: inline-flex; align-items: center;">
                        <img src="{{ asset('images/curves-logo.png') }}" alt="Curves & Tees" style="height: 24px; object-fit: contain;">
                    </div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #181513; margin: 0;">Register Customer Directly</h2>
                </div>
                <p class="muted" style="margin-top: 4px;">Save in-store boutique walk-ins, phone buyers, Instagram inquiries, or custom fittings into the database.</p>
            </div>
        </div>

        <div class="card" style="padding: 28px;">
            <form method="POST" action="{{ route('admin.customers.store') }}">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Customer Full Name <span style="color: #b91c1c;">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Ama Osei-Bonsu" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                        @error('name')<div style="color: #b91c1c; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">WhatsApp / Phone Number <span style="color: #b91c1c;">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="e.g. 054 123 4567" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                        @error('phone')<div style="color: #b91c1c; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Email Address (Optional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. customer@example.com" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                        <div style="font-size: 11.5px; color: #9ca3af; margin-top: 4px;">Leave blank to auto-generate a secure account handle</div>
                        @error('email')<div style="color: #b91c1c; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Preferred Curvy Size</label>
                        <select name="preferred_size" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px; background: #fff;">
                            <option value="">Select Curvy Size</option>
                            @foreach(['UK 10' => 'UK 10 (US 6 / S-M)', 'UK 12' => 'UK 12 (US 8 / Medium)', 'UK 14' => 'UK 14 (US 10 / Large)', 'UK 16' => 'UK 16 (US 12 / XL)', 'UK 18' => 'UK 18 (US 14 / 1X)', 'UK 20' => 'UK 20 (US 16 / 2X)', 'UK 22' => 'UK 22 (US 18 / 3X)'] as $val => $label)
                                <option value="{{ $val }}" {{ old('preferred_size') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Acquisition Channel / Source</label>
                        <select name="source" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px; background: #fff;">
                            <option value="In-Store Walk-in / Showroom">In-Store Walk-in / Showroom (Madina Estate)</option>
                            <option value="Phone Call / Direct Inquiry">Phone Call / Direct Inquiry</option>
                            <option value="Instagram DM (@curves_and_tees)">Instagram DM (@curves_and_tees)</option>
                            <option value="WhatsApp Direct Chat">WhatsApp Direct Chat</option>
                            <option value="VIP Referral">VIP Client Referral</option>
                            <option value="Pop-up / Fashion Event">Pop-up / Fashion Event</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">City / Town</label>
                        <input type="text" name="city" value="{{ old('city', 'Madina / Accra') }}" placeholder="e.g. East Legon, Accra" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Delivery Address / Residential Location</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="e.g. Madina Estate, near Rawlings Circle, House 12" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Outfit Interest / Current Request (Optional)</label>
                    <input type="text" name="outfit_interest" value="{{ old('outfit_interest') }}" placeholder="e.g. Ribbed Two-Piece Loungewear Set or Wide Leg Trousers" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">
                    <div style="font-size: 11.5px; color: #9ca3af; margin-top: 4px;">Automatically logs this in Leads & Campaigns for future broadcast follow-ups</div>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Stylist Notes & Fit Preferences</label>
                    <textarea name="notes" rows="3" placeholder="e.g. Prefers stretchy waistbands, likes olive and wine colors, frequently attends church/events" style="width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 9px; font-size: 14px;">{{ old('notes') }}</textarea>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 20px;">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="background: #181513; color: #f5d496; border: 1px solid #c58b2b; padding: 11px 24px; font-weight: 700;">
                        Save Customer & Log Activity
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
