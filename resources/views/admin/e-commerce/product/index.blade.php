@extends('layouts.admin.e-commerce.app')

@section('title', 'Product Catalog')

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

        /* Metric Cards */
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

        /* Filter Card */
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

        /* Product Table */
        .products-main-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #edf2f7;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .products-main-card .card-header {
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            padding: 16px 20px;
        }

        .products-table thead th {
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

        .products-table tbody td {
            vertical-align: middle;
            font-size: 13px;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            padding: 12px 14px;
            background: #ffffff;
        }

        .products-table tbody tr:hover td {
            background-color: #fafbfc;
        }

        .product-thumb-box {
            width: 52px;
            height: 52px;
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

        /* Status Soft Badges */
        .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
        .badge-soft-info { background-color: #e0f2fe; color: #075985; }
        .badge-soft-primary { background-color: #e0e7ff; color: #3730a3; }
        .badge-soft-success { background-color: #dcfce7; color: #166534; }
        .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-soft-dark { background-color: #f1f5f9; color: #334155; }

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

        .status-active { background-color: #dcfce7; color: #15803d; }
        .status-disabled { background-color: #fee2e2; color: #b91c1c; }

        /* Action Buttons */
        .action-btn-group .btn {
            padding: 4px 8px;
            font-size: 12px;
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

        .pagination {
            margin-bottom: 0;
            gap: 4px;
        }

        .pagination .page-link {
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
        }

        .pagination .page-item.active .page-link {
            background-color: #108b3a;
            border-color: #108b3a;
            color: #ffffff;
        }
    </style>
@endpush

@section('content')

<!-- Header Section -->
<div class="container-fluid pt-3">
    <div class="page-header-box">
        <div>
            <h1><i class="fas fa-boxes text-success mr-2"></i> Product Catalog</h1>
            <small class="text-muted">Manage store inventory, pricing, stock levels, and product visibility</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.product.imex') }}" class="btn btn-outline-secondary font-weight-bold mr-2">
                <i class="fas fa-file-import mr-1"></i> Import / Export
            </a>
            <a href="{{ routeHelper('product/create') }}" class="btn btn-success font-weight-bold px-3">
                <i class="fas fa-plus-circle mr-1"></i> Add Product
            </a>
        </div>
    </div>

    <!-- Quick Analytics Stats -->
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-success text-white">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $stats['total'] ?? $products->total() }}</h3>
                    <p>Total Products</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-primary text-white">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $stats['active'] ?? \App\Models\Product::where('status', 1)->count() }}</h3>
                    <p>Active & Live</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-warning text-white">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $stats['low_stock'] ?? \App\Models\Product::where('quantity', '>', 0)->where('quantity', '<=', 5)->count() }}</h3>
                    <p>Low Stock (≤ 5 pcs)</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="metric-card">
                <div class="metric-icon-box bg-danger text-white">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="metric-info">
                    <h3>{{ $stats['out_of_stock'] ?? \App\Models\Product::where('quantity', '<=', 0)->count() }}</h3>
                    <p>Out of Stock</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sort & Filter Card -->
    <div class="filter-sort-card">
        <div class="card-header cursor-pointer" data-toggle="collapse" data-target="#sortFilterBody">
            <span class="d-flex align-items-center">
                <i class="fas fa-filter text-primary mr-2"></i> Search & Filter Products
            </span>
            <i class="fas fa-chevron-down text-muted"></i>
        </div>
        <div class="card-body collapse show" id="sortFilterBody">
            <!-- Quick Status Pills -->
            <div class="status-pill-list">
                <a href="{{ route('admin.product.index') }}" class="status-pill-item {{ !request('status') && !request('stock_status') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> All Catalog
                    <span class="badge badge-light border">{{ $stats['total'] ?? $products->total() }}</span>
                </a>
                <a href="{{ route('admin.product.index', ['status' => 1]) }}" class="status-pill-item {{ request('status') === '1' ? 'active' : '' }}">
                    <i class="fas fa-check-circle text-success"></i> Active
                    <span class="badge badge-success">{{ $stats['active'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.product.index', ['stock_status' => 'low_stock']) }}" class="status-pill-item {{ request('stock_status') == 'low_stock' ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Low Stock
                    <span class="badge badge-warning">{{ $stats['low_stock'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.product.index', ['stock_status' => 'out_of_stock']) }}" class="status-pill-item {{ request('stock_status') == 'out_of_stock' ? 'active' : '' }}">
                    <i class="fas fa-times-circle text-danger"></i> Out of Stock
                    <span class="badge badge-danger">{{ $stats['out_of_stock'] ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.product.index', ['status' => '0']) }}" class="status-pill-item {{ request('status') === '0' ? 'active' : '' }}">
                    <i class="fas fa-ban text-muted"></i> Disabled
                </a>
            </div>

            <!-- Filter Inputs Form -->
            <form action="{{ route('admin.product.index') }}" method="GET" class="border-top pt-3">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">SEARCH KEYWORD / SKU</label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, SKU..." class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">STOCK STATUS</label>
                        <select name="stock_status" class="form-control form-control-sm">
                            <option value="">All Stock Levels</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock (> 5)</option>
                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock (1 - 5)</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock (0)</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="small font-weight-bold text-muted mb-1">BRAND</label>
                        <select name="brand_id" class="form-control form-control-sm">
                            <option value="">All Brands</option>
                            @foreach ($brands ?? [] as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 col-sm-6 mb-2 d-flex align-items-end">
                        <div class="w-100 d-flex gap-2">
                            <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-light border mr-2 flex-grow-1">Reset</a>
                            <button type="submit" class="btn btn-sm btn-success px-3 flex-grow-1">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Main Table Section -->
<section class="content pb-4">
    <div class="container-fluid">
        <div class="products-main-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="font-weight-bold text-dark" style="font-size: 15px;">
                    <i class="fas fa-list mr-1 text-primary"></i> Product Catalog List
                </span>
                <span class="text-muted small">
                    Showing {{ $products->firstItem() ?? 0 }} – {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} Products
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table products-table mb-0 w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>PRODUCT</th>
                                <th>PRICE (RP / DP)</th>
                                <th>STOCK</th>
                                <th>BRAND</th>
                                <th>STATUS</th>
                                <th class="text-center" style="width: 160px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key => $data)
                                <tr>
                                    <!-- SL -->
                                    <td class="text-center font-weight-bold text-muted">
                                        {{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}
                                    </td>

                                    <!-- Product Info -->
                                    <td>
                                        <div class="d-flex align-items-center" style="gap: 12px;">
                                            <div class="product-thumb-box">
                                                @if(!empty($data->image) && file_exists(public_path('uploads/product/' . $data->image)))
                                                    <img src="{{ asset('uploads/product/' . $data->image) }}" alt="Product" class="product-thumb-img">
                                                @elseif(isset($data->images) && $data->images->count() > 0)
                                                    <img src="{{ asset('uploads/product/' . $data->images->first()->image) }}" alt="Product" class="product-thumb-img">
                                                @else
                                                    <img src="{{ asset('assets/frontend/images/no-image.png') }}" onerror="this.src='https://via.placeholder.com/52?text=Product'" alt="Product" class="product-thumb-img">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark" style="font-size: 13.5px; line-height: 1.35; max-width: 320px;">
                                                    <a href="{{ routeHelper('product/' . $data->id) }}" class="text-dark" target="_blank">
                                                        {{ $data->title }}
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center flex-wrap gap-2 mt-1" style="font-size: 11px;">
                                                    @if(!empty($data->sku))
                                                        <span class="badge badge-light border text-muted">SKU: {{ $data->sku }}</span>
                                                    @endif
                                                    <span class="text-muted"><i class="far fa-calendar-alt mr-1"></i> {{ date('d M, Y', strtotime($data->created_at)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Pricing -->
                                    <td>
                                        <div style="font-size: 13px; line-height: 1.6;">
                                            <div>
                                                <span class="text-muted small">RP:</span>
                                                <span class="text-muted font-weight-bold" style="{{ !empty($data->discount_price) && $data->discount_price < $data->regular_price ? 'text-decoration: line-through;' : '' }}">
                                                    ৳ {{ number_format($data->regular_price, 0) }}
                                                </span>
                                            </div>
                                            @if(!empty($data->discount_price) && $data->discount_price < $data->regular_price)
                                            <div>
                                                <span class="text-muted small">DP:</span>
                                                <strong class="text-success font-weight-bold" style="font-size: 13.5px;">
                                                    ৳ {{ number_format($data->discount_price, 0) }}
                                                </strong>
                                                <span class="badge badge-soft-danger px-1 py-0" style="font-size: 10px;">
                                                    -{{ round((($data->regular_price - $data->discount_price) / $data->regular_price) * 100) }}%
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Stock -->
                                    <td>
                                        @if ($data->quantity > 5)
                                            <span class="badge badge-soft-success custom-status-pill">
                                                <i class="fas fa-check-circle mr-1"></i> In Stock ({{ $data->quantity }})
                                            </span>
                                        @elseif ($data->quantity > 0)
                                            <span class="badge badge-soft-warning custom-status-pill">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> Low ({{ $data->quantity }})
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger custom-status-pill">
                                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Brand -->
                                    <td>
                                        @if(isset($data->brand->name))
                                            <span class="badge badge-light border text-dark font-weight-bold">
                                                {{ $data->brand->name }}
                                            </span>
                                        @else
                                            <span class="text-muted font-italic">No Brand</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if ($data->status)
                                            <a href="{{ routeHelper('product/status/' . $data->id) }}" class="custom-status-pill status-active text-decoration-none" title="Click to disable product">
                                                <span class="status-dot">●</span> Active
                                            </a>
                                        @else
                                            <a href="{{ routeHelper('product/status/' . $data->id) }}" class="custom-status-pill status-disabled text-decoration-none" title="Click to activate product">
                                                <span class="status-dot">●</span> Disabled
                                            </a>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm action-btn-group" role="group">
                                            <!-- Quick Order -->
                                            <a href="{{ route('admin.product.order', $data->id) }}" title="Create Custom Order" class="btn btn-primary" style="padding: 3px 8px;">
                                                <i class="fas fa-cart-plus"></i>
                                            </a>

                                            <!-- View -->
                                            <a href="{{ routeHelper('product/' . $data->id) }}" title="View Product Details" class="btn btn-info" target="_blank" style="padding: 3px 8px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ routeHelper('product/' . $data->id . '/edit') }}" title="Edit Product" class="btn btn-warning" style="padding: 3px 8px;">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete -->
                                            @if (auth()->user()->desig != 3)
                                            <button type="button" class="btn btn-danger delete-product-btn" data-id="{{ $data->id }}" title="Delete Product" style="padding: 3px 8px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="delete-form-{{ $data->id }}" action="{{ routeHelper('product/' . $data->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-boxes fa-3x text-gray mb-3 d-block"></i>
                                        <h5>No Products Found</h5>
                                        <p class="small text-muted mb-3">There are no products matching your search criteria.</p>
                                        <a href="{{ routeHelper('product/create') }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus mr-1"></i> Add Your First Product
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer: Pagination -->
            @if ($products->hasPages())
            <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
                <div class="text-muted small">
                    Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection

@push('js')
<script>
    $(function() {
        // SweetAlert or standard confirm for delete
        $('.delete-product-btn').on('click', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to permanently delete this product? This action cannot be undone.')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush
