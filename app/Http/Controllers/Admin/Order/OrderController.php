<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\Order;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use TCPDF;

class OrderController extends Controller
{
    public function index()
    {
        $sql = 'SELECT orders.*, users.name as user_name 
                FROM orders
                LEFT JOIN users ON users.id = orders.user_id';
        $orders = (new Order())->query($sql);

        return view('admin.orders.index', compact('orders'));
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

        return view('admin.orders.show', compact(['order', 'products']));
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
        $db = new Database();
        $db->beginTransaction();

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

            $db->commit();

            return redirect('/user-panel/orders');
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Rollback the transaction
            $db->rollback();

            return redirect('/cart');
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

    public function exportAll(string $as)
    {
        $sql = 'SELECT orders.*, users.name as user_name 
                FROM orders
                LEFT JOIN users ON users.id = orders.user_id';
        $orders = (new Order())->query($sql);

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('All Orders Data');
            $pdf->SetHeaderData('', 30, 'All Orders table');
            $pdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="5%">User ID</th><th width="20%">User Name</th><th width="8%">Status</th><th width="10%">Total Price</th><th width="20%">Created At</th></tr>';
            foreach ($orders as $order) {
                $html .= '<tr>';
                $html .= '<td>' . $order->id . '</td>';
                $html .= '<td>' . $order->user_id . '</td>';
                $html .= '<td>' . $order->user_name . '</td>';
                $html .= '<td>' . $order->status . '</td>';
                $html .= '<td>' . $order->price . '$' . '</td>';
                $html .= '<td>' . $order->created_at . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('all_orders_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(array('orientation' => 'landscape'));

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(1000)->addText('Id');
            $table->addCell(2000)->addText('User ID');
            $table->addCell(5000)->addText('User Name');
            $table->addCell(2000)->addText('Status');
            $table->addCell(3000)->addText('Total Price');
            $table->addCell(5000)->addText('Created At');

            foreach ($orders as $order) {
                $table->addRow();
                $table->addCell(1000)->addText($order->id);
                $table->addCell(2000)->addText($order->user_id);
                $table->addCell(5000)->addText($order->user_name);
                $table->addCell(2000)->addText($order->status);
                $table->addCell(3000)->addText($order->price . '$');
                $table->addCell(5000)->addText($order->created_at);
            }

            $writer = new Word2007($phpWord);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="all_orders_data.docx"');
            $writer->save('php://output');
        } elseif ($as === 'excel') {
            // Export to Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'User ID');
            $sheet->setCellValue('C1', 'User Name');
            $sheet->setCellValue('D1', 'Status');
            $sheet->setCellValue('E1', 'Total Price');
            $sheet->setCellValue('F1', 'Created At');

            $row = 2;
            foreach ($orders as $order) {
                $sheet->setCellValue('A' . $row, $order->id);
                $sheet->setCellValue('B' . $row, $order->user_id);
                $sheet->setCellValue('C' . $row, $order->user_name);
                $sheet->setCellValue('D' . $row, $order->status);
                $sheet->setCellValue('E' . $row, $order->price . '$');
                $sheet->setCellValue('F' . $row, $order->created_at);
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="all_orders_data.xlsx"');
            $writer->save('php://output');
        }
    }

    public function exportShow(int $orderId, string $as)
    {
        $sql = "SELECT orders.*, products.*, order_product.quantity, products.price, calculate_total_price(products.price, order_product.quantity) as total_price
                FROM orders
                LEFT JOIN order_product ON orders.id = order_product.order_id
                LEFT JOIN products ON order_product.product_id = products.id
                WHERE orders.id = :orderId";
        $products = (new Order())->query($sql, ['orderId' => $orderId]);

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Show Order Data');
            $pdf->SetHeaderData('', 30, 'Show Order table');
            $pdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="20%">Product Name</th><th width="10%">Image</th><th width="10%">Price</th><th width="8%">Quantity</th></tr>';
            $totalPrice = 0;
            foreach ($products as $product) {
                $totalPrice += $product->total_price;
                $html .= '<tr>';
                $html .= '<td>' . $product->id . '</td>';
                $html .= '<td>' . $product->name . '</td>';
                $html .= '<td><img src="' . 'storage/app/product/' . $product->image . '"style="max-width: 100px; max-height: 100px;"></td>';
                $html .= '<td>' . $product->price . '$' . '</td>';
                $html .= '<td>' . $product->quantity . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $html .= '<h3>' . 'Total Price: ' . $totalPrice . '$' . '</h3>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('show_order_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(array('orientation' => 'landscape'));

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(1000)->addText('Id');
            $table->addCell(5000)->addText('Product Name');
            $table->addCell(3000)->addText('Image');
            $table->addCell(2000)->addText('Price');
            $table->addCell(2000)->addText('Quantity');

            $totalPrice = 0;
            foreach ($products as $product) {
                $totalPrice += $product->total_price;
                $table->addRow();
                $table->addCell(1000)->addText($product->id);
                $table->addCell(5000)->addText($product->name);
                $table->addCell(3000)->addImage('storage/app/product/' . $product->image, array('width' => 100, 'height' => 100));
                $table->addCell(2000)->addText($product->price . '$');
                $table->addCell(2000)->addText($product->quantity);
            }

            $section->addTextBreak(2);
            $section->addText('Total Price: ' . $totalPrice . '$', array('bold' => true, 'size' => 14));

            $writer = new Word2007($phpWord);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="show_order_data.docx"');
            $writer->save('php://output');
        } elseif ($as === 'excel') {
            // Export to Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Product Name');
            $sheet->setCellValue('C1', 'Image');
            $sheet->setCellValue('D1', 'Price');
            $sheet->setCellValue('E1', 'Quantity');
            $sheet->setCellValue('F1', 'Total Price');

            $row = 2;
            $totalPrice = 0;
            foreach ($products as $product) {
                $totalPrice += $product->total_price;
                $sheet->setCellValue('A' . $row, $product->id);
                $sheet->setCellValue('B' . $row, $product->name);
                $sheet->setCellValue('C' . $row, $product->image);
                $sheet->setCellValue('D' . $row, $product->price . '$');
                $sheet->setCellValue('E' . $row, $product->quantity);
                $sheet->setCellValue('F' . $row, $product->total_price . '$');
                $row++;
            }

            $sheet->setCellValue('A' . $row, 'Total Price:');
            $sheet->setCellValue('F' . $row, $totalPrice . '$');

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="show_product_data.xlsx"');
            $writer->save('php://output');
        }
    }
}