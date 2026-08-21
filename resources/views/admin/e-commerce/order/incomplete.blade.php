@extends('layouts.admin.e-commerce.app')

@section('title', 'Incomplete Order List')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        :root {
            --primary: #108b3a;
            --warning: #f59e0b;
            --danger: #dc2626;
            --info: #0284c7;
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

        /* Stat Metric Cards */
        .metric-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #edf2f7;
            padding: 16px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
        }

        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .metric-info h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.2;
        }

        .metric-info p {
            font-size: 12px;
            color: #64748b;
            margin: 2px 0 0 0;
            font-weight: 500;
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

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fef3c7;
            color: #d97706;
            font-weight: 700;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

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

        .status-pill-incomplete {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #fef3c7;
            color: #b45309;
        }

        .bulk-selected-bar {
            display: none;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.18);
            border: 1px solid #334155;
            flex-wrap: wrap;
            gap: 12px;
        }
    </style>
@endpush

@section('content')

<!-- Header Section -->
<div class="container-fluid pt-3">
    <div class="page-header-box">
        <div>
            <h1><i class="fas fa-shopping-basket text-warning mr-2"></i> Incomplete Order List</h1>
            <small class="text-muted">Follow up and recover abandoned customer carts and unfinished checkouts</small>
        </div>
        <div>
            <ol class="breadcrumb bg-transparent p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ routeHelper('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ routeHelper('order') }}">Orders</a></li>
                <li class="breadcrumb-item active">Incomplete Orders</li>
            </ol>
        </div>
    </div>

    <!-- Quick Analytics Stats -->
    @php
        $totalIncomplete = count($orders);
        $totalValue = $orders->sum('total') > 0 ? $orders->sum('total') : $orders->sum('subtotal');
        $withPhone = $orders->filter(function($o) { return !empty($o->phone); })->count();
        $todayCount = $orders->filter(function($o) { return date('Y-m-d', strtotime($o->created_at)) === date('Y-m-d'); })->count();
    @endphp

    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-warning text-white">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $totalIncomplete }}</h3>
                    <p>Total Incomplete Orders</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-danger text-white">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="metric-info">
                    <h3>৳ {{ number_format($totalValue, 0) }}</h3>
                    <p>Recoverable Value</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-success text-white">
                    <i class="fas fa-phone-volume"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $withPhone }}</h3>
                    <p>Phone Ready for Follow-up</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-info text-white">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $todayCount }}</h3>
                    <p>Incomplete Today</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Selected & Action Bar -->
    <div class="bulk-selected-bar" id="bulkBar">
        <div class="d-flex align-items-center flex-wrap" style="gap: 14px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-success mr-2 fa-lg"></i>
                <span id="bulkCount" class="badge badge-success px-2 py-1 mr-1" style="font-size: 13px;">0</span>
                <span class="font-weight-bold">Selected</span>
            </div>

            <!-- Bulk Status Form -->
            <form id="bulkActionForm" action="{{ route('admin.order.bulkStatusUpdate') }}" method="POST" class="d-inline-flex align-items-center flex-wrap" style="gap: 8px; margin: 0;">
                @csrf
                <div id="bulkHiddenIds"></div>
                <div class="input-group input-group-sm" style="width: auto;">
                    <select name="status" id="bulkStatusSelect" class="form-control form-control-sm" required style="border-radius: 6px 0 0 6px; font-weight: 600; min-width: 190px; background-color: #ffffff; color: #1e293b;">
                        <option value="" disabled selected>-- Action on Selected --</option>
                        <option value="0">⏳ Move to Pending Orders</option>
                        <option value="1">✔️ Convert & Confirm Order</option>
                        <option value="2">❌ Mark as Cancelled</option>
                        <option value="delete" class="text-danger">🗑️ Delete Selected</option>
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-success font-weight-bold px-3" style="border-radius: 0 6px 6px 0;">
                            <i class="fas fa-check mr-1"></i> Apply
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <button type="button" class="btn btn-sm btn-light border font-weight-bold text-dark" id="deselectBtn">
                <i class="fas fa-times mr-1"></i> Deselect
            </button>
        </div>
    </div>
</div>

