<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // Order List
    public function orderList()
    {
        if (Session::has('ORDER_SEARCH')) {
            Session::forget('ORDER_SEARCH');
        }
        $data = Order::select('orders.*', 'users.name as customer_name', 'pizzas.pizza_name', DB::raw('count(orders.pizza_id) as count'))
            ->join('users', 'users.id', 'orders.customer_id')
            ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
            ->groupBy('customer_id', 'pizza_id')
            ->orderBy('order_time', 'desc')
            ->paginate(7);
        Session::put('ORDER_LIST', $data->items());
        return view('admin.order.list')->with(['order' => $data]);
    }

    // Order Search
    public function orderSearch(Request $request)
    {
        if (Session::has('ORDER_LIST')) {
            Session::forget('ORDER_LIST');
        }
        $key = $request->searchData;
        $data = Order::select('orders.*', 'users.name as customer_name', 'pizzas.pizza_name', DB::raw('count(orders.pizza_id) as count'))
            ->join('users', 'users.id', 'orders.customer_id')
            ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
            ->orwhere('users.name', 'like', '%' . $key . '%')
            ->orwhere('pizzas.pizza_name', 'like', '%' . $key . '%')
            ->groupBy('customer_id', 'pizza_id')
            ->orderBy('order_time', 'desc')
            ->paginate(7);
        Session::put('ORDER_SEARCH', $data->items());
        return view('admin.order.list')->with(['order' => $data]);

    }

    // Download Order List
    public function orderDownload()
    {
        if (Session::has('ORDER_SEARCH')) {
            $order = collect(Session::get('ORDER_SEARCH'));
        }
        if (Session::has('ORDER_LIST')) {
            $order = collect(Session::get('ORDER_LIST'));
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($order) {
            if ($order->payment_status == 1) {
                $order->payment_status = "Credit Card";
            } elseif ($order->payment_status == 2) {
                $order->payment_status = "Cash";
            }
        });

        $csvExporter->build($order, [
            'order_id' => 'No',
            'customer_name' => 'Customer Name',
            'pizza_name' => 'Pizza Name',
            'count' => 'Pizza Count',
            'payment_status' => 'Payment Type',
            'order_time' => 'OrderDate',
            'created_at' => 'Created Date',
            'updated_at' => 'updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'orderList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
