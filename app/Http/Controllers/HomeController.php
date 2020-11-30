<?php

namespace App\Http\Controllers;

//use bSecure\UniversalCheckout\Controllers\Orders\CreateOrderController;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function cart()
    {
        return view('order');
    }

    public function createOrder(Request $request)
    {
        $requestData = $request->all();
//        $order = new CreateOrderController();
//        return $order->create($requestData);
        return $requestData;
    }
}
