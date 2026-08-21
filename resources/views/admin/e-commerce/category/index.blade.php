@extends('layouts.admin.e-commerce.app')

@section('title', 'Category Management Hub')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Modern Typography & Header */
        .content-header { padding: 1.5rem 1.5rem 1rem; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: #0f172a; letter-spacing: -0.5px; }
        .breadcrumb-item a { color: #3b82f6; text-decoration: none; font-weight: 500; }
        
        /* Unified Category Tab Navigation */
        .category-tab-container {
            background: #ffffff;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
            border-left: 4px solid #3b82f6;
        }
        .nav-pills-hub {
            gap: 8px;
            display: flex;
            flex-wrap: wrap;
            border: none;
        }
        .nav-pills-hub .nav-link {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            font-size: 0.92rem;
            color: #64748b;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .nav-pills-hub .nav-link:hover {
            color: #1e293b;
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        .nav-pills-hub .nav-link.active {
            background: #3b82f6 !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.35);
        }
        .nav-pills-hub .nav-link .badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 20px;
            background: rgba(0,0,0,0.08);
            color: inherit;
        }
        .nav-pills-hub .nav-link.active .badge {
            background: rgba(255,255,255,0.25);
            color: #ffffff;
        }

        /* Card and Table Styles */
        .card-custom {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            background: #ffffff;
        }
        .card-header-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-add-new {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white !important;
            font-weight: 600;
            padding: 9px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-add-new:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }
        
        .table-custom { margin-bottom: 0; width: 100% !important; }
        .table-custom thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 16px;
        }
        .table-custom tbody td {
            vertical-align: middle;
            padding: 12px 16px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .cat-image {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .cat-name { font-weight: 600; color: #1e293b; font-size: 0.95rem; display: block; }
        .cat-parent { font-size: 0.82rem; color: #3b82f6; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .cat-desc { font-size: 0.85rem; color: #64748b; line-height: 1.3; }
        
        /* Pure CSS Modern Switch */
        .custom-toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            margin: 0;
        }
        .custom-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }
        .custom-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e2e8f0;
            transition: .3s;
            border-radius: 24px;
            border: 1px solid #cbd5e1;
        }
        .custom-toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .custom-toggle-switch input:checked + .custom-toggle-slider {
            background-color: #10b981;
            border-color: #10b981;
        }
        .custom-toggle-switch input:checked + .custom-toggle-slider:before {
            transform: translateX(20px);
        }
        
        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }
        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
            font-size: 0.88rem;
            cursor: pointer;
        }
        .btn-view-products { background-color: #e0e7ff; color: #4f46e5; }
        .btn-view-products:hover { background-color: #4f46e5; color: white; }
        
        .btn-view { background-color: #f1f5f9; color: #64748b; }
        .btn-view:hover { background-color: #94a3b8; color: white; }
        
        .btn-edit { background-color: #e0f2fe; color: #0284c7; }
        .btn-edit:hover { background-color: #0284c7; color: white; }
        
        .btn-delete { background-color: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background-color: #dc2626; color: white; }

        /* DataTables customizations */
        .dataTables_wrapper .dataTables_length select { border-radius: 6px; border: 1px solid #cbd5e1; padding: 4px 8px; }
        .dataTables_wrapper .dataTables_filter input { border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 12px; }

        /* Modal styling */
        .modal-content { border-radius: 14px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .modal-header { border-bottom: 1px solid #f1f5f9; background: #f8fafc; padding: 1.25rem 1.5rem; }
        .modal-footer { border-top: 1px solid #f1f5f9; background: #f8fafc; padding: 1rem 1.5rem; }
        .modal-title { color: #0f172a; font-weight: 700; font-size: 1.15rem; }
        .form-control { border-radius: 8px; border: 1px solid #cbd5e1; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
    </style>
@endpush

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h1 class="page-title">Category Management Hub</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="{{routeHelper('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content px-3">

    <!-- Category Hub Navigation Tabs -->
    <div class="category-tab-container">
        <ul class="nav nav-pills nav-pills-hub" id="categoryTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="mega-tab" data-toggle="pill" href="#mega-panel" role="tab" aria-controls="mega-panel" aria-selected="true">
                    <i class="fas fa-layer-group"></i> Mega Categories
                    <span class="badge">{{ count($categories) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sub-tab" data-toggle="pill" href="#sub-panel" role="tab" aria-controls="sub-panel" aria-selected="false">
                    <i class="fas fa-stream"></i> Sub Categories
                    <span class="badge">{{ count($sub_categories) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mini-tab" data-toggle="pill" href="#mini-panel" role="tab" aria-controls="mini-panel" aria-selected="false">
                    <i class="fas fa-list-ul"></i> Mini Categories
                    <span class="badge">{{ count($mini_categories) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="extra-tab" data-toggle="pill" href="#extra-panel" role="tab" aria-controls="extra-panel" aria-selected="false">
                    <i class="fas fa-tags"></i> Extra Categories
                    <span class="badge">{{ count($extra_categories) }}</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Tab Contents -->
    <div class="tab-content" id="categoryTabContent">

        <!-- ======================= 1. MEGA CATEGORY TAB ======================= -->
        <div class="tab-pane fade show active" id="mega-panel" role="tabpanel" aria-labelledby="mega-tab">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h3 class="card-title m-0 font-weight-bold text-dark">
                        <i class="fas fa-layer-group text-primary mr-1"></i> Mega Categories List
                    </h3>
                    <button type="button" class="btn btn-add-new" data-toggle="modal" data-target="#addMegaCategoryModal">
                        <i class="fas fa-plus-circle"></i> Add Mega Category
                    </button>
                </div>
                
                <div class="card-body p-4">
                    <table id="megaTable" class="table table-custom table-hover w-100">
                        <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th width="10%">Cover</th>
                                <th width="40%">Category Info</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="30%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $data)
                                <tr>
                                    <td><span class="text-muted font-weight-bold">#{{$key + 1}}</span></td>
                                    <td>
                                        @if ($data->cover_photo == 'default.png')
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($data->name) }}&background=f1f5f9&color=3b82f6&bold=true" alt="Cover" class="cat-image">
                                        @else
                                            <img src="/uploads/category/{{$data->cover_photo}}" alt="Cover Photo" class="cat-image">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="cat-name">{{$data->name}}</span>
                                        <span class="cat-desc">{{ $data->description && $data->description != 'null' ? Str::words($data->description, 8, '...') : 'No description' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <label class="custom-toggle-switch">
                                            <input type="checkbox" class="status-toggle" data-url="{{ route('admin.category.status', '') }}/{{ $data->id }}" {{ $data->status ? 'checked' : '' }}>
                                            <span class="custom-toggle-slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-right">
                                        <div class="action-group">
                                            <a href="{{routeHelper('category/product/'.$data->id)}}" class="btn-action btn-view-products" title="View Products" data-toggle="tooltip">
                                                <i class="fas fa-box"></i>
                                            </a>
                                            <a href="{{routeHelper('category/'.$data->id)}}" class="btn-action btn-view" title="View Details" data-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-edit edit-mega-btn" 
                                                data-id="{{ $data->id }}"
                                                data-name="{{ $data->name }}"
                                                data-desc="{{ $data->description == 'null' ? '' : $data->description }}"
                                                data-pos="{{ $data->pos }}"
                                                data-status="{{ $data->status }}"
                                                data-feature="{{ $data->is_feature }}"
                                                title="Edit Category" data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" data-form="delete-mega-form-{{$data->id}}" class="btn-action btn-delete delete-confirm-btn" title="Delete Category" data-toggle="tooltip">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="delete-mega-form-{{$data->id}}" action="{{ routeHelper('category/'. $data->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ======================= 2. SUB CATEGORY TAB ======================= -->
        <div class="tab-pane fade" id="sub-panel" role="tabpanel" aria-labelledby="sub-tab">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h3 class="card-title m-0 font-weight-bold text-dark">
                        <i class="fas fa-stream text-info mr-1"></i> Sub Categories List
                    </h3>
                    <button type="button" class="btn btn-add-new" data-toggle="modal" data-target="#addSubCategoryModal">
                        <i class="fas fa-plus-circle"></i> Add Sub Category
                    </button>
                </div>
                
                <div class="card-body p-4">
                    <table id="subTable" class="table table-custom table-hover w-100">
                        <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th width="10%">Cover</th>
                                <th width="25%">Sub Category</th>
                                <th width="20%">Parent Mega Category</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="25%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sub_categories as $key => $sub)
                                <tr>
                                    <td><span class="text-muted font-weight-bold">#{{$key + 1}}</span></td>
                                    <td>
                                        @if ($sub->cover_photo == 'default.png')
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($sub->name) }}&background=f0fdf4&color=16a34a&bold=true" alt="Cover" class="cat-image">
                                        @else
                                            <img src="/uploads/sub category/{{$sub->cover_photo}}" alt="Cover Photo" class="cat-image">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="cat-name">{{$sub->name}}</span>
                                    </td>
                                    <td>
                                        <span class="cat-parent">
                                            <i class="fas fa-layer-group text-primary"></i> {{ $sub->category->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <label class="custom-toggle-switch">
                                            <input type="checkbox" class="status-toggle" data-url="{{ route('admin.sub-category.status', '') }}/{{ $sub->id }}" {{ $sub->status ? 'checked' : '' }}>
                                            <span class="custom-toggle-slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-right">
                                        <div class="action-group">
                                            <a href="{{routeHelper('sub-category/product/'.$sub->id)}}" class="btn-action btn-view-products" title="View Products" data-toggle="tooltip">
                                                <i class="fas fa-box"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-edit edit-sub-btn" 
                                                data-id="{{ $sub->id }}"
                                                data-name="{{ $sub->name }}"
                                                data-category="{{ $sub->category_id }}"
                                                data-status="{{ $sub->status }}"
                                                data-feature="{{ $sub->is_feature }}"
                                                title="Edit Sub Category" data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" data-form="delete-sub-form-{{$sub->id}}" class="btn-action btn-delete delete-confirm-btn" title="Delete Sub Category" data-toggle="tooltip">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="delete-sub-form-{{$sub->id}}" action="{{ routeHelper('sub-category/'. $sub->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ======================= 3. MINI CATEGORY TAB ======================= -->
        <div class="tab-pane fade" id="mini-panel" role="tabpanel" aria-labelledby="mini-tab">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h3 class="card-title m-0 font-weight-bold text-dark">
                        <i class="fas fa-list-ul text-warning mr-1"></i> Mini Categories List
                    </h3>
                    <button type="button" class="btn btn-add-new" data-toggle="modal" data-target="#addMiniCategoryModal">
                        <i class="fas fa-plus-circle"></i> Add Mini Category
                    </button>
                </div>
                
                <div class="card-body p-4">
                    <table id="miniTable" class="table table-custom table-hover w-100">
                        <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th width="10%">Cover</th>
                                <th width="25%">Mini Category</th>
                                <th width="20%">Parent Sub Category</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="25%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mini_categories as $key => $mini)
                                <tr>
                                    <td><span class="text-muted font-weight-bold">#{{$key + 1}}</span></td>
                                    <td>
                                        @if ($mini->cover_photo == 'default.png')
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mini->name) }}&background=fffbeb&color=d97706&bold=true" alt="Cover" class="cat-image">
                                        @else
                                            <img src="/uploads/mini-category/{{$mini->cover_photo}}" alt="Cover Photo" class="cat-image">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="cat-name">{{$mini->name}}</span>
                                    </td>
                                    <td>
                                        <span class="cat-parent text-info">
                                            <i class="fas fa-stream"></i> {{ $mini->subCategory->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <label class="custom-toggle-switch">
                                            <input type="checkbox" class="status-toggle" data-url="{{ route('admin.minicategory.status', '') }}/{{ $mini->id }}" {{ $mini->status ? 'checked' : '' }}>
                                            <span class="custom-toggle-slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-right">
                                        <div class="action-group">
                                            <a href="{{routeHelper('min-category/product/'.$mini->id)}}" class="btn-action btn-view-products" title="View Products" data-toggle="tooltip">
                                                <i class="fas fa-box"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-edit edit-mini-btn" 
                                                data-id="{{ $mini->id }}"
                                                data-name="{{ $mini->name }}"
                                                data-category="{{ $mini->category_id }}"
                                                data-status="{{ $mini->status }}"
                                                data-feature="{{ $mini->is_feature }}"
                                                title="Edit Mini Category" data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" data-url="{{ routeHelper('mini-categories/delete/'. $mini->id) }}" class="btn-action btn-delete delete-link-btn" title="Delete Mini Category" data-toggle="tooltip">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ======================= 4. EXTRA CATEGORY TAB ======================= -->
        <div class="tab-pane fade" id="extra-panel" role="tabpanel" aria-labelledby="extra-tab">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h3 class="card-title m-0 font-weight-bold text-dark">
                        <i class="fas fa-tags text-purple mr-1"></i> Extra Categories List
                    </h3>
                    <button type="button" class="btn btn-add-new" data-toggle="modal" data-target="#addExtraCategoryModal">
                        <i class="fas fa-plus-circle"></i> Add Extra Category
                    </button>
                </div>
                
                <div class="card-body p-4">
                    <table id="extraTable" class="table table-custom table-hover w-100">
                        <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th width="10%">Cover</th>
                                <th width="25%">Extra Category</th>
                                <th width="20%">Parent Mini Category</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="25%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($extra_categories as $key => $extra)
                                <tr>
                                    <td><span class="text-muted font-weight-bold">#{{$key + 1}}</span></td>
                                    <td>
                                        @if ($extra->cover_photo == 'default.png')
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($extra->name) }}&background=faf5ff&color=9333ea&bold=true" alt="Cover" class="cat-image">
                                        @else
                                            <img src="/uploads/extra-category/{{$extra->cover_photo}}" alt="Cover Photo" class="cat-image">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="cat-name">{{$extra->name}}</span>
                                    </td>
                                    <td>
                                        <span class="cat-parent text-warning">
                                            <i class="fas fa-list-ul"></i> {{ $extra->miniCategory->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <label class="custom-toggle-switch">
                                            <input type="checkbox" class="status-toggle" data-url="{{ route('admin.extracategory.status', '') }}/{{ $extra->id }}" {{ $extra->status ? 'checked' : '' }}>
                                            <span class="custom-toggle-slider"></span>
                                        </label>
                                    </td>
                                    <td class="text-right">
                                        <div class="action-group">
                                            <a href="{{routeHelper('ex-category/product/'.$extra->id)}}" class="btn-action btn-view-products" title="View Products" data-toggle="tooltip">
                                                <i class="fas fa-box"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-edit edit-extra-btn" 
                                                data-id="{{ $extra->id }}"
                                                data-name="{{ $extra->name }}"
                                                data-mini="{{ $extra->mini_category_id }}"
                                                data-status="{{ $extra->status }}"
                                                data-feature="{{ $extra->is_feature }}"
                                                title="Edit Extra Category" data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" data-url="{{ routeHelper('extra-categories/delete/'. $extra->id) }}" class="btn-action btn-delete delete-link-btn" title="Delete Extra Category" data-toggle="tooltip">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</section>

<!-- ======================= MODALS ======================= -->

<!-- 1. Add Mega Category Modal -->
<div class="modal fade" id="addMegaCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle text-primary mr-1"></i> Add Mega Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ routeHelper('category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Electronics, Fashion">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Category description..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Position / Order</label>
                        <input type="number" name="pos" class="form-control" placeholder="Sort position (optional)">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="status" checked value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 1. Edit Mega Category Modal -->
<div class="modal fade" id="editMegaCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit text-info mr-1"></i> Edit Mega Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editMegaCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_mega_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Description</label>
                        <textarea name="description" id="edit_mega_desc" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Position / Order</label>
                        <input type="number" name="pos" id="edit_mega_pos" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo (Leave blank to keep current)</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_mega_status" name="status" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_mega_feature" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. Add Sub Category Modal -->
<div class="modal fade" id="addSubCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle text-info mr-1"></i> Add Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ routeHelper('sub-category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Parent Mega Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Select Parent Mega Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Sub Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Mobile Phones, Men Clothing">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="status" checked value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Sub Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. Edit Sub Category Modal -->
<div class="modal fade" id="editSubCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit text-info mr-1"></i> Edit Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSubCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Parent Mega Category <span class="text-danger">*</span></label>
                        <select name="category" id="edit_sub_category_id" class="form-control" required>
                            <option value="">-- Select Parent Mega Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Sub Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_sub_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo (Leave blank to keep current)</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_sub_status" name="status" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_sub_feature" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Update Sub Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. Add Mini Category Modal -->
<div class="modal fade" id="addMiniCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle text-warning mr-1"></i> Add Mini Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.create.mini') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Parent Sub Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Select Parent Sub Category --</option>
                            @foreach ($sub_categories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }} (Mega: {{ $sub->category->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Mini Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Smart Watches, T-Shirts">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="status" checked value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Mini Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. Edit Mini Category Modal -->
<div class="modal fade" id="editMiniCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit text-warning mr-1"></i> Edit Mini Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.edit.mini') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ddddd" id="edit_mini_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Parent Sub Category <span class="text-danger">*</span></label>
                        <select name="category" id="edit_mini_category_id" class="form-control" required>
                            <option value="">-- Select Parent Sub Category --</option>
                            @foreach ($sub_categories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }} (Mega: {{ $sub->category->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Mini Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_mini_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo (Leave blank to keep current)</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_mini_status" name="status" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_mini_feature" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Update Mini Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 4. Add Extra Category Modal -->
<div class="modal fade" id="addExtraCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle text-purple mr-1"></i> Add Extra Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.create.extra') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Parent Mini Category <span class="text-danger">*</span></label>
                        <select name="mini" class="form-control" required>
                            <option value="">-- Select Parent Mini Category --</option>
                            @foreach ($mini_categories as $mini)
                                <option value="{{ $mini->id }}">{{ $mini->name }} (Sub: {{ $mini->subCategory->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Extra Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Polo T-Shirts, Wireless Earbuds">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="status" checked value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Save Extra Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 4. Edit Extra Category Modal -->
<div class="modal fade" id="editExtraCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit text-purple mr-1"></i> Edit Extra Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.edit.extra') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ddddd" id="edit_extra_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-600">Parent Mini Category <span class="text-danger">*</span></label>
                        <select name="mini" id="edit_extra_mini_id" class="form-control" required>
                            <option value="">-- Select Parent Mini Category --</option>
                            @foreach ($mini_categories as $mini)
                                <option value="{{ $mini->id }}">{{ $mini->name }} (Sub: {{ $mini->subCategory->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Extra Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_extra_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600">Cover Photo (Leave blank to keep current)</label>
                        <input type="file" name="cover_photo" class="form-control-file" accept="image/*">
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_extra_status" name="status" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Active</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <label class="custom-toggle-switch mr-2">
                                    <input type="checkbox" id="edit_extra_feature" name="is_feature" value="1">
                                    <span class="custom-toggle-slider"></span>
                                </label>
                                <span class="font-weight-bold text-muted">Featured</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">Update Extra Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
    <!-- DataTables & Plugins -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(function () { 
            // Initialize Tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // SweetAlert2 Toast Mixin
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Initialize All DataTables
            const dtOptions = {
                "responsive": true,
                "autoWidth": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search..."
                }
            };

            const megaDt = $("#megaTable").DataTable(dtOptions);
            const subDt = $("#subTable").DataTable(dtOptions);
            const miniDt = $("#miniTable").DataTable(dtOptions);
            const extraDt = $("#extraTable").DataTable(dtOptions);

            // Re-init tooltips on redraws
            $('.table-custom').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            // Tab State in URL Hash
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.getAttribute('href');
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().responsive.recalc();
            });

            // Load active tab from Hash if present
            var activeHash = window.location.hash;
            if (activeHash) {
                $('.nav-pills-hub a[href="' + activeHash + '"]').tab('show');
            }

            // Universal AJAX Status Switch Toggle
            $(document).on('change', '.status-toggle', function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let requestUrl = $(this).data('url');
                let checkbox = $(this);
                
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: requestUrl,
                    success: function(data) {
                        if(data.success){
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: data.message || 'Error updating status'
                            });
                            checkbox.prop('checked', !status);
                        }
                    },
                    error: function(err) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to communicate with server.'
                        });
                        checkbox.prop('checked', !status);
                    }
                });
            });

            // 1. Edit Mega Category
            $(document).on('click', '.edit-mega-btn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let desc = $(this).data('desc');
                let pos = $(this).data('pos');
                let status = $(this).data('status');
                let feature = $(this).data('feature');

                let updateUrl = window.location.origin + '/admin/category/' + id;
                $('#editMegaCategoryForm').attr('action', updateUrl);

                $('#edit_mega_name').val(name);
                $('#edit_mega_desc').val(desc);
                $('#edit_mega_pos').val(pos);
                $('#edit_mega_status').prop('checked', status == 1);
                $('#edit_mega_feature').prop('checked', feature == 1);

                $('#editMegaCategoryModal').modal('show');
            });

            // 2. Edit Sub Category
            $(document).on('click', '.edit-sub-btn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let categoryId = $(this).data('category');
                let status = $(this).data('status');
                let feature = $(this).data('feature');

                let updateUrl = window.location.origin + '/admin/sub-category/' + id;
                $('#editSubCategoryForm').attr('action', updateUrl);

                $('#edit_sub_name').val(name);
                $('#edit_sub_category_id').val(categoryId);
                $('#edit_sub_status').prop('checked', status == 1);
                $('#edit_sub_feature').prop('checked', feature == 1);

                $('#editSubCategoryModal').modal('show');
            });

            // 3. Edit Mini Category
            $(document).on('click', '.edit-mini-btn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let categoryId = $(this).data('category');
                let status = $(this).data('status');
                let feature = $(this).data('feature');

                $('#edit_mini_id').val(id);
                $('#edit_mini_name').val(name);
                $('#edit_mini_category_id').val(categoryId);
                $('#edit_mini_status').prop('checked', status == 1);
                $('#edit_mini_feature').prop('checked', feature == 1);

                $('#editMiniCategoryModal').modal('show');
            });

            // 4. Edit Extra Category
            $(document).on('click', '.edit-extra-btn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let miniId = $(this).data('mini');
                let status = $(this).data('status');
                let feature = $(this).data('feature');

                $('#edit_extra_id').val(id);
                $('#edit_extra_name').val(name);
                $('#edit_extra_mini_id').val(miniId);
                $('#edit_extra_status').prop('checked', status == 1);
                $('#edit_extra_feature').prop('checked', feature == 1);

                $('#editExtraCategoryModal').modal('show');
            });

            // SweetAlert2 Form Delete Confirmation (Mega & Sub)
            $(document).on('click', '.delete-confirm-btn', function(e) {
                e.preventDefault();
                let formId = $(this).data('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This category and its relations will be removed!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#' + formId).submit();
                    }
                });
            });

            // SweetAlert2 Link Delete Confirmation (Mini & Extra)
            $(document).on('click', '.delete-link-btn', function(e) {
                e.preventDefault();
                let targetUrl = $(this).data('url');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This category and its relations will be removed!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = targetUrl;
                    }
                });
            });
        });
    </script>
@endpush