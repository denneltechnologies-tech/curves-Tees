@extends('admin.layouts.app')

@section('title', 'Customer')
@section('content')
    <div class="card">
        <h3 style="margin-bottom:16px;">{{ $user->name }}</h3>
        <table style="max-width:500px;">
            <tbody>
                <tr><th>Email</th><td>{{ $user->email ?? '—' }}</td></tr>
                <tr><th>Phone</th><td>{{ $user->phone ?? '—' }}</td></tr>
                <tr><th>Status</th><td>@if($user->status === 'active')<span class="badge badge-success">Active</span>@else<span class="badge badge-danger">Inactive</span>@endif</td></tr>
                <tr><th>Joined</th><td>{{ $user->created_at?->format('M d, Y') }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 style="margin-bottom:16px;">Orders ({{ $orders->count() }})</h3>
        @if($orders->isEmpty())
            <p class="muted">This customer has no orders.</p>
        @else
        <table>
            <thead><tr><th>Order #</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->items->count() }}</td>
                    <td><strong>GH₵{{ number_format($order->total, 2) }}</strong></td>
                    <td>@if($order->payment_status==='SUCCESSFUL' || $order->payment_status==='paid')<span class="badge badge-success">Paid</span>@else<span class="badge badge-warning">{{ $order->payment_status }}</span>@endif</td>
                    <td><span class="badge badge-info">{{ $order->order_status }}</span></td>
                    <td>{{ $order->created_at?->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection
