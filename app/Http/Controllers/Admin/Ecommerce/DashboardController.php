<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Product metrics
        $products          = DB::table('products')->count();
        $quantity          = DB::table('products')->sum('quantity');
        $low_products      = DB::table('products')->where('quantity', '<', 6)->count();

        // Order metrics
        $orders            = DB::table('orders')->count();
        $pending_orders    = DB::table('orders')->where('status', 0)->count();
        $processing_orders = DB::table('orders')->where('status', 1)->count();
        $cancel_orders     = DB::table('orders')->where('status', 2)->count();
        $delivered_orders  = DB::table('orders')->where('status', 3)->count();

        // Direct Store Financial metrics
        $admin_amount      = (float) DB::table('vendor_accounts')->where('vendor_id', 1)->sum('amount');
        $pending_amount    = (float) DB::table('vendor_accounts')->where('vendor_id', 1)->sum('pending_amount');
        $total_revenue     = (float) DB::table('orders')->whereIn('status', [1, 3])->sum('total');

        // Customer metrics
        $customers         = DB::table('users')->where('role_id', 3)->count();

        // Recent Orders
        $recent_orders     = DB::table('orders')->latest('id')->take(8)->get();

        // Low stock products alert list
        $low_stock_list    = DB::table('products')->where('quantity', '<', 6)->latest('id')->take(5)->get();

        // Monthly sales trend (last 6 months)
        $monthly_labels = [];
        $monthly_sales  = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthly_labels[] = $month->format('M Y');
            $salesCount = DB::table('orders')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total');
            $monthly_sales[] = round((float) $salesCount, 2);
        }

        return view('admin.e-commerce.dashboard', compact(
            'products',
            'pending_amount',
            'quantity',
            'low_products',
            'orders',
            'pending_orders',
            'processing_orders',
            'cancel_orders',
            'delivered_orders',
            'admin_amount',
            'total_revenue',
            'customers',
            'recent_orders',
            'low_stock_list',
            'monthly_labels',
            'monthly_sales'
        ));
    }
}
