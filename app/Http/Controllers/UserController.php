<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // direct user home page
    public function index()
    {
        $pizza = Pizza::where('publish_status', 1)->paginate(9);
        $category = Category::get();
        return view('user.home')->with(['pizza' => $pizza, 'category' => $category]);
    }

    // Category Search
    public function categorySearch($id)
    {
        $pizza = Pizza::where('category_id', $id)->paginate(9);
        $category = Category::get();
        return view('user.home')->with(['pizza' => $pizza, 'category' => $category]);
    }

    // Item Search
    public function searchItem(Request $request)
    {
        $key = $request->searchData;
        $data = Pizza::where('pizza_name', 'like', '%' . $key . '%')
            ->paginate(9);
        $data->appends($request->all());
        $category = Category::get();
        return view('user.home')->with(['pizza' => $data, 'category' => $category]);
    }

    // Pizza search by date & price
    public function searchByDatePrice(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $query = Pizza::select('*');

        if (isset($startDate) && is_null($endDate)) {
            $query = $query->whereDate('created_at', '>=', $startDate);
        } else if (is_null($startDate) && isset($endDate)) {
            $query = $query->whereDate('created_at', '<=', $endDate);
        } else if (isset($startDate) && isset($endDate)) {
            $query = $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        if (isset($minPrice) && is_null($maxPrice)) {
            $query = $query->where('price', '>=', $minPrice);
        } else if (is_null($minPrice) && isset($maxPrice)) {
            $query = $query->where('price', '<=', $maxPrice);
        } else if (isset($minPrice) && isset($maxPrice)) {
            $query = $query->where('price', '>=', $minPrice)
                ->where('price', '<=', $maxPrice);
        }
        $query = $query->paginate(9);
        $query->appends($request->all());
        $category = Category::get();

        return view('user.home')->with(['pizza' => $query, 'category' => $category]);
    }

    // Pizza Details
    public function pizzaDetails($id)
    {
        $pizza = Pizza::where('pizza_id', $id)->first();
        Session::put('PIZZA_INFO', $pizza);
        return view('user.details')->with(['pizza' => $pizza]);
    }

    // Order Page
    public function orderPage()
    {
        $pizza = Session::get('PIZZA_INFO');
        return view('user.order')->with(['pizza' => $pizza]);
    }

    // Create Order
    public function orderCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pizzaCount' => 'required',
            'paymentType' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $pizzaInfo = Session::get('PIZZA_INFO');
        $userId = auth()->user()->id;
        $pizzaCount = $request->pizzaCount;
        $waitingTime = $pizzaInfo->waiting_time * $pizzaCount;

        $data = $this->requestOrderData($request, $pizzaInfo, $userId);

        for ($i = 0; $i < $pizzaCount; $i++) {
            Order::create($data);
        }
        return back()->with(['orderSuccess' => $waitingTime]);
    }

    // PRIVATE Request Order Data
    private function requestOrderData($request, $pizzaInfo, $userId)
    {
        return [
            'customer_id' => $userId,
            'pizza_id' => $pizzaInfo->pizza_id,
            'carrier_id' => 0,
            'payment_status' => $request->paymentType,
            'order_time' => Carbon::now(),
        ];
    }
}