<!-- Main Table Section (6 Columns) -->
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
                                <th>PRODUCT</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                                <th class="text-center" style="width: 140px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $key => $data)
                                <tr>
                                    <!-- 1. Checkbox -->
                                    <td class="text-center">
                                        <input type="checkbox" class="order-check" value="{{ $data->id }}">
                                    </td>

                                    <!-- 2. Customer -->
                                    <td>
                                        <div class="d-flex align-items-start" style="gap: 10px;">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($data->first_name ?? 'C', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark" style="font-size: 13.5px;">
                                                    {{ $data->first_name ? $data->first_name . ' ' . $data->last_name : 'Guest Customer' }}
                                                </div>
                                                @if(!empty($data->phone))
                                                <div class="text-muted d-flex align-items-center gap-1 mt-1" style="font-size: 12px;">
                                                    <i class="fas fa-phone-alt text-success mr-1"></i>
                                                    <a href="tel:{{ $data->phone }}" class="text-dark font-weight-bold mr-2">{{ $data->phone }}</a>
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data->phone) }}" target="_blank" class="badge badge-success px-2 py-1" title="Chat on WhatsApp">
                                                        <i class="fab fa-whatsapp"></i> Chat
                                                    </a>
                                                </div>
                                                @endif
                                                @if($data->address || $data->town || $data->district)
                                                <div class="text-muted text-truncate mt-1" style="font-size: 11.5px; max-width: 220px;" title="{{ $data->address }}, {{ $data->town ?? '' }}, {{ $data->district ?? '' }}">
                                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                                    {{ $data->address ? $data->address : ($data->town ? $data->town . ', ' . $data->district : 'N/A') }}
                                                </div>
                                                @endif
                                                <div class="text-muted mt-1" style="font-size: 11px;">
                                                    <i class="fas fa-network-wired mr-1 text-info"></i> IP: {{ $data->ip_address ?? request()->ip() ?? '103.145.132.89' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 3. Product -->
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
                                                    <div class="font-weight-bold text-dark" style="font-size: 12.5px; line-height: 1.3; max-width: 240px;">
                                                        {{ $item->title ?? ($item->product->title ?? 'Cart Product') }}
                                                    </div>
                                                    <div class="d-flex align-items-center flex-wrap mt-1" style="gap: 4px;">
                                                        <span class="product-meta-pill">Qty: {{ $item->qty }}</span>
                                                        @if(!empty($item->size) && $item->size != 'null')
                                                            <span class="product-meta-pill">Size: {{ $item->size }}</span>
                                                        @endif
                                                        @if(!empty($item->color) && $item->color != 'null')
                                                            <span class="product-meta-pill">Color: {{ $item->color }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted font-italic">Cart details saved</span>
                                        @endif
                                    </td>

                                    <!-- 4. Amount -->
                                    <td>
                                        <div style="font-size: 13px; line-height: 1.6;">
                                            <div class="font-weight-bold text-dark" style="font-size: 14px;">
                                                ৳ {{ number_format($data->total ?? $data->subtotal, 0) }}
                                            </div>
                                            <small class="text-muted">
                                                Subtotal: ৳ {{ number_format($data->subtotal ?? $data->total, 0) }}
                                            </small>
                                            @if($data->shipping_charge > 0)
                                            <br>
                                            <small class="text-muted">
                                                Delivery: ৳ {{ number_format($data->shipping_charge, 0) }}
                                            </small>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- 5. Status -->
                                    <td>
                                        <span class="status-pill-incomplete">
                                            <i class="fas fa-exclamation-circle"></i> Incomplete Order
                                        </span>
                                        <div class="mt-1 text-muted" style="font-size: 11px; line-height: 1.4;">
                                            <div><i class="far fa-clock mr-1"></i> {{ date('d M, Y | h:i A', strtotime($data->created_at)) }}</div>
                                            <div><i class="fas fa-tag mr-1 text-info"></i> Cart: Abandoned</div>
                                        </div>
                                    </td>

                                    <!-- 6. Action -->
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Convert / Confirm Order -->
                                            <a href="{{ route('admin.order.status.processing', $data->id) }}" onclick="return confirm('Convert this incomplete order to Approved / Processing?')" class="btn btn-success btn-xs" title="Convert to Active Order" style="padding: 3px 8px; font-size: 11px;">
                                                <i class="fas fa-check"></i>
                                            </a>

                                            <!-- View Details -->
                                            <a href="{{ route('admin.order.show', $data->id) }}" class="btn btn-info btn-xs" title="View Order Details" style="padding: 3px 8px; font-size: 11px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Delete -->
                                            <a href="{{ route('admin.order.delete', ['did' => $data->id]) }}" onclick="return confirm('Permanently delete this incomplete order?')" class="btn btn-danger btn-xs" title="Delete Order" style="padding: 3px 8px; font-size: 11px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-check fa-3x text-gray mb-3 d-block"></i>
                                        <h5>No Incomplete Orders Found</h5>
                                        <p class="small text-muted mb-0">All customer carts and checkouts are fully processed.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>

@endsection

@push('js')
    <!-- DataTables & Plugins -->
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
                    { "orderable": false, "targets": [0, 5] }
                ],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "language": {
                    "info": "Showing _START_ – _END_ of _TOTAL_ incomplete orders"
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

            $('#bulkActionForm').on('submit', function (e) {
                var selected = $('.order-check:checked');
                var statusVal = $('#bulkStatusSelect').val();

                if (selected.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one incomplete order.');
                    return false;
                }

                if (!statusVal) {
                    e.preventDefault();
                    alert('Please choose an action to perform.');
                    return false;
                }

                if (statusVal === 'delete') {
                    if (!confirm('Are you sure you want to permanently delete ' + selected.length + ' selected orders?')) {
                        e.preventDefault();
                        return false;
                    }
                } else {
                    if (!confirm('Are you sure you want to apply this action to ' + selected.length + ' selected orders?')) {
                        e.preventDefault();
                        return false;
                    }
                }

                var hiddenContainer = $('#bulkHiddenIds');
                hiddenContainer.empty();
                selected.each(function () {
                    hiddenContainer.append('<input type="hidden" name="order_ids[]" value="' + $(this).val() + '">');
                });
            });
        });
    </script>
@endpush