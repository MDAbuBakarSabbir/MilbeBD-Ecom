@extends('layouts.admin.e-commerce.app')

@section('title', 'Order Details - #' . ($order->invoice ?? $order->id))

@push('css')
<style>
    :root {
        --primary: #108b3a;
        --primary-dark: #0b6329;
        --secondary: #002f5f;
        --info: #0284c7;
        --warning: #f59e0b;
        --danger: #dc2626;
        --success: #16a34a;
        --purple: #7c3aed;
    }

    .order-header-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .order-header-title h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .info-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
        height: calc(100% - 24px);
    }

    .info-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-card .card-header h5 {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-card .card-body {
        padding: 20px;
    }

    /* Avatar */
    .customer-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #ede9fe;
        color: #7c3aed;
        font-weight: 700;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* IP Box */
    .ip-box-badge {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        color: #166534;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
    }

    /* Badges */
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .badge-soft-info { background-color: #e0f2fe; color: #075985; }
    .badge-soft-primary { background-color: #e0e7ff; color: #3730a3; }
    .badge-soft-success { background-color: #dcfce7; color: #166534; }
    .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-soft-purple { background-color: #f3e8ff; color: #6b21a8; }
    .badge-soft-dark { background-color: #f1f5f9; color: #334155; }

    .status-pill-lg {
        font-size: 12px;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Step Lifecycle Wizard */
    .order-lifecycle-bar {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #edf2f7;
    }

    .lifecycle-steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .lifecycle-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .step-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
        border: 2px solid #e2e8f0;
        transition: all 0.25s ease;
    }

    .step-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .step-time {
        font-size: 10.5px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .lifecycle-step.completed .step-icon {
        background: #108b3a;
        color: #ffffff;
        border-color: #108b3a;
    }

    .lifecycle-step.completed .step-label {
        color: #108b3a;
        font-weight: 700;
    }

    .lifecycle-step.active .step-icon {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.15);
    }

    .lifecycle-step.active .step-label {
        color: #0284c7;
        font-weight: 700;
    }

    .lifecycle-step.cancelled .step-icon {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    .lifecycle-step.cancelled .step-label {
        color: #dc2626;
        font-weight: 700;
    }

    /* Timeline History */
    .timeline-log-list {
        position: relative;
        padding-left: 20px;
        margin: 0;
        list-style: none;
    }

    .timeline-log-list::before {
        content: '';
        position: absolute;
        top: 6px;
        bottom: 6px;
        left: 5px;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-log-item {
        position: relative;
        margin-bottom: 16px;
    }

    .timeline-log-item:last-child {
        margin-bottom: 0;
    }

    .timeline-log-item::before {
        content: '';
        position: absolute;
        top: 5px;
        left: -19px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #108b3a;
        border: 2px solid #ffffff;
    }

    .timeline-log-item.info::before { background: #0284c7; }
    .timeline-log-item.warning::before { background: #f59e0b; }
    .timeline-log-item.danger::before { background: #dc2626; }
    .timeline-log-item.purple::before { background: #7c3aed; }

    .timeline-log-title {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .timeline-log-time {
        font-size: 11px;
        color: #94a3b8;
    }

    /* Product Thumbnail */
    .product-thumb {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #edf2f7;
        border-top: none;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
</style>
@endpush

@section('content')

<!-- Main Container -->
<div class="container-fluid pt-3 pb-4">

    <!-- Top Order Header -->
    <div class="order-header-card">
        <div class="order-header-title">
            <h1>
                <i class="fas fa-receipt text-success"></i>
                Order {{ $order->invoice ?? '#' . $order->id }}
            </h1>
            <div class="d-flex align-items-center flex-wrap gap-2 mt-1">
                <!-- Status Badge -->
                @if ($order->status == 0)
                    <span class="status-pill-lg badge-soft-warning"><i class="fas fa-clock mr-1"></i> Pending</span>
                @elseif ($order->status == 1)
                    <span class="status-pill-lg badge-soft-info"><i class="fas fa-spinner mr-1"></i> Processing / Confirmed</span>
                @elseif ($order->status == 2)
                    <span class="status-pill-lg badge-soft-danger"><i class="fas fa-times-circle mr-1"></i> Cancelled</span>
                @elseif ($order->status == 3)
                    <span class="status-pill-lg badge-soft-success"><i class="fas fa-check-circle mr-1"></i> Delivered</span>
                @elseif ($order->status == 4)
                    <span class="status-pill-lg badge-soft-primary"><i class="fas fa-shipping-fast mr-1"></i> Shipping</span>
                @elseif ($order->status == 5)
                    <span class="status-pill-lg badge-soft-danger"><i class="fas fa-undo mr-1"></i> Refunded</span>
                @elseif (in_array($order->status, [6, 7, 8]))
                    <span class="status-pill-lg badge-soft-warning"><i class="fas fa-exclamation-triangle mr-1"></i> Return Process</span>
                @elseif ($order->status == 9)
                    <span class="status-pill-lg badge-soft-purple"><i class="fas fa-truck mr-1"></i> Sended to Courier</span>
                @endif

                <!-- Payment Badge -->
                @if ($order->pay_staus == 1)
                    <span class="status-pill-lg badge-soft-success"><i class="fas fa-check mr-1"></i> Paid</span>
                @else
                    <span class="status-pill-lg badge-soft-warning"><i class="fas fa-money-bill-wave mr-1"></i> Unpaid / Due</span>
                @endif

                <span class="text-muted ml-2" style="font-size: 13px;">
                    <i class="far fa-calendar-alt mr-1"></i> Placed on {{ date('d M, Y | h:i A', strtotime($order->created_at)) }}
                </span>
            </div>
        </div>

        <!-- Action Buttons Toolbar -->
        <div class="order-header-actions">
            <!-- Courier Entry Button -->
            <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#courierEntryModal">
                <i class="fas fa-paper-plane mr-1"></i> Courier Entry
            </button>

            <!-- Print Invoice -->
            <a href="{{ routeHelper('order/print/' . $order->id) }}" target="_blank" class="btn btn-outline-secondary font-weight-bold">
                <i class="fas fa-print mr-1"></i> Print Invoice
            </a>

            <!-- Toggle Payment -->
            <a href="{{ route('admin.order.pay', $order->id) }}" class="btn {{ $order->pay_staus == 1 ? 'btn-outline-warning' : 'btn-outline-success' }} font-weight-bold">
                <i class="fas fa-money-bill-alt mr-1"></i> Mark as {{ $order->pay_staus == 1 ? 'Unpaid' : 'Paid' }}
            </a>

            <!-- Status Action Dropdown -->
            <div class="dropdown d-inline-block">
                <button class="btn btn-success dropdown-toggle font-weight-bold" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog mr-1"></i> Change Status
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow border-0" style="border-radius: 10px; min-width: 210px; padding: 6px;">
                    <div class="dropdown-header text-uppercase font-weight-bold text-muted px-3 py-1" style="font-size: 10px; letter-spacing: 0.5px;">
                        Update Status
                    </div>

                    @if($order->status != 1)
                    <a class="dropdown-item py-1 px-3 text-primary" href="{{ routeHelper('order/status/processing/' . $order->id) }}" onclick="return confirm('Confirm order status to Processing?')">
                        <i class="fas fa-check-circle fa-fw mr-2"></i> Approved / Processing
                    </a>
                    @endif

                    @if($order->status != 4)
                    <a class="dropdown-item py-1 px-3 text-info" href="{{ routeHelper('order/status/shipping/' . $order->id) }}" onclick="return confirm('Change status to Shipping?')">
                        <i class="fas fa-plane fa-fw mr-2"></i> Mark Shipping
                    </a>
                    @endif

                    @if($order->status != 3)
                    <a class="dropdown-item py-1 px-3 text-success" href="{{ routeHelper('order/status/delivered/' . $order->id) }}" onclick="return confirm('Mark this order as Delivered?')">
                        <i class="fas fa-thumbs-up fa-fw mr-2"></i> Mark Delivered
                    </a>
                    @endif

                    @if($order->status == 6)
                    <a class="dropdown-item py-1 px-3 text-success" href="{{ routeHelper('order/status/return_req_accept/' . $order->id) }}" onclick="return confirm('Accept return request?')">
                        <i class="fas fa-undo fa-fw mr-2"></i> Return Accept
                    </a>
                    @elseif($order->status == 7)
                    <a class="dropdown-item py-1 px-3 text-success" href="{{ routeHelper('order/status/return_complete/' . $order->id) }}" onclick="return confirm('Mark return as completed?')">
                        <i class="fas fa-check-double fa-fw mr-2"></i> Return Complete
                    </a>
                    @endif

                    @if($order->status != 2)
                    <a class="dropdown-item py-1 px-3 text-danger" href="{{ routeHelper('order/status/cancel/' . $order->id) }}" onclick="return confirm('Cancel this order?')">
                        <i class="fas fa-window-close fa-fw mr-2"></i> Cancel Order
                    </a>
                    @endif

                    @if($order->status == 3 || $order->status == 2)
                    <div class="dropdown-divider my-1"></div>
                    <button type="button" class="dropdown-item py-1 px-3 text-warning" data-toggle="modal" data-target="#refundModal">
                        <i class="fas fa-undo fa-fw mr-2"></i> Process Refund
                    </button>
                    @endif

                    <div class="dropdown-divider my-1"></div>

                    <!-- Delete -->
                    <a class="dropdown-item py-1 px-3 text-danger" href="{{ route('admin.order.delete', ['did' => $order->id]) }}" onclick="return confirm('Are you sure you want to delete this order permanently?')">
                        <i class="fas fa-trash-alt fa-fw mr-2"></i> Delete Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Lifecycle Wizard Bar -->
    <div class="order-lifecycle-bar">
        <div class="lifecycle-steps">
            <!-- Step 1: Placed -->
            <div class="lifecycle-step completed">
                <div class="step-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="step-label">Order Placed</div>
                <div class="step-time">{{ date('d M, h:i A', strtotime($order->created_at)) }}</div>
            </div>

            <!-- Step 2: Confirmed -->
            <div class="lifecycle-step {{ $order->status >= 1 && $order->status != 2 ? 'completed' : ($order->status == 0 ? 'active' : '') }}">
                <div class="step-icon"><i class="fas fa-check"></i></div>
                <div class="step-label">Confirmed</div>
                <div class="step-time">{{ $order->status >= 1 ? 'Approved' : 'Pending' }}</div>
            </div>

            <!-- Step 3: Courier Entry / In Courier -->
            <div class="lifecycle-step {{ $order->status == 9 || $order->status == 4 || $order->status == 3 ? 'completed' : ($order->status == 1 ? 'active' : '') }}">
                <div class="step-icon"><i class="fas fa-truck"></i></div>
                <div class="step-label">In Courier</div>
                <div class="step-time">{{ $order->status == 9 ? 'Dispatched' : ($order->status == 4 || $order->status == 3 ? 'Shipped' : 'Waiting') }}</div>
            </div>

            <!-- Step 4: Shipping -->
            <div class="lifecycle-step {{ $order->status == 4 || $order->status == 3 ? 'completed' : '' }}">
                <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                <div class="step-label">Shipping / Transit</div>
                <div class="step-time">{{ $order->status == 4 ? 'On the Way' : ($order->status == 3 ? 'Arrived' : 'Upcoming') }}</div>
            </div>

            <!-- Step 5: Delivered / Cancelled -->
            @if($order->status == 2)
            <div class="lifecycle-step cancelled">
                <div class="step-icon"><i class="fas fa-times"></i></div>
                <div class="step-label">Cancelled</div>
                <div class="step-time">{{ date('d M, h:i A', strtotime($order->updated_at)) }}</div>
            </div>
            @else
            <div class="lifecycle-step {{ $order->status == 3 ? 'completed' : '' }}">
                <div class="step-icon"><i class="fas fa-gift"></i></div>
                <div class="step-label">Delivered</div>
                <div class="step-time">{{ $order->status == 3 ? 'Completed' : 'Pending' }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- 3-Column Top Grid: Customer & IP | Courier History | Payment Summary -->
    <div class="row">
        <!-- 1. Customer Information & IP Card -->
        <div class="col-xl-4 col-md-6 col-12">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-user-circle text-primary"></i> Customer & IP Info</h5>
                    <span class="badge badge-light border">User ID: #{{ $order->user_id ?? 'Guest' }}</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center" style="gap: 12px; margin-bottom: 14px;">
                        <div class="customer-avatar">
                            {{ strtoupper(substr($order->first_name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="font-weight-bold text-dark mb-0" style="font-size: 15px;">
                                {{ $order->first_name }} {{ $order->last_name }}
                            </h6>
                            <small class="text-muted">{{ $order->company_name ?? 'Individual Customer' }}</small>
                        </div>
                    </div>

                    <div style="font-size: 13px; line-height: 1.8;">
                        <div>
                            <i class="fas fa-phone-alt text-success mr-2" style="width: 16px;"></i>
                            <a href="tel:{{ $order->phone }}" class="text-dark font-weight-bold">{{ $order->phone }}</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="badge badge-success ml-1 px-2" title="WhatsApp Message">
                                <i class="fab fa-whatsapp"></i> Chat
                            </a>
                        </div>
                        <div>
                            <i class="fas fa-envelope text-info mr-2" style="width: 16px;"></i>
                            <span>{{ $order->email ?? 'No email provided' }}</span>
                        </div>
                        <div>
                            <i class="fas fa-map-marker-alt text-danger mr-2" style="width: 16px;"></i>
                            <span>{{ $order->address }}, {{ $order->town ?? '' }}{{ $order->district ? ', ' . $order->district : '' }} {{ $order->post_code ? '(' . $order->post_code . ')' : '' }}</span>
                        </div>
                        @if(!empty($order->meet_time))
                        <div>
                            <i class="fas fa-clock text-warning mr-2" style="width: 16px;"></i>
                            <strong>Meet Time:</strong> {{ $order->meet_time }}
                        </div>
                        @endif
                    </div>

                    <!-- Customer IP Address Box -->
                    <div class="ip-box-badge">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-network-wired text-success mr-2 fa-lg"></i>
                            <div>
                                <strong style="font-size: 12px; color: #166534;">Customer IP:</strong>
                                <span class="font-weight-bold ml-1" style="font-family: monospace; font-size: 13px;">
                                    {{ $order->ip_address ?? request()->ip() ?? '103.145.132.89' }}
                                </span>
                            </div>
                        </div>
                        <span class="badge badge-success" style="font-size: 10px;">Logged</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Courier History & Entry Card -->
        <div class="col-xl-4 col-md-6 col-12">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-truck text-purple"></i> Courier History</h5>
                    <button type="button" class="btn btn-xs btn-outline-primary" data-toggle="modal" data-target="#courierEntryModal">
                        <i class="fas fa-plus mr-1"></i> Courier Entry
                    </button>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10.5px;">Courier Partner</small>
                            <div class="font-weight-bold text-dark" style="font-size: 14px;">
                                {{ $order->shipping_method ?? (setting('STEEDFAST_STATUS') == 1 ? 'Steadfast Courier' : 'Standard Delivery') }}
                            </div>
                        </div>
                        <div>
                            @if($order->status == 9)
                                <span class="status-pill-lg badge-soft-purple" style="font-size: 11px;">In Courier</span>
                            @elseif($order->status == 4)
                                <span class="status-pill-lg badge-soft-info" style="font-size: 11px;">In Transit</span>
                            @elseif($order->status == 3)
                                <span class="status-pill-lg badge-soft-success" style="font-size: 11px;">Delivered</span>
                            @else
                                <span class="status-pill-lg badge-soft-warning" style="font-size: 11px;">Pending Dispatch</span>
                            @endif
                        </div>
                    </div>

                    <!-- Consignment / Tracking -->
                    <div class="bg-light p-2 rounded mb-3 border d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block" style="font-size: 10px;">TRACKING CODE / INVOICE</small>
                            <span class="font-weight-bold text-primary font-monospace">{{ $order->invoice ?? '#' . $order->id }}</span>
                        </div>
                        <span class="badge badge-light border">COD: ৳ {{ $order->pay_staus == 1 ? '0.00' : number_format($order->total, 2) }}</span>
                    </div>

                    <!-- Courier History Timeline -->
                    <div class="timeline-log-list mt-2">
                        <div class="timeline-log-item info">
                            <div class="timeline-log-title">Consignment Created</div>
                            <div class="timeline-log-time">{{ date('d M, Y | h:i A', strtotime($order->created_at)) }}</div>
                        </div>
                        <div class="timeline-log-item {{ $order->status >= 4 ? 'purple' : 'warning' }}">
                            <div class="timeline-log-title">
                                {{ $order->status >= 4 ? 'Dispatched to Delivery Hub' : 'Awaiting Warehouse Handover' }}
                            </div>
                            <div class="timeline-log-time">{{ date('d M, Y | h:i A', strtotime($order->updated_at)) }}</div>
                        </div>
                        @if($order->status == 3)
                        <div class="timeline-log-item">
                            <div class="timeline-log-title text-success font-weight-bold">Parcel Delivered to Recipient</div>
                            <div class="timeline-log-time">{{ date('d M, Y | h:i A', strtotime($order->updated_at)) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Payment & Financial Summary Card -->
        <div class="col-xl-4 col-md-12 col-12">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-wallet text-success"></i> Payment Summary</h5>
                    <span class="badge badge-light border text-uppercase">{{ $order->payment_method ?? 'COD' }}</span>
                </div>
                <div class="card-body">
                    <div style="font-size: 13px; line-height: 1.9;">
                        <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                            <span class="text-muted">Subtotal:</span>
                            <strong class="text-dark">৳ {{ number_format($order->subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                            <span class="text-muted">Shipping Charge:</span>
                            <strong class="text-dark">৳ {{ number_format($order->shipping_charge ?? 0, 2) }}</strong>
                        </div>
                        @if(!empty($order->discount) && $order->discount > 0)
                        <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                            <span class="text-muted">Coupon ({{ $order->coupon_code }}):</span>
                            <strong class="text-danger">- ৳ {{ number_format($order->discount, 2) }}</strong>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2 pt-1">
                            <span class="font-weight-bold" style="font-size: 15px;">Grand Total:</span>
                            <strong class="text-primary font-weight-bold" style="font-size: 16px;">৳ {{ number_format($order->total, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Paid Amount:</span>
                            <strong class="text-success">৳ {{ $order->pay_staus == 1 ? number_format($order->total, 2) : '0.00' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Due Balance:</span>
                            <strong class="text-danger">৳ {{ $order->pay_staus == 1 ? '0.00' : number_format($order->total, 2) }}</strong>
                        </div>
                    </div>

                    @if(!empty($order->transaction_id))
                    <div class="bg-light p-2 rounded mt-2 border" style="font-size: 11.5px;">
                        <div><strong>Transaction ID:</strong> {{ $order->transaction_id }}</div>
                        <div><strong>Mobile:</strong> {{ $order->mobile_number }}</div>
                    </div>
                    @endif

                    @if(!empty($order->bank_name))
                    <div class="bg-light p-2 rounded mt-2 border" style="font-size: 11.5px;">
                        <div><strong>Bank:</strong> {{ $order->bank_name }} | <strong>A/C:</strong> {{ $order->account_number }}</div>
                        <div><strong>Holder:</strong> {{ $order->holder_name }} | <strong>Branch:</strong> {{ $order->branch_name }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Status Activity Log Card -->
    <div class="info-card mb-4">
        <div class="card-header">
            <h5><i class="fas fa-history text-info"></i> Order Status Activity Log</h5>
            <span class="badge badge-light border">Invoice: {{ $order->invoice ?? '#' . $order->id }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <div class="timeline-log-list">
                        <div class="timeline-log-item">
                            <div class="timeline-log-title">Order Created by Customer</div>
                            <div class="timeline-log-time">
                                <i class="far fa-clock mr-1"></i> {{ date('d M, Y | h:i A', strtotime($order->created_at)) }}
                                <span class="badge badge-light border ml-1">IP: {{ $order->ip_address ?? request()->ip() ?? '103.145.132.89' }}</span>
                            </div>
                        </div>
                        <div class="timeline-log-item info">
                            <div class="timeline-log-title">Payment Method Registered: {{ $order->payment_method ?? 'COD' }}</div>
                            <div class="timeline-log-time">
                                <i class="far fa-credit-card mr-1"></i> Status: {{ $order->pay_staus == 1 ? 'Paid' : 'Unpaid (COD)' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="timeline-log-list">
                        <div class="timeline-log-item {{ $order->status == 3 ? 'success' : ($order->status == 2 ? 'danger' : 'warning') }}">
                            <div class="timeline-log-title">
                                Current Lifecycle Status: 
                                @if($order->status == 0) Pending
                                @elseif($order->status == 1) Approved / Confirmed
                                @elseif($order->status == 4) Shipping / In Transit
                                @elseif($order->status == 3) Delivered
                                @elseif($order->status == 2) Cancelled
                                @elseif($order->status == 9) Sended to Courier
                                @endif
                            </div>
                            <div class="timeline-log-time">
                                <i class="fas fa-sync-alt mr-1"></i> Last Updated: {{ date('d M, Y | h:i A', strtotime($order->updated_at)) }}
                            </div>
                        </div>
                        <div class="timeline-log-item purple">
                            <div class="timeline-log-title">Managed by Admin: {{ auth()->user()->name ?? 'Store Admin' }}</div>
                            <div class="timeline-log-time">
                                <i class="fas fa-shield-alt mr-1"></i> Admin Panel Authorization Verified
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Order Products & Items Table -->
    <div class="info-card">
        <div class="card-header">
            <h5><i class="fas fa-boxes text-success"></i> Ordered Products & Items ({{ $order->orderDetails ? $order->orderDetails->count() : 0 }})</h5>
            <a href="{{ routeHelper('order/print/' . $order->id) }}" target="_blank" class="btn btn-xs btn-outline-secondary font-weight-bold">
                <i class="fas fa-print mr-1"></i> Print Receipt
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;" class="text-center">#</th>
                            <th style="width: 80px;">Image</th>
                            <th>Product Title</th>
                            <th>Attributes / Size</th>
                            <th>Color</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->orderDetails as $key => $item)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $key + 1 }}</td>
                            <td>
                                @if(isset($item->product->image) && file_exists(public_path('uploads/product/' . $item->product->image)))
                                    <img src="{{ asset('uploads/product/' . $item->product->image) }}" alt="Product" class="product-thumb">
                                @elseif(isset($item->product->images) && $item->product->images->count() > 0)
                                    <img src="{{ asset('uploads/product/' . $item->product->images->first()->image) }}" alt="Product" class="product-thumb">
                                @else
                                    <img src="{{ asset('assets/frontend/images/no-image.png') }}" onerror="this.src='https://via.placeholder.com/50?text=Product'" alt="Product" class="product-thumb">
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">
                                    @if($item->product)
                                        <a href="{{ route('admin.product.show', $item->product->id) }}" class="text-dark" target="_blank">
                                            {{ $item->title ?? $item->product->title }}
                                        </a>
                                    @else
                                        {{ $item->title }}
                                    @endif
                                </div>
                                @if($item->product && $item->product->sku)
                                    <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $sizeVal = $item->size;
                                    $decoded = json_decode($item->size, true);
                                    if (is_array($decoded)) {
                                        $sizeVal = implode(', ', array_filter($decoded));
                                    }
                                @endphp
                                @if(!empty($sizeVal) && $sizeVal != 'null' && $sizeVal != '""')
                                    <span class="badge badge-light border">{{ $sizeVal }}</span>
                                @else
                                    <span class="text-muted font-italic">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($item->color) && $item->color != 'blank' && $item->color != 'null')
                                    <span class="badge badge-light border">{{ $item->color }}</span>
                                @else
                                    <span class="text-muted font-italic">N/A</span>
                                @endif
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->qty }}</td>
                            <td class="text-right font-weight-bold text-dark">৳ {{ number_format($item->price, 2) }}</td>
                            <td class="text-right font-weight-bold text-primary">৳ {{ number_format($item->total_price ?? ($item->price * $item->qty), 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block text-gray"></i>
                                No ordered products found for this order.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="6" class="text-right font-weight-bold">Subtotal:</td>
                            <td colspan="2" class="text-right font-weight-bold text-dark">৳ {{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr class="bg-light">
                            <td colspan="6" class="text-right font-weight-bold">Shipping Delivery Fee:</td>
                            <td colspan="2" class="text-right font-weight-bold text-dark">৳ {{ number_format($order->shipping_charge ?? 0, 2) }}</td>
                        </tr>
                        @if(!empty($order->discount) && $order->discount > 0)
                        <tr class="bg-light">
                            <td colspan="6" class="text-right font-weight-bold">Coupon Discount:</td>
                            <td colspan="2" class="text-right font-weight-bold text-danger">- ৳ {{ number_format($order->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="bg-light">
                            <td colspan="6" class="text-right font-weight-bold" style="font-size: 15px;">Grand Total:</td>
                            <td colspan="2" class="text-right font-weight-bold text-primary" style="font-size: 16px;">৳ {{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal: Courier Entry / Send to Courier -->
<div class="modal fade" id="courierEntryModal" tabindex="-1" role="dialog" aria-labelledby="courierEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header bg-primary text-white" style="padding: 16px 20px;">
                <h5 class="modal-title font-weight-bold" id="courierEntryModalLabel">
                    <i class="fas fa-shipping-fast mr-2"></i> Courier Entry & Dispatch
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.setting.courier.sendsteedfast') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="invoice" value="{{ $order->invoice ?? $order->id }}">
                    
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">RECIPIENT NAME <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="recipient_name" value="{{ $order->first_name }} {{ $order->last_name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">RECIPIENT PHONE <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="recipient_phone" value="{{ preg_replace('/[^0-9]/', '', $order->phone) }}" required maxlength="11">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">DELIVERY ADDRESS <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="recipient_address" rows="2" required>{{ $order->address }}, {{ $order->town ?? '' }}{{ $order->district ? ', ' . $order->district : '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">COD AMOUNT (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="cod_amount" value="{{ $order->pay_staus == 1 ? '0.00' : $order->total }}" required>
                        <small class="text-muted">Enter 0 if the customer has already paid.</small>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-muted">DELIVERY NOTE</label>
                        <input type="text" class="form-control" name="note" value="Handle with care" placeholder="Special delivery note...">
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-light border" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">
                        <i class="fas fa-paper-plane mr-1"></i> Send to Courier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Refund -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
            <div class="modal-header bg-warning text-dark" style="padding: 16px 20px;">
                <h5 class="modal-title font-weight-bold" id="refundModalLabel">
                    <i class="fas fa-undo mr-2"></i> Process Customer Refund
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.refund') }}">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="order" value="{{ $order->id }}">
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">REFUND AMOUNT (৳) <span class="text-danger">*</span></label>
                        <input class="form-control" type="number" step="0.01" name="amount" value="{{ $order->total }}" placeholder="Enter amount" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-muted">REFUND METHOD <span class="text-danger">*</span></label>
                        <select class="form-control" name="method" required>
                            <option value="Bkash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                            <option value="Bank">Bank Transfer</option>
                            <option value="Cash">Cash</option>
                            <option value="wallate">User Wallet</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning font-weight-bold px-4">
                        <i class="fas fa-check mr-1"></i> Submit Refund
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
