<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\Payment;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;

class OrderController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $orders = (new Order())->where('user_id', $userId)->get();

        return view('client.panel.orders.index', compact('orders'));
    }

    public function show(int $orderId)
    {
        $order = (new Order())->find($orderId);
        $sql = "SELECT orders.*, products.*, order_product.quantity, products.price, calculate_total_price(products.price, order_product.quantity) as total_price
                FROM orders
                LEFT JOIN order_product ON orders.id = order_product.order_id
                LEFT JOIN products ON order_product.product_id = products.id
                WHERE orders.id = :orderId";
        $products = (new Order())->query($sql, ['orderId' => $orderId]);

        return view('client.panel.orders.show', compact(['order', 'products']));
    }


    public function store()
    {
        $cartKey = $this->getCartKey();
        $cart = session()->get($cartKey, []);

        if (empty($cart)) {
            throw new NotFoundException('Your cart can not be empty!');
        }

        $userId = auth()->user()->id;
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Start a new transaction
        $db = Database::getInstance();
        $pdo = $db->getPDO();
        $pdo->beginTransaction();

        try {
            // Create the order
            $orderData = [
                'user_id' => $userId,
                'price' => $totalPrice,];

            $order = new Order();
            $order->create($orderData);

            // Attach products to the order
            foreach ($cart as $item) {
                $order->attachProduct($item['id'], $item['quantity']);
            }

            // Clear the cart
            session()->remove($cartKey);

            $pdo->commit();

            return redirect('/user-panel/orders');
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Rollback the transaction
            $pdo->rollback();

            throw new ServerException('Create Order failed!');
        }
    }

    public function payment()
    {
        if (request()->has('order_id')) {
            $orderId = request()->input('order_id');
            $order = (new Order())->find($orderId);

            if ($order) {
                $order->update($orderId, [
                    'status' => 'paid'
                ]);

                return redirect('/user-panel/orders');
            }

            throw new NotFoundException('This order is not exist!');
        }

        throw new NotFoundException('This order id is not exist!');
    }

    private function getCartKey()
    {
        // Get the currently authenticated user's ID
        $userId = auth()->user()->id;

        return 'cart_user_' . $userId;
    }
}