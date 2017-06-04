<?php

namespace App\Http\Controllers;

use App\Order;
use App\Pizza;
use App\OrderPizza;
use Validator;
use DB;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $respose;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::all();

        $status = $request->get('status');
        if ($status) {
            $orders = $orders->where('status', $status);
        }

        return [
            'status' => true,
            'orders' => $orders,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|max:255',
            'customer_address' => 'required|max:255',
            'customer_phone' => 'required|max:20',
            'note' => 'required|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->errors(),
            ];
        }
        DB::beginTransaction();
        try {
            $order = Order::create($request->all());
            if (!$order) {
                throw new Exception();
            }

            $pizzas = array_unique($request->get('pizzas'));
            $order->total = 0;

            foreach ($pizzas as $pizzaId) {
                $pizza = Pizza::find($pizzaId);
                if (!$pizza) {
                    throw new Exception('Pizza not found');
                }

                $orderPizza = new OrderPizza();
                $orderPizza->order_id = $order->id;
                $orderPizza->pizza_id = $pizza->id;
                $orderPizza->price = $pizza->price;
                if (!$orderPizza->save()) {
                    throw new Exception();
                }

                $order->total += $orderPizza->price;
            }

            $order->save();
            DB::commit();

            return [
                'status' => true,
                'order' => $order,
            ];

        } catch (Exception $e) {
            DB::rollback();

            return [
                'status' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $rules = [
            'status' => 'required|in:delivering,completed',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->errors(),
            ];
        }

        $order->status = $request->get('status');
        if ($order->save()) {
            return [
                'status' => true,
                'order' => $order,
            ];
        }

        return [
            'status' => false,
        ];
    }
}
