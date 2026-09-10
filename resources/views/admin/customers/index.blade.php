@extends('admin.layouts.app')

@section('title', 'Customer Directory')
@section('content')
    <!-- Quick Metric Cards Dashboard -->
    <div class="grid grid-4" style="margin-bottom: 24px;">
        <div class="stat-card" style="border-top: 3px solid #191614;">
            <div class="stat-header">
                <div class="stat-label">Total Registered Customers</div>
                <div class="stat-icon" style="background: #f1f5f9; color: #1e293b;">👥</div>
            </div>
            <div class="stat-value">{{ number_format($metrics['total']) }}</div>
            <div class="stat-meta" style="color: #059669; font-weight: 600;">
                <span>✓</span> From walk-ins, online & WhatsApp
            </div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #059669;">
            <div class="stat-header">
                <div class="stat-label">Active Customers</div>
                <div class="stat-icon" style="background: #ecfdf5; color: #059669;">✨</div>
            </div>
            <div class="stat-value" style="color: #059669;">{{ number_format($metrics['active']) }}</div>
            <div class="stat-meta" style="color: #64748b;">
                In good standing with Curves & Tees
            </div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #b91c1c;">
            <div class="stat-header">
                <div class="stat-label">Customers with Orders</div>
                <div class="stat-icon" style="background: #fef2f2; color: #b91c1c;">🛍️</div>
            </div>
            <div class="stat-value" style="color: #b91c1c;">{{ number_format($metrics['with_orders']) }}</div>
            <div class="stat-meta" style="color: #64748b;">
                Placed orders in catalog / boutique
            </div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #c98a58;">
            <div class="stat-header">
                <div class="stat-label">Leads & Inquiries Logged</div>
                <div class="stat-icon" style="background: #fdf8f4; color: #c98a58;">💬</div>
            </div>
            <div class="stat-value" style="color: #a86c3d;">{{ number_format($metrics['leads_count']) }}</div>
            <div class="stat-meta">
                <a href="{{ route('admin.leads.index') }}" style="color: #a86c3d; font-weight: 600; text-decoration: underline;">Open marketing broadcasts →</a>
            </div>
        </div>
    </div>

    <!-- Main Customer Table Card -->
    <div class="card">
        <div class="page-head" style="flex-wrap:wrap; gap:12px;">
            <div>
                <h3 class="page-title" style="margin-bottom:4px;">All Customers ({{ $customers->total() }})</h3>
                <p class="muted" style="margin:0;">Manage customers saved from in-store walk-ins, phone calls, web catalog orders, and WhatsApp chats.</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <button type="button" class="btn btn-primary" onclick="openAddCustomerModal()" style="display:inline-flex; align-items:center; gap:6px;">
                    <span style="font-size:16px; font-weight:bold;">+</span> Add New Customer
                </button>
                <a href="{{ route('admin.customers.create') }}" class="btn btn-secondary" style="font-size:13px;">Direct Form Page</a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <form method="GET" class="toolbar" style="margin-top:16px; margin-bottom:16px; display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
            <input type="text" class="search-input" name="q" value="{{ request('q') }}" placeholder="Search name, phone, size, city, notes..." style="width:280px; padding:8px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
            
            <select name="size" style="padding:8px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px; background:#fff;">
                <option value="">All Sizes</option>
                @foreach(['UK 10', 'UK 12', 'UK 14', 'UK 16', 'UK 18', 'UK 20', 'UK 22'] as $sizeOption)
                    <option value="{{ $sizeOption }}" {{ request('size') === $sizeOption ? 'selected' : '' }}>{{ $sizeOption }}</option>
                @endforeach
            </select>

            <select name="status" style="padding:8px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px; background:#fff;">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="btn btn-secondary" style="padding:8px 14px;">Filter</button>
            @if(request()->anyFilled(['q', 'size', 'status']))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary" style="padding:8px 12px; color:#6b7280;">Clear</a>
            @endif
        </form>

        @if($customers->isEmpty())
            <div style="text-align:center; padding:48px 20px; background:#faf7f4; border-radius:12px; border:1px dashed #e7dfd8;">
                <div style="font-size:32px; margin-bottom:8px;">👥</div>
                <h4 style="font-size:16px; font-weight:700; color:#191614; margin-bottom:4px;">No customers found</h4>
                <p class="muted" style="margin-bottom:16px;">Try adjusting your search criteria or register a new customer directly.</p>
                <button type="button" class="btn btn-primary" onclick="openAddCustomerModal()">+ Register Customer Now</button>
            </div>
        @else
            <div class="table-wrap">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid #e5e7eb; text-align:left; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.5px;">
                            <th style="padding:12px;">Customer</th>
                            <th style="padding:12px;">WhatsApp / Phone</th>
                            <th style="padding:12px;">Size</th>
                            <th style="padding:12px;">Location</th>
                            <th style="padding:12px;">Orders</th>
                            <th style="padding:12px;">Status</th>
                            <th style="padding:12px; text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr style="border-bottom:1px solid #f3f4f6; transition:background 0.15s ease;" onmouseover="this.style.background='#faf8f5'" onmouseout="this.style.background='transparent'">
                            <td style="padding:12px;">
                                <div style="font-weight:700; color:#191614; font-size:14px;">
                                    <a href="{{ route('admin.customers.show', $customer) }}" style="color:inherit; text-decoration:none;">{{ $customer->name }}</a>
                                </div>
                                <div style="font-size:12px; color:#9ca3af;">{{ $customer->email ?? 'No email' }} • Joined {{ $customer->created_at?->format('M d, Y') }}</div>
                            </td>
                            <td style="padding:12px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-family:monospace; font-weight:600; font-size:13px; color:#1f2937;">{{ $customer->phone ?? '—' }}</span>
                                    @if($customer->phone)
                                        @php
                                            $cleanPh = preg_replace('/[^0-9]/', '', $customer->phone);
                                            if(str_starts_with($cleanPh, '0') && strlen($cleanPh) === 10) {
                                                $cleanPh = '233' . substr($cleanPh, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPh }}?text={{ urlencode('Hello ' . $customer->name . '! This is Curves & Tees boutique stylist.') }}" target="_blank" class="btn btn-sm" style="padding:3px 8px; font-size:11px; background:#dcfce7; color:#15803d; border:1px solid #86efac; border-radius:6px; text-decoration:none; display:inline-flex; align-items:center; gap:4px;" title="Chat with {{ $customer->name }} on WhatsApp">
                                            <span>💬</span> WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td style="padding:12px;">
                                @if($customer->preferred_size)
                                    <span class="badge" style="background:#fef3c7; color:#92400e; font-weight:700; border:1px solid #fde68a;">{{ $customer->preferred_size }}</span>
                                @else
                                    <span class="muted" style="font-size:12px;">Not set</span>
                                @endif
                            </td>
                            <td style="padding:12px;">
                                <div style="font-size:13px; color:#374151;">{{ $customer->city ?? 'Accra' }}</div>
                                @if($customer->address)
                                    <div style="font-size:11.5px; color:#9ca3af; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $customer->address }}</div>
                                @endif
                            </td>
                            <td style="padding:12px;">
                                @if($customer->orders_count > 0)
                                    <span class="badge badge-success">{{ $customer->orders_count }} {{ Str::plural('order', $customer->orders_count) }}</span>
                                @else
                                    <span class="badge badge-gray">0 orders</span>
                                @endif
                            </td>
                            <td style="padding:12px;">
                                @if($customer->status === 'active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td style="padding:12px; text-align:right;">
                                <div class="actions" style="justify-content:flex-end; gap:6px;">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary btn-sm" title="View customer profile & history">View</a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-secondary btn-sm" title="Edit customer details">Edit</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $customers->links() }}</div>
        @endif
    </div>

    <!-- Direct Add Customer Modal -->
    <div id="addCustomerModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:9999; align-items:center; justify-content:center; padding:16px;">
        <div style="background:#fff; border-radius:16px; width:100%; max-width:580px; max-height:92vh; overflow-y:auto; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); border:1px solid #e5e7eb;">
            <div style="padding:20px 24px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center; background:#191614; color:#fff; border-radius:16px 16px 0 0;">
                <div>
                    <h3 style="font-size:18px; font-weight:800; margin:0; letter-spacing:-0.3px;">Save Customer Directly</h3>
                    <p style="margin:2px 0 0 0; font-size:12.5px; color:#e5b88f;">Add in-store boutique walk-ins, phone orders, or Instagram customers into the system</p>
                </div>
                <button type="button" onclick="closeAddCustomerModal()" style="background:none; border:none; color:#d1d5db; font-size:24px; cursor:pointer; line-height:1;">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.customers.store') }}" style="padding:24px;">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Full Name <span style="color:#b91c1c;">*</span></label>
                        <input type="text" name="name" required placeholder="e.g. Ama Serwaa" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">WhatsApp / Phone Number <span style="color:#b91c1c;">*</span></label>
                        <input type="text" name="phone" required placeholder="e.g. 054 123 4567" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Email Address (Optional)</label>
                        <input type="email" name="email" placeholder="e.g. ama@gmail.com" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
                        <div style="font-size:11px; color:#9ca3af; margin-top:3px;">Auto-generated if left blank</div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Preferred / Fitted Size</label>
                        <select name="preferred_size" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px; background:#fff;">
                            <option value="">Select Curvy Size</option>
                            <option value="UK 10">UK 10 (US 6 / S-M)</option>
                            <option value="UK 12">UK 12 (US 8 / Medium)</option>
                            <option value="UK 14">UK 14 (US 10 / Large)</option>
                            <option value="UK 16">UK 16 (US 12 / XL)</option>
                            <option value="UK 18">UK 18 (US 14 / 1X)</option>
                            <option value="UK 20">UK 20 (US 16 / 2X)</option>
                            <option value="UK 22">UK 22 (US 18 / 3X)</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Customer Acquisition Source</label>
                        <select name="source" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px; background:#fff;">
                            <option value="In-Store Walk-in / Showroom">In-Store Walk-in / Showroom (Madina)</option>
                            <option value="Phone Call / Direct Inquiry">Phone Call / Direct Inquiry</option>
                            <option value="Instagram DM (@curves_and_tees)">Instagram DM (@curves_and_tees)</option>
                            <option value="WhatsApp Direct Chat">WhatsApp Direct Chat</option>
                            <option value="VIP Client Referral">VIP Client Referral</option>
                            <option value="Pop-up / Fashion Event">Pop-up / Fashion Event</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">City / Area</label>
                        <input type="text" name="city" value="Madina / Accra" placeholder="e.g. East Legon, Accra" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Delivery Address / Residential Location</label>
                    <input type="text" name="address" placeholder="e.g. Madina Estate, near Rawlings Park, House No. 4B" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Outfit Interest / Current Request (Optional)</label>
                    <input type="text" name="outfit_interest" placeholder="e.g. Emerald Green Satin Wrap Dress or Flare Jeans" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;">
                    <div style="font-size:11px; color:#9ca3af; margin-top:3px;">Logs an initial activity/lead touchpoint for campaign broadcasts</div>
                </div>

                <div class="form-group" style="margin-bottom:20px;">
                    <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:#374151;">Stylist Notes & Fit Preferences</label>
                    <textarea name="notes" rows="3" placeholder="e.g. Loves high-waisted cuts, prefers midi length, loves bold prints, VIP shopper" style="width:100%; padding:9px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13.5px;"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; border-top:1px solid #f3f4f6; padding-top:16px;">
                    <button type="button" onclick="closeAddCustomerModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:#191614; color:#fff;">Save Customer to System</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddCustomerModal() {
            document.getElementById('addCustomerModal').style.display = 'flex';
        }
        function closeAddCustomerModal() {
            document.getElementById('addCustomerModal').style.display = 'none';
        }
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAddCustomerModal();
        });
    </script>
@endsection
