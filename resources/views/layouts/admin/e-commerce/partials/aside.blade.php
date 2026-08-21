<style>
    /* Premium Sidebar CSS */
    .main-sidebar { background-color: #0f172a !important; border-right: 1px solid #1e293b; }
    .brand-link { border-bottom: 1px solid #1e293b !important; padding: 14px; background: rgba(0,0,0,0.1); }
    .nav-header { 
        font-size: 11.5px !important; 
        color: #64748b !important; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.8px; 
        padding: 24px 16px 8px !important; 
    }
    .nav-sidebar .nav-item > .nav-link { 
        margin-bottom: 4px; 
        padding: 10px 14px; 
        font-size: 14px; 
        border-radius: 8px; 
        transition: all 0.2s ease;
        color: #cbd5e1;
    }
    .nav-sidebar .nav-link:hover { 
        background-color: rgba(255,255,255,0.06); 
        color: #ffffff !important; 
    }
    .nav-sidebar .nav-item.menu-open > .nav-link {
        background-color: rgba(255,255,255,0.03); 
        color: #ffffff;
    }
    .nav-sidebar .nav-link.active { 
        background-color: #108b3a !important; 
        color: #ffffff !important; 
        box-shadow: 0 4px 10px rgba(16, 139, 58, 0.25); 
        font-weight: 500;
    }
    .nav-treeview { 
        background-color: transparent !important; 
        padding: 4px 0 4px 14px; 
        position: relative;
    }
    .nav-treeview::before {
        content: '';
        position: absolute;
        left: 21px;
        top: 0;
        bottom: 10px;
        width: 1px;
        background: #334155;
    }
    .nav-treeview > .nav-item > .nav-link { 
        padding: 8px 10px 8px 30px; 
        font-size: 13.5px; 
        color: #94a3b8;
        position: relative;
    }
    .nav-treeview > .nav-item > .nav-link::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 17px;
        width: 12px;
        height: 1px;
        background: #334155;
    }
    .nav-treeview > .nav-item > .nav-link:hover {
        color: #ffffff;
    }
    .nav-treeview > .nav-item > .nav-link.active { 
        background-color: rgba(16, 139, 58, 0.1) !important; 
        color: #4ade80 !important; 
        box-shadow: none; 
        font-weight: 600; 
    }
    .nav-treeview > .nav-item > .nav-link.active::before {
        background: #4ade80;
    }
    .nav-icon { 
        font-size: 1.15rem !important; 
        width: 28px !important;
        text-align: center;
        margin-right: 6px; 
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link text-center">
        <img src="/uploads/setting/{{setting('logo')}}" alt="Logo" class="brand-image" style="opacity: 0.95; float: none; width: auto; max-height: 38px; margin: 0 auto; display: block;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2 pb-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- ============================ MAIN ============================ -->
                <li class="nav-header">📊 MAIN</li>
                
                <li class="nav-item">
                    <a href="{{routeHelper('dashboard')}}" class="nav-link {{Request::is('admin') ? 'active':''}}">
                        <i class="nav-icon fas fa-tachometer-alt" style="color: #38bdf8;"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- ============================ E-COMMERCE CORE ============================ -->
                <li class="nav-header">🛍️ E-COMMERCE CORE</li>

                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2|| auth()->user()->desig ==4)
                <li class="nav-item {{Request::is('admin/order*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fab fa-jedi-order" style="color: #fbbf24;"></i>
                        <p>
                            Orders Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('order')}}" class="nav-link {{Request::is('admin/order') && !Request::is('admin/order/*') ? 'active':''}}">
                                <p>All Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/pre')}}" class="nav-link {{Request::is('admin/order/pre') ? 'active':''}}">
                                <p>Pre Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/pending')}}" class="nav-link {{Request::is('admin/order/pending') ? 'active':''}}">
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/hold')}}" class="nav-link {{Request::is('admin/order/hold') ? 'active':''}}">
                                <p>Hold</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/approved')}}" class="nav-link {{Request::is('admin/order/approved') || Request::is('admin/order/processing') ? 'active':''}}">
                                <p>Approved Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/packaging')}}" class="nav-link {{Request::is('admin/order/packaging') ? 'active':''}}">
                                <p>Packaging Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/in-courier')}}" class="nav-link {{Request::is('admin/order/in-courier') ? 'active':''}}">
                                <p>In Courier Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/delivered')}}" class="nav-link {{Request::is('admin/order/delivered') ? 'active':''}}">
                                <p>Delivered Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/return')}}" class="nav-link {{Request::is('admin/order/return') ? 'active':''}}">
                                <p>Return Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/cancel')}}" class="nav-link {{Request::is('admin/order/cancel') ? 'active':''}}">
                                <p>Canceled Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/partials')}}" class="nav-link {{Request::is('admin/order/partials') ? 'active':''}}">
                                <p>Partial Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('order/incomplete')}}" class="nav-link {{Request::is('admin/order/incomplete') ? 'active':''}}">
                                <p>Incomplete / Carts</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2 ||auth()->user()->desig ==3)
                <li class="nav-item {{Request::is('admin/product*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-box" style="color: #4ade80;"></i>
                        <p>
                            Product Catalog
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.product.type')}}" class="nav-link {{Request::is('admin/product/type') ? 'active':''}}">
                                <p>Add New Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('product')}}" class="nav-link {{Request::is('admin/product') ? 'active':''}}">
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.active')}}" class="nav-link {{Request::is('admin/product/active') ? 'active':''}}">
                                <p>Active & Approved</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.disable')}}" class="nav-link {{Request::is('admin/product/disable') ? 'active':''}}">
                                <p>Disabled</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.unaproved')}}" class="nav-link {{Request::is('admin/product/unaproved') ? 'active':''}}">
                                <p>Unapproved</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.reached')}}" class="nav-link {{Request::is('admin/product/reached') ? 'active':''}}">
                                <p>Top Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.imex')}}" class="nav-link {{Request::is('admin/product/bulk') ? 'active':''}}">
                                <p>Import / Export</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nav-item {{Request::is('admin/*category*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-project-diagram" style="color: #f472b6;"></i>
                        <p>
                            Categories Menu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Mega Category -->
                        <li class="nav-item {{Request::is('admin/category*') ? 'menu-is-opening menu-open':''}}">
                            <a href="{{routeHelper('category')}}" class="nav-link">
                                <p>Categories <i class="right fas fa-angle-left"></i></p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(auth()->user()->desig ==1)
                <li class="nav-item {{Request::is('admin/attribute*') || Request::is('admin/color*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-sliders-h" style="color: #60a5fa;"></i>
                        <p>
                            Attributes & Colors
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.attribute.form')}}" class="nav-link {{Request::is('admin/attribute/form') ? 'active':''}}">
                                <p>Add Attribute</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.attribute.index')}}" class="nav-link {{Request::is('admin/attribute/list') ? 'active':''}}">
                                <p>List Attributes</p>
                            </a>
                        </li>
                        <li class="nav-item {{Request::is('admin/color*') ? 'menu-is-opening menu-open':''}}">
                            <a href="javascript:void(0)" class="nav-link">
                                <p>Colors <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview pl-2">
                                <li class="nav-item">
                                    <a href="{{routeHelper('color/create')}}" class="nav-link {{Request::is('admin/color/create') ? 'active':''}}">
                                        <p>Add Color</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{routeHelper('color')}}" class="nav-link {{Request::is('admin/color') && !Request::is('admin/color/create') ? 'active':''}}">
                                        <p>List Colors</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/coupon*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-usd" style="color: #10b981;"></i>
                        <p>
                            Coupons
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('coupon/create')}}" class="nav-link {{Request::is('admin/coupon/create') ? 'active':''}}">
                                <p>Add Coupon</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('coupon')}}" class="nav-link {{Request::is('admin/coupon') && !Request::is('admin/coupon/create') ? 'active':''}}">
                                <p>Coupons List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2)
                <li class="nav-item {{Request::is('admin/brand*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-band-aid" style="color: #fca5a5;"></i>
                        <p>
                            Brands
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('brand/create')}}" class="nav-link {{Request::is('admin/brand/create') ? 'active':''}}">
                                <p>Add Brand</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('brand')}}" class="nav-link {{Request::is('admin/brand') && !Request::is('admin/brand/create') ? 'active':''}}">
                                <p>Brands List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->desig ==1)
                <li class="nav-item {{Request::is('admin/tag*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-tags" style="color: #818cf8;"></i>
                        <p>
                            Tags
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('tag/create')}}" class="nav-link {{Request::is('admin/tag/create') ? 'active':''}}">
                                <p>Add Tag</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('tag')}}" class="nav-link {{Request::is('admin/tag') && !Request::is('admin/tag/create') ? 'active':''}}">
                                <p>Tags List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2)
                <li class="nav-item {{Request::is('admin/customer*') || Request::is('admin/subscribe') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-users" style="color: #c084fc;"></i>
                        <p>
                            Customers CRM
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('customer/create')}}" class="nav-link {{Request::is('admin/customer/create') ? 'active':''}}">
                                <p>Add Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('customer')}}" class="nav-link {{Request::is('admin/customer') && !Request::is('admin/customer/create') ? 'active':''}}">
                                <p>Customer List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('subscribe')}}" class="nav-link {{Request::is('admin/subscribe') ? 'active':''}}">
                                <p>Subscribers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- ============================ CONTENT & MARKETING ============================ -->
                <li class="nav-header">🎨 CONTENT & MARKETING</li>

                @if(auth()->user()->desig ==1)
                <li class="nav-item {{Request::is('admin/campaing*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-bullhorn" style="color: #fb923c;"></i>
                        <p>
                            Campaigns
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.campaing.create')}}" class="nav-link {{Request::is('admin/campaing/create') ? 'active':''}}">
                                <p>Add Campaign</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.campaing.index')}}" class="nav-link {{Request::is('admin/campaing/list') ? 'active':''}}">
                                <p>Campaigns List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2)
                <li class="nav-item {{Request::is('admin/classic*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-gifts" style="color: #f87171;"></i>
                        <p>
                            Classic Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.classic.form')}}" class="nav-link {{Request::is('admin/classic/form') ? 'active':''}}">
                                <p>Add Classic</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.classic.index')}}" class="nav-link {{Request::is('admin/classic/list') ? 'active':''}}">
                                <p>Classic List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(auth()->user()->desig ==1)
                <li class="nav-item {{Request::is('admin/slider*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-images" style="color: #2dd4bf;"></i>
                        <p>
                            Sliders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('slider/create')}}" class="nav-link {{Request::is('admin/slider/create') ? 'active':''}}">
                                <p>Add Slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('slider')}}" class="nav-link {{Request::is('admin/slider') && !Request::is('admin/slider/create') ? 'active':''}}">
                                <p>Sliders List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2)
                <li class="nav-item {{Request::is('admin/collection*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-business-time" style="color: #a78bfa;"></i>
                        <p>
                            Collections
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('collection/create')}}" class="nav-link {{Request::is('admin/collection/create') ? 'active':''}}">
                                <p>Add Collection</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('collection')}}" class="nav-link {{Request::is('admin/collection') && !Request::is('admin/collection/create') ? 'active':''}}">
                                <p>Collections List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item {{Request::is('admin/gallery') ? 'menu-is-opening menu-open':''}}">
                    <a href="{{route('admin.gallery')}}" class="nav-link {{Request::is('admin/gallery') ? 'active':''}}">
                        <i class="nav-icon fas fa-image" style="color: #facc15;"></i>
                        <p>Media Gallery</p>
                    </a>
                </li>
                
                <li class="nav-item {{Request::is('admin/blog*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-th-large" style="color: #4ade80;"></i>
                        <p>
                            Blogs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.new_blog')}}" class="nav-link {{Request::is('admin/Create-new-blog') ? 'active':''}}">
                                <p>Write Blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.index')}}" class="nav-link {{Request::is('admin/blogs') ? 'active':''}}">
                                <p>Own Blogs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.user_blog')}}" class="nav-link {{Request::is('admin/user-blogs') ? 'active':''}}">
                                <p>User Blogs</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->desig ==1)
                <li class="nav-item {{Request::is('admin/page*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-pager" style="color: #60a5fa;"></i>
                        <p>
                            Pages
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.page.create')}}" class="nav-link {{Request::is('admin/page/create') ? 'active':''}}">
                                <p>Create Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.pages')}}" class="nav-link {{Request::is('admin/pages') ? 'active':''}}">
                                <p>Pages List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->desig ==1 || auth()->user()->desig ==2)
                <li class="nav-item">
                    <a href="{{ route('admin.notice_index') }}" class="nav-link {{Request::is('admin/notice_index') ? 'active':''}}">
                        <i class="nav-icon fas fa-flag" style="color: #f87171;"></i>
                        <p>Custom Notice</p>
                    </a>
                </li>
                @endif

                <!-- ============================ SYSTEM & ADMINISTRATION ============================ -->
                <li class="nav-header">⚙️ SYSTEM & ADMINISTRATION</li>

                @if(auth()->user()->desig ==1)
                <li class="nav-item {{Request::is('admin/setting*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cogs" style="color: #94a3b8;"></i>
                        <p>
                            Settings & Config
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{routeHelper('setting')}}" class="nav-link {{Request::is('admin/setting') ? 'active':''}}">
                                <p>Basic Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.site_info')}}" class="nav-link {{Request::is('admin/setting/site_info') ? 'active':''}}">
                                <p>Shop Information</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.shop_settings')}}" class="nav-link {{Request::is('admin/setting/shop_settings') ? 'active':''}}">
                                <p>Shop Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.mailsmsapireglog')}}" class="nav-link {{Request::is('admin/setting/mailsmsapireglog') ? 'active':''}}">
                                <p>SMS | Mail | Login | Reg</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.getway')}}" class="nav-link {{Request::is('admin/setting/getway') ? 'active':''}}">
                                <p>Payment Gateway</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.home')}}" class="nav-link {{Request::is('admin/setting/home') ? 'active':''}}">
                                <p>Home Visibility</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.header')}}" class="nav-link {{Request::is('admin/setting/header') ? 'active':''}}">
                                <p>Header Footer (Backend)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.seo')}}" class="nav-link {{Request::is('admin/setting/seo') ? 'active':''}}">
                                <p>SEO Config</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.docs')}}" class="nav-link {{Request::is('admin/setting/docs') ? 'active':''}}">
                                <p>Documents</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.color')}}" class="nav-link {{Request::is('admin/setting/color') ? 'active':''}}">
                                <p>Theme Colors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.setting.courier')}}" class="nav-link {{Request::is('admin/setting/courier') ? 'active':''}}">
                                <p>Courier Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/staff*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-user-shield" style="color: #cbd5e1;"></i>
                        <p>
                            Staff Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.staff.create')}}" class="nav-link {{Request::is('admin/staff/create') ? 'active':''}}">
                                <p>Add Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.staff.list')}}" class="nav-link {{Request::is('admin/staff/list') ? 'active':''}}">
                                <p>Staff List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/author*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-user-edit" style="color: #cbd5e1;"></i>
                        <p>
                            Author
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.author.create')}}" class="nav-link {{Request::is('admin/author/create') ? 'active':''}}">
                                <p>Add Author</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.author.index')}}" class="nav-link {{Request::is('admin/author') ? 'active':''}}">
                                <p>Author List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/connection*') || Request::is('admin/mail*') || Request::is('admin/ticket*') ? 'menu-is-opening menu-open':''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-headset" style="color: #a78bfa;"></i>
                        <p>
                            Communications
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.connection.live.chat')}}" class="nav-link {{Request::is('admin/connection/live-chat') ? 'active':''}}">
                                <p>Live Chat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('mail')}}" class="nav-link {{Request::is('admin/mail') ? 'active':''}}">
                                <p>Mail Logs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{routeHelper('ticket')}}" class="nav-link {{Request::is('admin/ticket') ? 'active':''}}">
                                <p>Support Tickets</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(auth()->user()->desig ==1)
                <li class="nav-item">
                    <a href="{{routeHelper('shop')}}" class="nav-link {{Request::is('admin/shop') ? 'active':''}}">
                        <i class="nav-icon fas fa-store" style="color: #fbbf24;"></i>
                        <p>Shop Details</p>
                    </a>
                </li>
                @endif

                <!-- ============================ ACCOUNT ============================ -->
                <li class="nav-header">👤 MY ACCOUNT</li>
                
                <li class="nav-item">
                    <a href="{{routeHelper('profile/change-password')}}" class="nav-link {{Request::is('admin/profile/change-password') ? 'active':''}}">
                        <i class="nav-icon fas fa-key" style="color: #94a3b8;"></i>
                        <p>Change Password</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off text-danger"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>