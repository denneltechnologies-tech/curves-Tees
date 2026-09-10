@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <!-- Dashboard Stats in Brand Palette -->
    <div class="grid grid-4">
        <div class="stat-card" style="border-top: 3px solid #181513;">
            <div class="stat-header">
                <div class="stat-label">Total Orders</div>
                <div class="stat-icon" style="background:#f1f5f9;">🛍️</div>
            </div>
            <div class="stat-value">{{ number_format($totalOrders) }}</div>
            <div class="stat-meta"><a href="{{ route('admin.orders.index') }}" style="color:#c58b2b; text-decoration:underline;">View orders list →</a></div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #c58b2b;">
            <div class="stat-header">
                <div class="stat-label">Revenue (Paid)</div>
                <div class="stat-icon" style="background:#fdf8ee; color:#c58b2b;">💰</div>
            </div>
            <div class="stat-value" style="color:#c58b2b;">GH₵{{ number_format($revenue, 2) }}</div>
            <div class="stat-meta" style="color:#059669; font-weight:600;">✓ Confirmed earnings</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #059669;">
            <div class="stat-header">
                <div class="stat-label">Paid Orders</div>
                <div class="stat-icon" style="background:#ecfdf5; color:#059669;">✓</div>
            </div>
            <div class="stat-value" style="color:#059669;">{{ number_format($paidOrders) }}</div>
            <div class="stat-meta">Ready for dispatch</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #d97706;">
            <div class="stat-header">
                <div class="stat-label">Pending Orders</div>
                <div class="stat-icon" style="background:#fffbeb; color:#d97706;">⏳</div>
            </div>
            <div class="stat-value" style="color:#d97706;">{{ number_format($pendingOrders) }}</div>
            <div class="stat-meta">Awaiting payment / confirmation</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #2563eb;">
            <div class="stat-header">
                <div class="stat-label">Processing</div>
                <div class="stat-icon" style="background:#eff6ff; color:#2563eb;">📦</div>
            </div>
            <div class="stat-value" style="color:#2563eb;">{{ number_format($processingOrders) }}</div>
            <div class="stat-meta">In preparation</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #7c3aed;">
            <div class="stat-header">
                <div class="stat-label">Delivered</div>
                <div class="stat-icon" style="background:#f5f3ff; color:#7c3aed;">🚚</div>
            </div>
            <div class="stat-value" style="color:#7c3aed;">{{ number_format($deliveredOrders) }}</div>
            <div class="stat-meta">Successfully fulfilled</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #c58b2b;">
            <div class="stat-header">
                <div class="stat-label">Boutique Customers</div>
                <div class="stat-icon" style="background:#fdf8ee; color:#c58b2b;">👥</div>
            </div>
            <div class="stat-value">{{ number_format($totalCustomers) }}</div>
            <div class="stat-meta"><a href="{{ route('admin.customers.index') }}" style="color:#c58b2b; text-decoration:underline;">Customer directory →</a></div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #0891b2;">
            <div class="stat-header">
                <div class="stat-label">Clothing Catalog</div>
                <div class="stat-icon" style="background:#ecfeff; color:#0891b2;">👗</div>
            </div>
            <div class="stat-value">{{ number_format($totalProducts) }}</div>
            <div class="stat-meta"><a href="{{ route('admin.products.index') }}" style="color:#c58b2b; text-decoration:underline;">Manage items →</a></div>
        </div>
    </div>

    <!-- Recent Orders Card -->
    <div class="card" style="margin-top:20px;">
        <div class="page-head">
            <h3 class="page-title">Recent Customer Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All Orders</a>
        </div>
        @if($recentOrders->isEmpty())
            <p class="muted">No orders placed yet.</p>
        @else
        <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><strong style="color:#181513;">{{ $order->order_number }}</strong></td>
                    <td>{{ $order->user?->name ?? $order->deliveryInformation?->recipient_name ?? 'Guest Customer' }}</td>
                    <td><strong style="color:#181513;">GH₵{{ number_format($order->total, 2) }}</strong></td>
                    <td>
                        @if($order->payment_status === 'SUCCESSFUL' || $order->payment_status === 'paid') <span class="badge badge-success">Paid</span>
                        @else <span class="badge badge-warning">{{ $order->payment_status }}</span> @endif
                    </td>
                    <td><span class="badge badge-info">{{ $order->order_status }}</span></td>
                    <td style="color:#64748b; font-size:13px;">{{ $order->created_at?->format('M d, H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
@endsection
