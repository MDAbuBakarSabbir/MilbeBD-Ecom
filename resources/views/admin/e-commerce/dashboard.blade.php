@extends('layouts.admin.e-commerce.app')

@section('title', 'Admin Dashboard')

@push('css')
<style>
    :root {
        --dash-primary: #108b3a;
        --dash-primary-dark: #0b6329;
        --dash-secondary: #002f5f;
        --dash-info: #17a2b8;
        --dash-warning: #ffc107;
        --dash-danger: #dc3545;
        --dash-success: #28a745;
        --dash-purple: #6f42c1;
    }

    .dashboard-header {
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
        gap: 15px;
    }

    .dashboard-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .dashboard-title p {
        font-size: 13px;
        color: #718096;
        margin: 4px 0 0 0;
    }

    .quick-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .quick-btn {
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .quick-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #edf2f7;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .stat-card .stat-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ffffff;
    }

    .stat-card .stat-number {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin: 12px 0 4px 0;
        line-height: 1.2;
    }

    .stat-card .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .stat-card .stat-footer {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: #4a5568;
    }

    .stat-card .stat-footer a {
        color: var(--dash-primary);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-card .stat-footer a:hover {
        color: var(--dash-primary-dark);
        text-decoration: underline !important;
    }

    /* Gradients */
    .bg-grad-primary { background: linear-gradient(135deg, #108b3a 0%, #00aa3a 100%); }
    .bg-grad-blue { background: linear-gradient(135deg, #002f5f 0%, #0d6efd 100%); }
    .bg-grad-info { background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%); }
    .bg-grad-warning { background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); }
    .bg-grad-danger { background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); }
    .bg-grad-success { background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%); }
    .bg-grad-purple { background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); }

    /* Pipeline Mini Cards */
    .pipeline-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .pipeline-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    }

    .pipeline-card .p-info h4 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
        color: #1a202c;
    }

    .pipeline-card .p-info p {
        font-size: 13px;
        font-weight: 600;
        margin: 2px 0 0 0;
        color: #718096;
    }

    .pipeline-card .p-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Content Cards */
    .dashboard-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #edf2f7;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .dashboard-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafbfc;
    }

    .dashboard-card-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dashboard-card-body {
        padding: 20px;
    }

    /* Badges */
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .badge-soft-info { background-color: #e0f2fe; color: #075985; }
    .badge-soft-success { background-color: #dcfce7; color: #166534; }
    .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-soft-purple { background-color: #f3e8ff; color: #6b21a8; }

    .status-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-block;
    }

    /* Alert Banner */
    .low-stock-alert {
        background: linear-gradient(135deg, #fff5f5 0%, #fee2e2 100%);
        border: 1px solid #fecaca;
        border-left: 5px solid #dc2626;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table thead th {
        background: #f8fafc;
        color: #4a5568;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #edf2f7;
        border-top: none;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 14px;
        color: #2d3748;
        border-bottom: 1px solid #f1f5f9;
    }
</style>
@endpush

@section('content')

<!-- Main Container -->
<div class="container-fluid pt-3 pb-4">

    <!-- Top Dashboard Header -->
    <div class="dashboard-header">
        <div class="dashboard-title">
            <h1><i class="fas fa-chart-pie text-success mr-2"></i> E-Commerce Overview</h1>
            <p>Welcome back, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong> | {{ date('l, F j, Y') }}</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('admin.product.create') }}" class="btn btn-success quick-btn">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
            <a href="{{ route('admin.order.index') }}" class="btn btn-outline-primary quick-btn">
                <i class="fas fa-shopping-bag"></i> Orders
            </a>
            <a href="{{ route('admin.vendor.index') }}" class="btn btn-outline-info quick-btn">
                <i class="fas fa-store"></i> Vendors
            </a>
            <a href="{{ route('admin.setting.index') }}" class="btn btn-outline-secondary quick-btn">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
    </div>

    <!-- Low Stock Alert Banner -->
    @if($low_products > 0)
    <div class="low-stock-alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle text-danger fa-2x mr-3"></i>
            <div>
                <strong class="text-danger font-weight-bold" style="font-size: 15px;">Low Stock Warning!</strong>
                <p class="mb-0 text-muted" style="font-size: 13px;">You have <strong>{{ $low_products }}</strong> products with quantity less than 6 units in inventory.</p>
            </div>
        </div>
        <a href="{{ route('admin.low.product') }}" class="btn btn-danger btn-sm px-3 font-weight-bold" style="border-radius: 6px;">
            <i class="fas fa-box-open mr-1"></i> Review Low Stock Products
        </a>
    </div>
    @endif

    <!-- Main KPI Cards Row -->
    <div class="row">
        <!-- Total Orders -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Total Orders</p>
                        <h3 class="stat-number">{{ number_format($orders) }}</h3>
                    </div>
                    <div class="stat-icon-box bg-grad-blue">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <span><i class="fas fa-clock text-warning"></i> {{ $pending_orders }} Pending</span>
                    <a href="{{ route('admin.order.index') }}">View All <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Total Catalog</p>
                        <h3 class="stat-number">{{ number_format($products) }}</h3>
                    </div>
                    <div class="stat-icon-box bg-grad-primary">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <span><i class="fas fa-cubes text-info"></i> {{ number_format($quantity) }} In Stock Qty</span>
                    <a href="{{ route('admin.product.index') }}">Products <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Customers & Vendors -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Registered Users</p>
                        <h3 class="stat-number">{{ number_format($customers + $vendors) }}</h3>
                    </div>
                    <div class="stat-icon-box bg-grad-purple">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <span><i class="fas fa-user text-primary"></i> {{ $customers }} Customers | {{ $vendors }} Vendors</span>
                    <a href="{{ route('admin.customer.index') }}">Users <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Commission Earned -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Platform Commission</p>
                        <h3 class="stat-number">৳ {{ number_format($commission, 2) }}</h3>
                    </div>
                    <div class="stat-icon-box bg-grad-success">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <span><i class="fas fa-store text-success"></i> Store Earnings</span>
                    <a href="{{ route('admin.comission') }}">Commissions <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Lifecycle Pipeline -->
    <div class="row">
        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.order.pending') }}" class="text-decoration-none">
                <div class="pipeline-card" style="border-left: 4px solid #f59e0b;">
                    <div class="p-info">
                        <h4>{{ $pending_orders }}</h4>
                        <p>Pending Orders</p>
                    </div>
                    <div class="p-icon badge-soft-warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Processing Orders -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.order.processing') }}" class="text-decoration-none">
                <div class="pipeline-card" style="border-left: 4px solid #0284c7;">
                    <div class="p-info">
                        <h4>{{ $processing_orders }}</h4>
                        <p>Processing Orders</p>
                    </div>
                    <div class="p-icon badge-soft-info">
                        <i class="fas fa-dolly-flatbed"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Delivered Orders -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.order.delivered') }}" class="text-decoration-none">
                <div class="pipeline-card" style="border-left: 4px solid #16a34a;">
                    <div class="p-info">
                        <h4>{{ $delivered_orders }}</h4>
                        <p>Delivered Orders</p>
                    </div>
                    <div class="p-icon badge-soft-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Cancelled Orders -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.order.cancel') }}" class="text-decoration-none">
                <div class="pipeline-card" style="border-left: 4px solid #dc2626;">
                    <div class="p-info">
                        <h4>{{ $cancel_orders }}</h4>
                        <p>Cancelled Orders</p>
                    </div>
                    <div class="p-icon badge-soft-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Financial Breakdown Cards -->
    <div class="row">
        <!-- Self / Admin Revenue -->
        <div class="col-xl-6 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-wallet text-success"></i> Direct Store Revenue</h3>
                    <span class="badge badge-soft-success">Admin Account</span>
                </div>
                <div class="dashboard-card-body">
                    <div class="row text-center">
                        <div class="col-6 border-right">
                            <p class="text-muted mb-1" style="font-size: 13px;">Cleared Amount</p>
                            <h4 class="font-weight-bold text-success mb-0">৳ {{ number_format($admin_amount, 2) }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1" style="font-size: 13px;">Pending Clearance</p>
                            <h4 class="font-weight-bold text-warning mb-0">৳ {{ number_format($pending_amount, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendor Revenue -->
        <div class="col-xl-6 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-store-alt text-primary"></i> Multi-Vendor Settlement</h3>
                    <a href="{{ route('admin.vendor.withdraw') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">Withdrawals</a>
                </div>
                <div class="dashboard-card-body">
                    <div class="row text-center">
                        <div class="col-6 border-right">
                            <p class="text-muted mb-1" style="font-size: 13px;">Vendor Balance</p>
                            <h4 class="font-weight-bold text-primary mb-0">৳ {{ number_format($vendor_amount, 2) }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1" style="font-size: 13px;">Vendor Pending</p>
                            <h4 class="font-weight-bold text-secondary mb-0">৳ {{ number_format($vendor_pamount, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Sales Trend Bar Chart -->
        <div class="col-xl-8 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-chart-bar text-primary"></i> Monthly Sales Trend (Last 6 Months)</h3>
                    <span class="badge badge-light border">Order Total (৳)</span>
                </div>
                <div class="dashboard-card-body">
                    <div style="position: relative; height: 280px; width: 100%;">
                        <canvas id="salesTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Distribution Donut Chart -->
        <div class="col-xl-4 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-chart-pie text-info"></i> Order Distribution</h3>
                </div>
                <div class="dashboard-card-body">
                    <div style="position: relative; height: 280px; width: 100%;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Inventory Tables -->
    <div class="row">
        <!-- Recent Orders Table -->
        <div class="col-xl-8 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-receipt text-success"></i> Recent Orders</h3>
                    <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-outline-success font-weight-bold" style="border-radius: 6px;">
                        View All Orders <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="dashboard-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.order.invoice', $order->id) }}" class="font-weight-bold text-primary">
                                            {{ $order->invoice ?? '#' . $order->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $order->first_name }} {{ $order->last_name }}</div>
                                        <small class="text-muted">{{ $order->phone }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border text-uppercase font-weight-normal">{{ $order->payment_method ?? 'COD' }}</span>
                                    </td>
                                    <td class="font-weight-bold text-dark">
                                        ৳ {{ number_format($order->total, 2) }}
                                    </td>
                                    <td>
                                        @if($order->status == 0)
                                            <span class="status-badge badge-soft-warning"><i class="fas fa-clock mr-1"></i> Pending</span>
                                        @elseif($order->status == 1)
                                            <span class="status-badge badge-soft-info"><i class="fas fa-spinner mr-1"></i> Processing</span>
                                        @elseif($order->status == 2)
                                            <span class="status-badge badge-soft-danger"><i class="fas fa-times-circle mr-1"></i> Cancelled</span>
                                        @elseif($order->status == 3)
                                            <span class="status-badge badge-soft-success"><i class="fas fa-check-circle mr-1"></i> Delivered</span>
                                        @else
                                            <span class="status-badge badge-soft-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="font-size: 13px;">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.order.invoice', $order->id) }}" class="btn btn-xs btn-outline-secondary" title="View Invoice" style="border-radius: 4px; padding: 4px 8px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block text-gray"></i>
                                        No recent orders found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Low Stock Alerts / Fast Nav -->
        <div class="col-xl-4 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-boxes text-danger"></i> Low Stock Alerts</h3>
                    <a href="{{ route('admin.low.product') }}" class="btn btn-sm btn-outline-danger font-weight-bold" style="border-radius: 6px;">Manage</a>
                </div>
                <div class="dashboard-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-right">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($low_stock_list as $lproduct)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-truncate" style="max-width: 180px;" title="{{ $lproduct->title ?? 'Product' }}">
                                            {{ $lproduct->title ?? 'Product' }}
                                        </div>
                                        <small class="text-muted">ID: #{{ $lproduct->id }}</small>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-danger px-2 py-1 font-weight-bold" style="font-size: 13px;">
                                            {{ $lproduct->quantity }} Left
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted">
                                        <i class="fas fa-check-circle text-success fa-2x mb-2 d-block"></i>
                                        All inventory stocks are healthy!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Links Box -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3><i class="fas fa-link text-primary"></i> Shortcuts</h3>
                </div>
                <div class="dashboard-card-body">
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('admin.slider.index') }}" class="btn btn-light text-left border mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-images text-info mr-2"></i> Manage Sliders & Banners</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
                        </a>
                        <a href="{{ route('admin.coupon.index') }}" class="btn btn-light text-left border mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-tags text-warning mr-2"></i> Discount Coupons</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
                        </a>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-light text-left border d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-sitemap text-success mr-2"></i> Category Hierarchy</span>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('js')
<script src="/assets/plugins/chart.js/Chart.bundle.min.js"></script>
<script>
    $(function () {
        'use strict';

        // 1. Monthly Sales Trend Chart
        var salesCtx = document.getElementById('salesTrendChart');
        if (salesCtx) {
            var monthlyLabels = {!! json_encode($monthly_labels) !!};
            var monthlySalesData = {!! json_encode($monthly_sales) !!};

            new Chart(salesCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Sales Revenue (৳)',
                        data: monthlySalesData,
                        backgroundColor: 'rgba(16, 139, 58, 0.75)',
                        borderColor: '#108b3a',
                        borderWidth: 1.5,
                        borderRadius: 6,
                        hoverBackgroundColor: '#0b6329'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return '৳ ' + Number(value).toLocaleString();
                                }
                            },
                            gridLines: {
                                color: '#edf2f7',
                                zeroLineColor: '#cbd5e1'
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return 'Sales: ৳ ' + Number(tooltipItem.yLabel).toLocaleString();
                            }
                        }
                    }
                }
            });
        }

        // 2. Order Status Doughnut Chart
        var orderCtx = document.getElementById('orderStatusChart');
        if (orderCtx) {
            new Chart(orderCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Delivered', 'Processing', 'Pending', 'Cancelled'],
                    datasets: [{
                        data: [
                            {{ $delivered_orders }},
                            {{ $processing_orders }},
                            {{ $pending_orders }},
                            {{ $cancel_orders }}
                        ],
                        backgroundColor: [
                            '#16a34a',
                            '#0284c7',
                            '#f59e0b',
                            '#dc2626'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 68,
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            fontSize: 12,
                            padding: 14
                        }
                    }
                }
            });
        }
    });
</script>
@endpush