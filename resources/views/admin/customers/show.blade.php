@extends('admin.layouts.app')

@section('title', 'Customer: ' . $user->name)
@section('content')
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <a href="{{ route('admin.customers.index') }}" style="color: #a86c3d; text-decoration: none; font-size: 13.5px; font-weight: 600;">← Back to Customer Directory</a>
            <h2 style="font-size: 24px; font-weight: 800; color: #191614; margin-top: 4px;">{{ $user->name }}</h2>
            <div class="muted">Customer ID #{{ $user->id }} • Registered on {{ $user->created_at?->format('M d, Y') }} ({{ $user->created_at?->diffForHumans() }})</div>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            @if($user->phone)
                @php
                    $cleanPh = preg_replace('/[^0-9]/', '', $user->phone);
                    if(str_starts_with($cleanPh, '0') && strlen($cleanPh) === 10) {
                        $cleanPh = '233' . substr($cleanPh, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $cleanPh }}?text={{ urlencode('Hello ' . $user->name . '! This is Curves & Tees boutique stylist.') }}" target="_blank" class="btn btn-sm" style="background: #15803d; color: #fff; display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 8px; text-decoration: none; font-weight: 700;">
                    <span>💬</span> Chat on WhatsApp
                </a>
            @endif

            <a href="{{ route('admin.customers.edit', $user) }}" class="btn btn-secondary">Edit Profile</a>

            <form method="POST" action="{{ route('admin.customers.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to remove or deactivate this customer?');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
            </form>
        </div>
    </div>

    <!-- Customer Details Card -->
    <div class="grid-3" style="margin-bottom: 24px;">
        <div class="card" style="margin-bottom: 0;">
            <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 14px; border-bottom: 1px solid #f3f4f6; padding-bottom: 8px;">Contact & Profile</h4>
            <div style="font-size: 13.5px; line-height: 1.8;">
                <div><strong style="color: #6b7280; width: 90px; display: inline-block;">Name:</strong> {{ $user->name }}</div>
                <div><strong style="color: #6b7280; width: 90px; display: inline-block;">WhatsApp:</strong> <span style="font-family: monospace; font-weight: 600;">{{ $user->phone ?? '—' }}</span></div>
                <div><strong style="color: #6b7280; width: 90px; display: inline-block;">Email:</strong> {{ $user->email ?? '—' }}</div>
                <div><strong style="color: #6b7280; width: 90px; display: inline-block;">Status:</strong> 
                    @if($user->status === 'active')
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0;">
            <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 14px; border-bottom: 1px solid #f3f4f6; padding-bottom: 8px;">Curvy Sizing & Delivery</h4>
            <div style="font-size: 13.5px; line-height: 1.8;">
                <div><strong style="color: #6b7280; width: 110px; display: inline-block;">Preferred Size:</strong> 
                    @if($user->preferred_size)
                        <span class="badge" style="background: #fef3c7; color: #92400e; font-weight: 700;">{{ $user->preferred_size }}</span>
                    @else
                        <span class="muted">Not recorded</span>
                    @endif
                </div>
                <div><strong style="color: #6b7280; width: 110px; display: inline-block;">City / Area:</strong> {{ $user->city ?? 'Accra' }}</div>
                <div><strong style="color: #6b7280; width: 110px; display: inline-block;">Address:</strong> {{ $user->address ?? '—' }}</div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0;">
            <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 14px; border-bottom: 1px solid #f3f4f6; padding-bottom: 8px;">Stylist Notes</h4>
            <div style="font-size: 13px; color: #4b5563; background: #faf8f5; padding: 12px; border-radius: 8px; border: 1px dashed #e7dfd8; min-height: 80px;">
                {{ $user->notes ?: 'No stylist notes added yet. Click Edit Profile to add fitting preferences, favorite colors, or VIP notes.' }}
            </div>
        </div>
    </div>

    <!-- Orders History -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="page-head" style="margin-bottom: 14px;">
            <h3 class="page-title">Orders Placed ({{ $orders->count() }})</h3>
        </div>
        @if($orders->isEmpty())
            <p class="muted">This customer has not placed an online order yet.</p>
        @else
            <div class="table-wrap">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb; text-align: left; font-size: 12px; text-transform: uppercase; color: #6b7280;">
                            <th style="padding: 10px;">Order #</th>
                            <th style="padding: 10px;">Items</th>
                            <th style="padding: 10px;">Total</th>
                            <th style="padding: 10px;">Payment</th>
                            <th style="padding: 10px;">Status</th>
                            <th style="padding: 10px;">Date</th>
                            <th style="padding: 10px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 10px;"><strong>{{ $order->order_number }}</strong></td>
                            <td style="padding: 10px;">
                                {{ $order->items->pluck('product_name')->implode(', ') }}
                                <div style="font-size: 11.5px; color: #9ca3af;">{{ $order->items->count() }} item(s)</div>
                            </td>
                            <td style="padding: 10px;"><strong>GH₵{{ number_format($order->total, 2) }}</strong></td>
                            <td style="padding: 10px;">
                                @if($order->payment_status === 'SUCCESSFUL' || $order->payment_status === 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-warning">{{ $order->payment_status }}</span>
                                @endif
                            </td>
                            <td style="padding: 10px;"><span class="badge badge-info">{{ $order->order_status }}</span></td>
                            <td style="padding: 10px; font-size: 12.5px; color: #6b7280;">{{ $order->created_at?->format('M d, Y H:i') }}</td>
                            <td style="padding: 10px; text-align: right;">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">View Order</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- WhatsApp Inquiries & Activity Leads -->
    <div class="card">
        <div class="page-head" style="margin-bottom: 14px;">
            <h3 class="page-title">WhatsApp Inquiries & Campaign Touchpoints ({{ $leads->count() }})</h3>
        </div>
        @if($leads->isEmpty())
            <p class="muted">No inquiry logs or touchpoints recorded yet.</p>
        @else
            <div class="table-wrap">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e7eb; text-align: left; font-size: 12px; text-transform: uppercase; color: #6b7280;">
                            <th style="padding: 10px;">Action / Touchpoint</th>
                            <th style="padding: 10px;">Outfit / Item Requested</th>
                            <th style="padding: 10px;">Size</th>
                            <th style="padding: 10px;">Stylist / Customer Notes</th>
                            <th style="padding: 10px;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 10px;">
                                @if($lead->action_type === 'whatsapp_inquiry')
                                    <span class="badge" style="background:#dcfce7; color:#15803d;">💬 WhatsApp Chat/Inquiry</span>
                                @elseif($lead->action_type === 'checkout')
                                    <span class="badge badge-success">🛍️ Checkout</span>
                                @elseif($lead->action_type === 'admin_direct')
                                    <span class="badge" style="background:#fef3c7; color:#92400e;">🏢 In-Store / Direct Admin</span>
                                @elseif($lead->action_type === 'add_to_cart')
                                    <span class="badge badge-info">🛒 Add to Bag</span>
                                @else
                                    <span class="badge badge-gray">{{ $lead->action_type }}</span>
                                @endif
                            </td>
                            <td style="padding: 10px; font-weight: 600; color: #191614;">
                                {{ $lead->product_name ?: 'General Stylist Inquiry' }}
                            </td>
                            <td style="padding: 10px;">
                                @if($lead->selected_size)
                                    <span class="badge" style="background:#fef3c7; color:#92400e;">{{ $lead->selected_size }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td style="padding: 10px; font-size: 13px; color: #4b5563;">
                                {{ $lead->notes ?: '—' }}
                            </td>
                            <td style="padding: 10px; font-size: 12.5px; color: #6b7280;">
                                {{ $lead->created_at?->format('M d, Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
