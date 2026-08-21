@extends('layouts.admin.e-commerce.app')

@section('title', 'Order List')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        :root {
            --primary: #108b3a;
            --primary-dark: #0b6329;
            --secondary: #002f5f;
            --info: #0284c7;
            --warning: #f59e0b;
            --danger: #dc2626;
            --success: #16a34a;
        }

        .page-header-box {
            background: #ffffff;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            border: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-header-box h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .filter-sort-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #edf2f7;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .filter-sort-card .card-header {
            background: #f8fafc;
            border-bottom: 1px solid #edf2f7;
            padding: 12px 20px;
            font-weight: 700;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-pill-list {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .status-pill-item {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            text-decoration: none !important;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
        }

        .status-pill-item:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .status-pill-item.active {
            background: #108b3a;
            color: #ffffff;
            border-color: #108b3a;
        }

        .status-pill-item .badge {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .orders-main-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #edf2f7;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .orders-main-card .card-header {
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            padding: 16px 20px;
        }

        /* Modern Exact Table Header Styling */
        #example1 thead th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            border-top: none;
            vertical-align: middle;
            padding: 12px 14px;
        }

        #example1 tbody td {
            vertical-align: middle;
            font-size: 13px;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            padding: 14px;
            background: #ffffff;
        }

        #example1 tbody tr:hover td {
            background-color: #fafbfc;
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ede9fe;
            color: #7c3aed;
            font-weight: 700;
            font-size: 12.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Product Thumb Box */
        .product-thumb-box {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            overflow: hidden;
            background: #0f172a;
            flex-shrink: 0;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-meta-pill {
            font-size: 10.5px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 1px 6px;
            color: #475569;
            font-weight: 500;
        }

        /* Invoice & Courier Badges */
        .invoice-box-badge, .courier-box-badge {
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 3px 8px;
            font-size: 11.5px;
            color: #334155;
            white-space: nowrap;
        }

        /* Custom Status Pill Badges */
        .custom-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-dot {
            font-size: 9px;
            line-height: 1;
        }

        .status-pending { background-color: #fef3c7; color: #d97706; }
        .status-processing { background-color: #e0e7ff; color: #4338ca; }
        .status-delivered { background-color: #dcfce7; color: #15803d; }
        .status-shipping { background-color: #e0f2fe; color: #0369a1; }
        .status-cancel { background-color: #fee2e2; color: #b91c1c; }
        .status-return { background-color: #ffedd5; color: #c2410c; }
        .status-refund { background-color: #f1f5f9; color: #475569; }
        .status-courier { background-color: #f3e8ff; color: #7e22ce; }
        .status-default { background-color: #f1f5f9; color: #64748b; }

        /* 3-Dots Action Button */
        .action-kebab-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            padding: 0;
        }

        .action-kebab-btn:hover, .action-kebab-btn:focus {
            background: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
        }

        .action-dropdown .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            min-width: 210px;
            padding: 6px;
            z-index: 1050;
        }

        .action-dropdown .dropdown-item {
            font-size: 12.5px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .action-dropdown .dropdown-item:hover {
            background-color: #f1f5f9;
        }

        .action-dropdown .dropdown-item.text-danger:hover {
            background-color: #fee2e2;
        }

        .action-dropdown .dropdown-item.text-success:hover {
            background-color: #dcfce7;
        }

        .action-dropdown .dropdown-item.text-primary:hover {
            background-color: #e0e7ff;
        }

        .bulk-selected-bar {
            display: none;
            background: #1e293b;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            align-items: center;
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')

<!-- Content Header -->
<div class="container-fluid pt-3">
    <div class="page-header-box">
        <div>
            <h1><i class="fas fa-shopping-bag text-success mr-2"></i> Order List</h1>
            <small class="text-muted">Manage, track, and process customer orders</small>
        </div>
        <div>
            <ol class="breadcrumb bg-transparent p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ routeHelper('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Order List</li>
            </ol>
        </div>
    </div>
</div>

<!-- Sort & Filter Card -->
<div class="container-fluid">
    <div class="filter-sort-card">
        <div class="card-header cursor-pointer" data-toggle="collapse" data-target="#sortFilterBody">
            <span class="d-flex align-items-center">
                <i class="fas fa-filter text-primary mr-2"></i> Sort & Filter
            </span>
            <i class="fas fa-chevron-down text-muted"></i>
        </div>
        <div class="card-body collapse show" id="sortFilterBody">
            <!-- Quick Status Pills -->
            <div class="status-pill-list">
                <a href="{{ route('admin.order.index', ['status' => 'all']) }}" class="status-pill-item {{ request('status') == 'all' || !request('status') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> All Orders
                    <span class="badge badge-light border">{{ $counts['all'] ?? count($orders) }}</span>
                </a>
                <a href="{{ route('admin.order.index', ['status' => '0']) }}" class="status-pill-item {{ request('status') === '0' ? 'active' : '' }}">
                    <i class="fas fa-clock text-warning"></i> Pending
                    <span class="badge badge-warning">{{ $counts['pending'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.order.index', ['status' => 1]) }}" class="status-pill-item {{ request('status') == 1 ? 'active' : '' }}">
                    <i class="fas fa-spinner text-info"></i> Confirmed
                    <span class="badge badge-info">{{ $counts['processing'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.order.index', ['status' => 4]) }}" class="status-pill-item {{ request('status') == 4 ? 'active' : '' }}">
                    <i class="fas fa-shipping-fast text-primary"></i> Shipping
                    <span class="badge badge-primary">{{ $counts['shipping'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.order.index', ['status' => 3]) }}" class="status-pill-item {{ request('status') == 3 ? 'active' : '' }}">
                    <i class="fas fa-check-circle text-success"></i> Delivered
                    <span class="badge badge-success">{{ $counts['delivered'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.order.index', ['status' => 2]) }}" class="status-pill-item {{ request('status') == 2 ? 'active' : '' }}">
                    <i class="fas fa-times-circle text-danger"></i> Cancelled
                    <span class="badge badge-danger">{{ $counts['cancel'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.order.index', ['status' => 'return']) }}" class="status-pill-item {{ request('status') == 'return' ? 'active' : '' }}">
                    <i class="fas fa-undo text-warning"></i> Returned
                    <span class="badge badge-warning">{{ $counts['return'] ?? 0 }}</span>
                </a>
            </div>

            <!-- Filter Inputs Form -->
            <form action="{{ route('admin.order.index') }}" method="GET" class="border-top pt-3">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">STATUS</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Order Confirm / Processing</option>
                            <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>Shipping / Packaging</option>
                            <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Delivered</option>
                            <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Cancelled</option>
                            <option value="return" {{ request('status') == 'return' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">PAYMENT</label>
                        <select name="pay_status" class="form-control form-control-sm">
                            <option value="">All Payment</option>
                            <option value="1" {{ request('pay_status') === '1' ? 'selected' : '' }}>Paid</option>
                            <option value="0" {{ request('pay_status') === '0' ? 'selected' : '' }}>Due / Unpaid</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">FROM DATE</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">TO DATE</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-2">
                    <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-light border mr-2">Reset</a>
                    <button type="submit" class="btn btn-sm btn-success px-3">
                        <i class="fas fa-search mr-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Selected Bar -->
    <div class="bulk-selected-bar" id="bulkBar">
        <div>
            <i class="fas fa-check-circle text-success mr-2"></i>
            <span id="bulkCount" class="font-weight-bold">0</span> Orders Selected
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-outline-light mr-2" id="bulkPrintBtn">
                <i class="fas fa-print mr-1"></i> Print Selected
            </button>
            <button type="button" class="btn btn-sm btn-danger" id="deselectBtn">Deselect</button>
        </div>
    </div>
</div>

<!-- Main Table Section (Exact Match with Image Design) -->
<section class="content pb-4">
    <div class="container-fluid">
        <div class="orders-main-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="example1" class="table table-hover mb-0 w-100">
                        <thead>
                            <tr>
                                <th style="width: 35px;" class="text-center">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>CUSTOMER</th>
                                <th>COURIER HISTORY</th>
                                <th>PRODUCT</th>
                                <th>INVOICE ID</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                                <th>COMMENT</th>
                                <th class="text-center" style="width: 50px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $data)
                                <tr>
                                    <!-- 1. Checkbox -->
                                    <td class="text-center">
                                        <input type="checkbox" class="order-check" value="{{ $data->id }}" data-print-url="{{ route('admin.order.print', $data->id) }}">
                                    </td>

                                    <!-- 2. CUSTOMER -->
                                    <td>
                                        <div class="d-flex align-items-start" style="gap: 10px;">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($data->first_name ?? 'C', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark" style="font-size: 13.5px;">
                                                    {{ $data->first_name }} {{ $data->last_name }}
                                                </div>
                                                <div class="text-muted" style="font-size: 12px; margin-top: 2px;">
                                                    <i class="fas fa-phone-alt mr-1" style="font-size: 10.5px; opacity: 0.7;"></i>
                                                    <a href="tel:{{ $data->phone }}" class="text-muted">{{ $data->phone }}</a>
                                                </div>
                                                @if($data->address || $data->town || $data->district)
                                                <div class="text-muted text-truncate" style="font-size: 11.5px; max-width: 170px; margin-top: 2px;" title="{{ $data->address }}, {{ $data->town ?? '' }}, {{ $data->district ?? '' }}">
                                                    <i class="fas fa-map-marker-alt mr-1" style="font-size: 10.5px; opacity: 0.7;"></i>
                                                    {{ $data->address ? $data->address : ($data->town ? $data->town . ', ' . $data->district : 'N/A') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 3. COURIER HISTORY -->
                                    <td class="text-muted font-italic" style="font-size: 12.5px;">
                                        {{ $data->courier_history ?? 'N/A' }}
                                    </td>

                                    <!-- 4. PRODUCT -->
                                    <td>
                                        @if($data->orderDetails && $data->orderDetails->count() > 0)
                                            @foreach($data->orderDetails as $item)
                                            <div class="d-flex align-items-center mb-1" style="gap: 10px;">
                                                <div class="product-thumb-box">
                                                    @if(isset($item->product->image) && file_exists(public_path('uploads/product/' . $item->product->image)))
                                                        <img src="{{ asset('uploads/product/' . $item->product->image) }}" alt="Product" class="product-thumb-img">
                                                    @elseif(isset($item->product->images) && $item->product->images->count() > 0)
                                                        <img src="{{ asset('uploads/product/' . $item->product->images->first()->image) }}" alt="Product" class="product-thumb-img">
                                                    @else
                                                        <img src="{{ asset('assets/frontend/images/no-image.png') }}" onerror="this.src='https://via.placeholder.com/44?text=Product'" alt="Product" class="product-thumb-img">
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold text-dark" style="font-size: 12.5px; line-height: 1.3; max-width: 220px;">
                                                        {{ $item->title ?? ($item->product->title ?? 'Product') }}
                                                    </div>
                                                    <div class="d-flex align-items-center flex-wrap mt-1" style="gap: 4px;">
                                                        <span class="product-meta-pill">Qty: {{ $item->qty }}</span>
                                                        @if(!empty($item->size))
                                                            @php
                                                                $sizeVal = $item->size;
                                                                $decoded = json_decode($item->size, true);
                                                                if (is_array($decoded)) {
                                                                    $sizeVal = implode(', ', array_filter($decoded));
                                                                }
                                                            @endphp
                                                            @if(!empty($sizeVal) && $sizeVal != 'null')
                                                                <span class="product-meta-pill">Size: {{ $sizeVal }}</span>
                                                            @endif
                                                        @endif
                                                        @if(!empty($item->color) && $item->color != 'null')
                                                            <span class="product-meta-pill">Color: {{ $item->color }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted font-italic">N/A</span>
                                        @endif
                                    </td>

                                    <!-- 5. INVOICE ID -->
                                    <td>
                                        <div class="d-flex flex-column" style="gap: 6px;">
                                            <span class="invoice-box-badge">
                                                Invoice: <strong>{{ $data->invoice ?? '#' . $data->id }}</strong>
                                            </span>
                                            <span class="courier-box-badge">
                                                Courier: <strong>{{ $data->shipping_method ?? 'N/A' }}</strong>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- 6. AMOUNT -->
                                    <td>
                                        <div style="font-size: 12.5px; line-height: 1.6; min-width: 90px;">
                                            <div class="d-flex justify-content-between" style="gap: 12px;">
                                                <span class="text-muted">Total:</span>
                                                <strong class="text-dark">{{ number_format($data->total ?? $data->subtotal, 0) }} ৳</strong>
                                            </div>
                                            <div class="d-flex justify-content-between" style="gap: 12px;">
                                                <span class="text-muted">Paid:</span>
                                                <strong class="text-success">{{ $data->pay_staus == 1 ? number_format($data->total, 0) : '0' }} ৳</strong>
                                            </div>
                                            <div class="d-flex justify-content-between" style="gap: 12px;">
                                                <span class="text-muted">Due:</span>
                                                <strong class="text-danger">{{ $data->pay_staus == 1 ? '0' : number_format($data->total, 0) }} ৳</strong>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 7. STATUS -->
                                    <td>
                                        <div>
                                            @if ($data->status == 0)
                                                <span class="custom-status-pill status-pending"><span class="status-dot">●</span> PENDING</span>
                                            @elseif ($data->status == 1)
                                                <span class="custom-status-pill status-processing"><span class="status-dot">●</span> CONFIRMED</span>
                                            @elseif ($data->status == 2)
                                                <span class="custom-status-pill status-cancel"><span class="status-dot">●</span> CANCELLED</span>
                                            @elseif ($data->status == 3)
                                                <span class="custom-status-pill status-delivered"><span class="status-dot">●</span> DELIVERED</span>
                                            @elseif ($data->status == 4)
                                                <span class="custom-status-pill status-shipping"><span class="status-dot">●</span> SHIPPING</span>
                                            @elseif ($data->status == 5)
                                                <span class="custom-status-pill status-refund"><span class="status-dot">●</span> REFUNDED</span>
                                            @elseif (in_array($data->status, [6, 7, 8]))
                                                <span class="custom-status-pill status-return"><span class="status-dot">●</span> RETURNED</span>
                                            @elseif ($data->status == 9)
                                                <span class="custom-status-pill status-courier"><span class="status-dot">●</span> IN COURIER</span>
                                            @else
                                                <span class="custom-status-pill status-default"><span class="status-dot">●</span> UNKNOWN</span>
                                            @endif

                                            <div class="mt-1" style="font-size: 11px; color: #64748b; line-height: 1.45;">
                                                <div><i class="far fa-calendar-alt mr-1"></i> Created: {{ date('d M, Y | h:i A', strtotime($data->created_at)) }}</div>
                                                <div><i class="far fa-calendar-check mr-1"></i> Updated: {{ date('d M, Y | h:i A', strtotime($data->updated_at)) }}</div>
                                                <div style="color: #6366f1;">
                                                    <i class="fas fa-user mr-1"></i> By: {{ $data->user ? $data->user->name : 'Customer' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 8. COMMENT -->
                                    <td class="text-muted font-italic" style="font-size: 12.5px;">
                                        {{ $data->note ?? ($data->comment ?? 'N/A') }}
                                    </td>

                                    <!-- 9. ACTION (3-Dots Kebab Button) -->
                                    <td class="text-center">
                                        <div class="dropdown action-dropdown d-inline-block">
                                            <button type="button" class="action-kebab-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                <!-- View -->
                                                <a class="dropdown-item text-info font-weight-500" href="{{ route('admin.order.show', $data->id) }}">
                                                    <i class="fas fa-eye fa-fw mr-2"></i> View Details
                                                </a>

                                                <!-- Invoice -->
                                                <a class="dropdown-item text-secondary font-weight-500" href="{{ route('admin.order.print', $data->id) }}" target="_blank">
                                                    <i class="fas fa-print fa-fw mr-2"></i> Print Invoice
                                                </a>

                                                <div class="dropdown-divider my-1"></div>

                                                <div class="dropdown-header text-uppercase font-weight-bold text-muted px-2 py-1" style="font-size: 10px; letter-spacing: 0.6px;">
                                                    <i class="fas fa-exchange-alt mr-1"></i> Change Status
                                                </div>

                                                <!-- Approved / Confirm -->
                                                @if($data->status != 1)
                                                <a class="dropdown-item text-primary" href="{{ route('admin.order.status.processing', $data->id) }}" onclick="return confirm('Confirm order to Approved / Processing?')">
                                                    <i class="fas fa-check-circle fa-fw text-primary mr-2"></i> Approved / Confirm
                                                </a>
                                                @endif

                                                <!-- Packaging / Shipping -->
                                                @if($data->status != 4)
                                                <a class="dropdown-item text-warning" href="{{ route('admin.order.status.shipping', $data->id) }}" onclick="return confirm('Change status to Packaging / Shipping?')">
                                                    <i class="fas fa-box fa-fw text-warning mr-2"></i> Packaging / Shipping
                                                </a>
                                                @endif

                                                <!-- In Courier -->
                                                @if($data->status != 9)
                                                <a class="dropdown-item text-info" href="{{ route('admin.order.status.shipping', $data->id) }}">
                                                    <i class="fas fa-truck fa-fw text-info mr-2"></i> In Courier
                                                </a>
                                                @endif

                                                <!-- Delivered -->
                                                @if($data->status != 3)
                                                <a class="dropdown-item text-success" href="{{ route('admin.order.status.delivered', $data->id) }}" onclick="return confirm('Mark this order as Delivered?')">
                                                    <i class="fas fa-thumbs-up fa-fw text-success mr-2"></i> Delivered
                                                </a>
                                                @endif

                                                <!-- Cancel -->
                                                @if($data->status != 2)
                                                <a class="dropdown-item text-danger" href="{{ route('admin.order.status.cancel', $data->id) }}" onclick="return confirm('Cancel this order?')">
                                                    <i class="fas fa-times-circle fa-fw text-danger mr-2"></i> Cancel Order
                                                </a>
                                                @endif

                                                <!-- Return -->
                                                <a class="dropdown-item text-secondary" href="{{ route('admin.order.status.returnAccept', $data->id) }}" onclick="return confirm('Accept return request?')">
                                                    <i class="fas fa-undo fa-fw text-warning mr-2"></i> Accept Return
                                                </a>

                                                <div class="dropdown-divider my-1"></div>

                                                <div class="dropdown-header text-uppercase font-weight-bold text-muted px-2 py-1" style="font-size: 10px; letter-spacing: 0.6px;">
                                                    <i class="fas fa-money-bill mr-1"></i> Payment
                                                </div>

                                                <!-- Toggle Paid / Unpaid -->
                                                <a class="dropdown-item text-dark" href="{{ route('admin.order.pay', $data->id) }}">
                                                    <i class="fas fa-money-check-alt fa-fw text-success mr-2"></i> Mark as {{ $data->pay_staus == 1 ? 'Unpaid' : 'Paid' }}
                                                </a>

                                                <div class="dropdown-divider my-1"></div>

                                                <!-- Delete -->
                                                <a class="dropdown-item text-danger" href="{{ route('admin.order.delete', $data->id) }}" onclick="return confirm('Are you sure you want to permanently delete this order?')">
                                                    <i class="fas fa-trash-alt fa-fw text-danger mr-2"></i> Delete Order
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->    
    </div>
</section>
<!-- /.content -->

@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/plugins/jszip/jszip.min.js"></script>
    <script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function () { 
            var table = $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "pageLength": 25,
                "order": [],
                "columnDefs": [
                    { "orderable": false, "targets": [0, 8] }
                ],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "language": {
                    "info": "Showing _START_ – _END_ of _TOTAL_ orders"
                }
            });
            
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Check All checkbox
            $('#checkAll').on('change', function () {
                var checked = $(this).is(':checked');
                $('.order-check').prop('checked', checked);
                updateBulk();
            });

            $(document).on('change', '.order-check', function () {
                var total = $('.order-check').length;
                var checked = $('.order-check:checked').length;
                $('#checkAll').prop('checked', total === checked);
                updateBulk();
            });

            $('#deselectBtn').on('click', function () {
                $('.order-check, #checkAll').prop('checked', false);
                updateBulk();
            });

            function updateBulk() {
                var count = $('.order-check:checked').length;
                if (count > 0) {
                    $('#bulkCount').text(count);
                    $('#bulkBar').css('display', 'flex');
                } else {
                    $('#bulkBar').hide();
                }
            }

            $('#bulkPrintBtn').on('click', function () {
                $('.order-check:checked').each(function () {
                    var url = $(this).data('print-url');
                    if (url) {
                        window.open(url, '_blank');
                    }
                });
            });
        });
    </script>
@endpush