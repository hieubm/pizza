<?php

namespace App\Http\Controllers;

use App\Pizza;
use Validator;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pizzas = Pizza::all();

        return [
            'status' => true,
            'pizzas' => $pizzas,
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
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'required|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->errors(),
            ];
        } else {
            $pizza = Pizza::create($request->all());
            if ($pizza) {
                return [
                    'status' => true,
                    'pizza' => $pizza,
                ];
            } else {
                return [
                    'status' => false,
                ];
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function show(Pizza $pizza)
    {
        return [
            'status' => true,
            'pizza' => $pizza,
        ];
    }

}
