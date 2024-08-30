<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;


class OrderController extends Controller
{
    public function creatOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'total_amount' => 'required|numeric',
            'cart_quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error occurred',
                'errors' => $validator->errors(),
            ]);
        }
        try
        {
            DB::beginTransaction();
            $order = new Order();
            $order->customer_name = $request->customer_name;
            $order->total_amount = $request->total_amount;
            if($order->save())
            {
                $cart = new Cart();
                $cart->quantity = $request->cart_quantity;
                dd($cart);
                if($cart->save())
                {
                    DB::commit();
                }
                else{
                    DB::rollBack();
                }
            }
            else{
                DB::rollBack();
            } 
        }
        catch(Exception $e)
        {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Failed to create order and cart',
                'error' => $e->getMessage(),
            ]);
        }
        
    }

}
