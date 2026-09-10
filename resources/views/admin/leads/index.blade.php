@extends('admin.layouts.app')

@section('title', 'Customer Leads & Marketing Campaigns')
@section('content')
    <!-- Dashboard Stat Cards -->
    <div class="grid-5" style="margin-bottom: 24px;">
        <div class="stat-card" style="border-top: 3px solid #191614;">
            <div class="stat-header">
                <div class="stat-label">Total Leads Captured</div>
                <div class="stat-icon" style="background:#f1f5f9;">📱</div>
            </div>
            <div class="stat-value">{{ number_format($stats['total']) }}</div>
            <div class="stat-meta">Across all boutique channels</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #25D366;">
            <div class="stat-header">
                <div class="stat-label">WhatsApp Inquiries</div>
                <div class="stat-icon" style="background:#dcfce7; color:#15803d;">💬</div>
            </div>
            <div class="stat-value" style="color:#15803d;">{{ number_format($stats['whatsapp_inquiries']) }}</div>
            <div class="stat-meta" style="color:#15803d; font-weight:600;">Active chat inquiries</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #10b981;">
            <div class="stat-header">
                <div class="stat-label">Web Checkouts</div>
                <div class="stat-icon" style="background:#ecfdf5; color:#059669;">🛍️</div>
            </div>
            <div class="stat-value" style="color:#059669;">{{ number_format($stats['checkouts']) }}</div>
            <div class="stat-meta">Completed orders</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #f59e0b;">
            <div class="stat-header">
                <div class="stat-label">In-Store / Direct</div>
                <div class="stat-icon" style="background:#fef3c7; color:#b45309;">🏢</div>
            </div>
            <div class="stat-value" style="color:#b45309;">{{ number_format($stats['admin_direct'] ?? 0) }}</div>
            <div class="stat-meta">Admin showroom entries</div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #a86c3d;">
            <div class="stat-header">
                <div class="stat-label">Unique Clients</div>
                <div class="stat-icon" style="background:#fdf8f4; color:#a86c3d;">👥</div>
            </div>
            <div class="stat-value" style="color:#a86c3d;">{{ number_format($stats['unique_phones']) }}</div>
            <div class="stat-meta">Verified WhatsApp nos</div>
        </div>
    </div>

    <!-- Campaign Message Templates helper card -->
    <div class="card" style="background: linear-gradient(135deg, #fdfbf7 0%, #f7f1ea 100%); border-left: 4px solid #c98a58; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;" onclick="document.getElementById('templatesBox').classList.toggle('hidden');">
            <div>
                <h3 style="display:flex; align-items:center; gap:8px;">
                    <span>📣</span> WhatsApp Campaign & Broadcast Templates
                    <span class="badge badge-warning" style="font-size:11px;">Click to toggle templates</span>
                </h3>
                <p class="muted mt-2" style="font-size:13px; margin:4px 0 0 0;">Use these pre-formatted copy-paste scripts when broadcasting to your captured customer list.</p>
            </div>
            <button type="button" class="btn btn-secondary btn-sm">Toggle Templates</button>
        </div>

        <div id="templatesBox" class="hidden" style="margin-top: 16px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div style="background:#fff; padding:16px; border-radius:12px; border:1px solid #e5e7eb;">
                <strong style="display:block; margin-bottom:8px; font-size:13px; color:#191614;">1. New Arrivals / Flash Sale</strong>
                <textarea readonly style="width:100%; height:90px; font-size:12px; padding:8px; border:1px solid #ddd; border-radius:8px; resize:none;">Hello Gorgeous! 💖 Curves & Tees just dropped new luxury arrivals in Madina! Flattering fits in UK 10 to 22. Tap here to view the new collection: http://127.0.0.1:8000</textarea>
            </div>
            <div style="background:#fff; padding:16px; border-radius:12px; border:1px solid #e5e7eb;">
                <strong style="display:block; margin-bottom:8px; font-size:13px; color:#191614;">2. Abandoned Bag / Outfit Hold</strong>
                <textarea readonly style="width:100%; height:90px; font-size:12px; padding:8px; border:1px solid #ddd; border-radius:8px; resize:none;">Hey sis! 💕 We noticed you saved an outfit at Curves & Tees. We are reserving your size for the next 24 hours. Would you like us to dispatch your delivery today?</textarea>
            </div>
            <div style="background:#fff; padding:16px; border-radius:12px; border:1px solid #e5e7eb;">
                <strong style="display:block; margin-bottom:8px; font-size:13px; color:#191614;">3. Weekend VIP Special</strong>
                <textarea readonly style="width:100%; height:90px; font-size:12px; padding:8px; border:1px solid #ddd; border-radius:8px; resize:none;">Curves & Tees VIP Alert! ✨ Enjoy free Accra delivery on all orders this weekend when you shop via WhatsApp hotline +233571038444. Check catalog: http://127.0.0.1:8000</textarea>
            </div>
        </div>
    </div>

    <!-- Leads Table & Filters -->
    <div class="card">
        <div class="page-head" style="flex-wrap:wrap; gap:12px;">
            <div>
                <h3 class="page-title">Customer Contacts & Inquiries ({{ $leads->total() }})</h3>
                <p class="muted" style="margin:2px 0 0 0; font-size:13px;">View inquiries, filter by channel, and follow up directly on WhatsApp.</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary" style="background:#191614; color:#fff;">
                    + Add Customer Directly
                </a>
                <a href="{{ route('admin.leads.export') }}" class="btn btn-primary" style="background:#10b981; border-color:#10b981;">
                    📥 Export CSV
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.leads.index') }}" style="margin: 16px 0; display:flex; flex-wrap:wrap; gap:10px; align-items:center; background:#faf8f5; padding:12px 14px; border-radius:10px; border:1px solid #e7dfd8;">
            <input type="text" class="search-input" name="q" value="{{ request('q') }}" placeholder="Search name, phone, notes..." style="width: 220px; padding:8px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13px;">
            
            <select name="action_type" style="padding:8px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13px; background:#fff;">
                <option value="">All Channels / Sources</option>
                <option value="whatsapp_inquiry" {{ request('action_type') === 'whatsapp_inquiry' ? 'selected' : '' }}>WhatsApp Inquiries</option>
                <option value="checkout" {{ request('action_type') === 'checkout' ? 'selected' : '' }}>Checkouts</option>
                <option value="admin_direct" {{ request('action_type') === 'admin_direct' ? 'selected' : '' }}>Direct Admin / In-Store</option>
                <option value="add_to_cart" {{ request('action_type') === 'add_to_cart' ? 'selected' : '' }}>Bag Additions</option>
                <option value="vip_club" {{ request('action_type') === 'vip_club' ? 'selected' : '' }}>VIP Signup</option>
            </select>

            <select name="size" style="padding:8px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:13px; background:#fff;">
                <option value="">All Sizes</option>
                @foreach(['UK 10', 'UK 12', 'UK 14', 'UK 16', 'UK 18', 'UK 20', 'UK 22'] as $s)
                    <option value="{{ $s }}" {{ request('size') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-secondary" style="padding:8px 14px; font-size:13px;">Filter</button>
            @if(request()->anyFilled(['q', 'action_type', 'size']))
                <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary btn-sm" style="color:#6b7280;">Reset</a>
            @endif
        </form>

        @if($leads->isEmpty())
            <div style="text-align: center; padding: 48px 20px; background:#faf7f4; border-radius:12px; border:1px dashed #e7dfd8;">
                <div style="font-size: 40px; margin-bottom: 12px;">📱</div>
                <h4 style="font-size:16px; font-weight:700; color:#191614;">No customer leads found</h4>
                <p class="muted mt-2" style="max-width:500px; margin:8px auto 16px auto;">
                    {{ request()->anyFilled(['q', 'action_type', 'size']) ? 'No leads match your filter criteria. Click Reset to view all.' : 'When shoppers click WhatsApp, add outfits to their bag, or checkout on the storefront, their phone numbers and outfit inquiries will be logged here automatically.' }}
                </p>
                @if(request()->anyFilled(['q', 'action_type', 'size']))
                    <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary">Clear Filters</a>
                @endif
            </div>
        @else
            <div class="table-wrap">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid #e5e7eb; text-align:left; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.5px;">
                            <th style="padding:12px;">Client</th>
                            <th style="padding:12px;">WhatsApp Phone</th>
                            <th style="padding:12px;">Size</th>
                            <th style="padding:12px;">Source</th>
                            <th style="padding:12px;">Captured</th>
                            <th style="padding:12px; text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                            @php
                                $cleanPh = preg_replace('/[^0-9]/', '', $lead->phone);
                                if(str_starts_with($cleanPh, '0') && strlen($cleanPh) === 10) {
                                    $cleanPh = '233' . substr($cleanPh, 1);
                                }
                                $leadJson = json_encode([
                                    'id' => $lead->id,
                                    'name' => $lead->name ?: 'Shopper',
                                    'phone' => $lead->phone,
                                    'email' => $lead->email,
                                    'product_name' => $lead->product?->name ?? $lead->product_name ?? 'General Stylist Inquiry',
                                    'product_price' => $lead->product_price ? 'GH₵' . number_format((float)$lead->product_price, 2) : null,
                                    'product_url' => $lead->product ? route('store.product', $lead->product) : null,
                                    'selected_size' => $lead->selected_size ?: 'Not specified',
                                    'action_type' => $lead->action_type,
                                    'notes' => $lead->notes,
                                    'created_at' => $lead->created_at?->format('M d, Y H:i') ?? '—',
                                    'whatsapp_url' => $lead->getWhatsAppFollowupUrl(),
                                    'user_id' => $lead->user_id,
                                    'user_url' => $lead->user_id ? route('admin.customers.show', $lead->user_id) : null,
                                    'order_id' => $lead->order_id,
                                    'order_url' => $lead->order_id ? route('admin.orders.show', $lead->order_id) : null,
                                    'order_number' => $lead->order?->order_number,
                                ]);
                            @endphp
                            <tr style="border-bottom:1px solid #f3f4f6; transition:background .12s ease;" onmouseover="this.style.background='#faf8f5'" onmouseout="this.style.background='transparent'">
                                <td style="padding:12px;">
                                    <div style="font-weight:700; color:#191614; font-size:14px;">
                                        {{ $lead->name ?: 'Shopper' }}
                                    </div>
                                    @if($lead->email)
                                        <div class="muted" style="font-size:11.5px;">{{ $lead->email }}</div>
                                    @endif
                                </td>
                                <td style="padding:12px;">
                                    <span style="font-family:monospace; font-weight:600; font-size:13px; color:#1f2937;">{{ $lead->phone }}</span>
                                </td>
                                <td style="padding:12px;">
                                    @if($lead->selected_size)
                                        <span class="badge" style="background:#fef3c7; color:#92400e; font-weight:700; border:1px solid #fde68a;">{{ $lead->selected_size }}</span>
                                    @else
                                        <span class="muted" style="font-size:12px;">—</span>
                                    @endif
                                </td>
                                <td style="padding:12px;">
                                    @if($lead->action_type === 'whatsapp_inquiry')
                                        <span class="badge" style="background:#dcfce7; color:#15803d;">💬 WhatsApp Chat</span>
                                    @elseif($lead->action_type === 'add_to_cart')
                                        <span class="badge badge-info">🛒 Bag Addition</span>
                                    @elseif($lead->action_type === 'checkout')
                                        <span class="badge badge-success">🛍️ Checkout</span>
                                    @elseif($lead->action_type === 'admin_direct')
                                        <span class="badge" style="background:#fef3c7; color:#92400e;">🏢 In-Store / Direct</span>
                                    @else
                                        <span class="badge badge-warning">{{ ucfirst($lead->action_type) }}</span>
                                    @endif
                                </td>
                                <td style="padding:12px; font-size:12.5px; color:#6b7280;">
                                    {{ $lead->created_at?->format('M d, Y H:i') }}
                                </td>
                                <td style="padding:12px; text-align:right;">
                                    <div style="display:inline-flex; gap:6px; align-items:center; justify-content:flex-end;">
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-secondary btn-sm" onclick='showLeadDetails({!! htmlspecialchars($leadJson, ENT_QUOTES, "UTF-8") !!})' style="font-size:12px; padding:5px 10px; font-weight:700; background:#f3f4f6; border:1px solid #d1d5db;" title="View client details & outfit inquiry">
                                            👁️ View Details
                                        </button>

                                        <!-- WhatsApp Followup Button -->
                                        <a href="{{ $lead->getWhatsAppFollowupUrl() }}" target="_blank" class="btn btn-sm" style="background:#25D366; color:#fff; font-weight:700; font-size:11.5px; padding:5px 10px; border-radius:7px; text-decoration:none;" title="Chat with {{ $lead->name }} on WhatsApp">
                                            💬 WhatsApp
                                        </a>

                                        <!-- Delete Lead -->
                                        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" class="inline" onsubmit="return confirm('Remove this lead touchpoint?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-secondary btn-sm" style="color:#ef4444; padding:5px 8px; font-size:11px;" title="Delete">✕</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $leads->links() }}</div>
        @endif
    </div>

    <!-- Client Details Modal -->
    <div id="leadDetailsModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:9999; align-items:center; justify-content:center; padding:16px;">
        <div style="background:#fff; border-radius:16px; width:100%; max-width:540px; max-height:90vh; overflow-y:auto; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); border:1px solid #e5e7eb;">
            <div style="padding:18px 22px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center; background:#191614; color:#fff; border-radius:16px 16px 0 0;">
                <div>
                    <h3 id="modalClientName" style="font-size:17px; font-weight:800; margin:0; letter-spacing:-0.3px;">Client Inquiry Details</h3>
                    <div id="modalClientSub" style="font-size:12px; color:#e5b88f; margin-top:2px;">Lead Details & Preferences</div>
                </div>
                <button type="button" onclick="closeLeadDetailsModal()" style="background:none; border:none; color:#d1d5db; font-size:24px; cursor:pointer; line-height:1;">&times;</button>
            </div>

            <div style="padding:22px;">
                <!-- Client Contact Info -->
                <div style="background:#faf8f5; border:1px solid #e7dfd8; border-radius:12px; padding:14px 16px; margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <div>
                            <div style="font-size:11px; text-transform:uppercase; color:#9ca3af; font-weight:700;">Client Contact</div>
                            <div id="modalPhone" style="font-size:16px; font-weight:800; font-family:monospace; color:#191614;">—</div>
                        </div>
                        <a id="modalWhatsAppBtn" href="#" target="_blank" class="btn btn-sm" style="background:#25D366; color:#fff; font-weight:700; font-size:12px; padding:6px 12px; border-radius:8px; text-decoration:none;">
                            💬 Open WhatsApp Chat
                        </a>
                    </div>
                    <div id="modalEmailRow" style="font-size:12.5px; color:#6b7280; display:none;">
                        <strong>Email:</strong> <span id="modalEmail"></span>
                    </div>
                </div>

                <!-- Outfit of Interest & Sizing -->
                <div style="border:1px solid #e5e7eb; border-radius:12px; padding:16px; margin-bottom:16px;">
                    <div style="font-size:11px; text-transform:uppercase; color:#9ca3af; font-weight:700; margin-bottom:6px;">Outfit / Item Requested</div>
                    <div id="modalOutfit" style="font-size:15px; font-weight:700; color:#191614; margin-bottom:6px;">—</div>
                    <div style="display:flex; gap:12px; align-items:center; margin-top:8px;">
                        <div>
                            <span style="font-size:12px; color:#6b7280;">Size Requested:</span>
                            <span id="modalSize" class="badge" style="background:#fef3c7; color:#92400e; font-weight:700; margin-left:4px;">—</span>
                        </div>
                        <div id="modalPriceWrap" style="display:none;">
                            <span style="font-size:12px; color:#6b7280;">Price:</span>
                            <strong id="modalPrice" style="color:#059669; margin-left:4px;"></strong>
                        </div>
                        <a id="modalProductLink" href="#" target="_blank" style="font-size:12px; color:#a86c3d; text-decoration:underline; font-weight:600; display:none;">
                            View Item in Catalog ↗
                        </a>
                    </div>
                </div>

                <!-- Notes & Delivery Details -->
                <div style="border:1px solid #e5e7eb; border-radius:12px; padding:16px; margin-bottom:16px;">
                    <div style="font-size:11px; text-transform:uppercase; color:#9ca3af; font-weight:700; margin-bottom:6px;">Stylist Notes & Client Inquiries</div>
                    <div id="modalNotes" style="font-size:13px; color:#374151; line-height:1.5; background:#f9fafb; padding:10px 12px; border-radius:8px; min-height:40px;">
                        No special notes attached to this lead.
                    </div>
                </div>

                <!-- System Metadata & Cross-Links -->
                <div style="font-size:12.5px; color:#6b7280; line-height:1.8; border-top:1px solid #f3f4f6; padding-top:12px;">
                    <div><strong>Acquisition Source:</strong> <span id="modalSource" class="badge badge-info" style="font-size:11px;">—</span></div>
                    <div><strong>Recorded On:</strong> <span id="modalCreatedAt"></span></div>
                    <div id="modalUserLinkWrap" style="margin-top:6px; display:none;">
                        <strong>Saved Customer:</strong> <a id="modalUserLink" href="#" style="color:#a86c3d; font-weight:700; text-decoration:underline;">View Customer Profile & Purchase History →</a>
                    </div>
                    <div id="modalOrderLinkWrap" style="margin-top:4px; display:none;">
                        <strong>Associated Order:</strong> <a id="modalOrderLink" href="#" style="color:#059669; font-weight:700; text-decoration:underline;">View Order Details →</a>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; border-top:1px solid #f3f4f6; padding-top:14px;">
                    <button type="button" onclick="closeLeadDetailsModal()" class="btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLeadDetails(lead) {
            document.getElementById('modalClientName').textContent = lead.name || 'Shopper';
            document.getElementById('modalClientSub').textContent = 'Lead ID #' + lead.id + ' • Captured on ' + lead.created_at;
            document.getElementById('modalPhone').textContent = lead.phone || '—';
            document.getElementById('modalWhatsAppBtn').href = lead.whatsapp_url || ('https://wa.me/' + lead.phone);
            
            if (lead.email) {
                document.getElementById('modalEmail').textContent = lead.email;
                document.getElementById('modalEmailRow').style.display = 'block';
            } else {
                document.getElementById('modalEmailRow').style.display = 'none';
            }

            document.getElementById('modalOutfit').textContent = lead.product_name || 'General Stylist Inquiry';
            document.getElementById('modalSize').textContent = lead.selected_size || 'Not specified';

            if (lead.product_price) {
                document.getElementById('modalPrice').textContent = lead.product_price;
                document.getElementById('modalPriceWrap').style.display = 'inline-block';
            } else {
                document.getElementById('modalPriceWrap').style.display = 'none';
            }

            if (lead.product_url) {
                document.getElementById('modalProductLink').href = lead.product_url;
                document.getElementById('modalProductLink').style.display = 'inline-block';
            } else {
                document.getElementById('modalProductLink').style.display = 'none';
            }

            document.getElementById('modalNotes').textContent = lead.notes || 'No special notes provided.';
            document.getElementById('modalSource').textContent = lead.action_type || 'General';
            document.getElementById('modalCreatedAt').textContent = lead.created_at || '—';

            if (lead.user_url) {
                document.getElementById('modalUserLink').href = lead.user_url;
                document.getElementById('modalUserLinkWrap').style.display = 'block';
            } else {
                document.getElementById('modalUserLinkWrap').style.display = 'none';
            }

            if (lead.order_url) {
                document.getElementById('modalOrderLink').href = lead.order_url;
                document.getElementById('modalOrderLink').textContent = 'Order #' + (lead.order_number || lead.order_id);
                document.getElementById('modalOrderLinkWrap').style.display = 'block';
            } else {
                document.getElementById('modalOrderLinkWrap').style.display = 'none';
            }

            document.getElementById('leadDetailsModal').style.display = 'flex';
        }

        function closeLeadDetailsModal() {
            document.getElementById('leadDetailsModal').style.display = 'none';
        }

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLeadDetailsModal();
        });
    </script>

    <style>
        .hidden { display: none !important; }
    </style>
@endsection
