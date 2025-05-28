<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessOrderJob;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Step 1: Create Order
            $order = Order::create([
                'user_id' => auth()->id() ?? 1,
                'total' => $request->total,
                'status' => 'pending',
            ]);

            // Step 2: Create Order Items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            // Step 3: Dispatch async job
            ProcessOrderJob::dispatch($order);

            return response()->json(['message' => 'Order created successfully.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create order', 'message' => $e->getMessage()], 500);
        }
    }
}
