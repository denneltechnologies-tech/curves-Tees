@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="grid grid-4">
        <div class="stat" style="background:#191614;"><div class="value">{{ $totalOrders }}</div><div class="label">Total Orders</div></div>
        <div class="stat" style="background:#c98a58;"><div class="value">{{ $pendingOrders }}</div><div class="label">Pending Orders</div></div>
        <div class="stat" style="background:#10b981;"><div class="value">{{ $paidOrders }}</div><div class="label">Paid Orders</div></div>
        <div class="stat" style="background:#3b82f6;"><div class="value">{{ $processingOrders }}</div><div class="label">Processing</div></div>
        <div class="stat" style="background:#8b5cf6;"><div class="value">{{ $deliveredOrders }}</div><div class="label">Delivered</div></div>
        <div class="stat" style="background:#ea580c;"><div class="value">{{ $totalCustomers }}</div><div class="label">Customers</div></div>
        <div class="stat" style="background:#0f766e;"><div class="value">{{ $totalProducts }}</div><div class="label">Clothing Items</div></div>
        <div class="stat" style="background:#f59e0b; color:#111;"><div class="value" style="color:#111;">GH₵{{ number_format($revenue, 2) }}</div><div class="label" style="color:#222;">Revenue (Paid)</div></div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="page-head">
            <h3 class="page-title">Recent Customer Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All Orders</a>
        </div>
        @if($recentOrders->isEmpty())
            <p class="muted">No orders yet.</p>
        @else
        <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->user?->name ?? $order->deliveryInformation?->recipient_name ?? 'Guest Customer' }}</td>
                    <td><strong>GH₵{{ number_format($order->total, 2) }}</strong></td>
                    <td>
                        @if($order->payment_status === 'SUCCESSFUL' || $order->payment_status === 'paid') <span class="badge badge-success">Paid</span>
                        @else <span class="badge badge-warning">{{ $order->payment_status }}</span> @endif
                    </td>
                    <td><span class="badge badge-info">{{ $order->order_status }}</span></td>
                    <td>{{ $order->created_at?->format('M d, H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
@endsection
