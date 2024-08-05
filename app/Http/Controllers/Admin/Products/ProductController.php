<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;
use TCPDF;


class ProductController extends Controller
{
    public function index()
    {
        $sql = "SELECT * FROM product_index";

        $products = (new Product())->query($sql);

        return view('admin.products.index', compact('products'));
    }

    public function show(int $userId)
    {

    }

    public function create()
    {
        $categories = (new Category())->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'categories' => 'required|array',
                'description' => 'required|max:255',
                'specification' => 'required|max:255',
                'price' => 'required|numeric|min:0',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/products/create');
        }

        $validatedData = $validation->getValidatedData();
        $categories = $validatedData['categories'];
        unset($validatedData['categories']);

        // Start a new transaction
        $db = Database::getInstance();
        $pdo = $db->getPDO();
        $pdo->beginTransaction();

        try {
            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->move('storage/app/product', $imageName);

                // Save the image name in the database
                $validatedData['image'] = $imageName;
            }
            $product = new Product();
            $product->create([...$validatedData]);

            $product = $product
                ->where('name', $validatedData['name'])
                ->where('description', $validatedData['description'])
                ->where('specification', $validatedData['specification'])
                ->where('price', $validatedData['price'])
                ->first();

            foreach ($categories as $category) {
                $product->attachCategories($category);
            }

            // Commit the transaction
            $pdo->commit();

            return redirect('/admin-panel/products');
        } catch (\Exception $e) {
            error_log($e->getMessage());

            // Rollback the transaction
            $pdo->rollback();

            throw new ServerException('Create Product failed!');
        }
    }

    public function edit(int $productId)
    {
        $product = (new Product())->find($productId);
        $categories = (new Category())->get();
        $productCategoryIds = $product->getCategoryIds();

        return view('admin.products.edit', compact(
            'product', 'categories', 'productCategoryIds'
        ));
    }

    public function update()
    {
        if (request()->has('product_id')) {
            $product = (new Product())->find(request()->input('product_id'));
            $validation = $this->validate(
                request()->all(),
                [
                    'name' => 'required|min:3|max:255',
                    'categories' => 'required|array',
                    'description' => 'required|max:255',
                    'specification' => 'required|max:255',
                    'price' => 'required|numeric|min:0',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/products/edit/' . $product->id);
            }

            $validatedData = $validation->getValidatedData();
            $categories = $validatedData['categories'];
            unset($validatedData['categories']);

            // Start a new transaction
            $db = Database::getInstance();
            $pdo = $db->getPDO();
            $pdo->beginTransaction();

            try {
                if (request()->hasFile('image')) {
                    $image = request()->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();

                    // Delete the old image file if it exists
                    if ($product->image) {
                        $oldImagePath = 'storage/app/product/' . $product->image;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $image->move('storage/app/product', $imageName);

                    // Save the image name in the database
                    $validatedData['image'] = $imageName;
                }
                $product->update($product->id, [...$validatedData]);

                // Detach all existing categories
                $product->detachAllCategories();

                // Attach new categories
                foreach ($categories as $category) {
                    $product->attachCategories($category);
                }

                // Commit the transaction
                $pdo->commit();

                return redirect('/admin-panel/products');
            } catch (\Exception $e) {
                error_log($e->getMessage());

                // Rollback the transaction
                $pdo->rollback();

                throw new ServerException('Update Product failed!');
            }
        }

        return new NotFoundException('product_id is not exist!');
    }

    public function delete()
    {
        if (request()->has('product_id') && $product = (new Product())->find(request()->input('product_id'))) {

            // Start a new transaction
            $db = Database::getInstance();
            $pdo = $db->getPDO();
            $pdo->beginTransaction();

            try {
                $product->detachAllCategories();
                $product->delete($product->id);

                // Commit the transaction
                $pdo->commit();

                return redirect('/admin-panel/products');
            } catch (\Exception $e) {
                error_log($e->getMessage());

                // Rollback the transaction
                $pdo->rollback();

                throw new ServerException('Delete Product failed!');
            }
        }

        throw new NotFoundException('This product does not exist!');
    }

    public function export(string $as)
    {
        $sql = "SELECT * FROM product_index";
        $products = (new Product())->query($sql);

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Products Data');
            $pdf->SetHeaderData('', 30, 'Products table');
            $pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="15%">Name</th><th width="10%">Categories</th><th width="20%">Description</th><th width="10%">Specification</th><th width="10%">Image</th><th width="10%">Price</th><th width="5%">Like</th><th width="10%">Created At</th></tr>';            foreach ($products as $product) {
                $html .= '<tr>';
                $html .= '<td>' . $product->id . '</td>';
                $html .= '<td>' . $product->name . '</td>';
                $html .= '<td>' . $product->categories . '</td>';
                $html .= '<td>' . $product->description . '</td>';
                $html .= '<td>' . $product->specification . '</td>';
                $html .= '<td><img src="' . 'storage/app/product/' . $product->image . '"style="max-width: 100px; max-height: 100px;"></td>';
                $html .= '<td>' . $product->price . '$' . '</td>';
                $html .= '<td>' . $product->likes . '</td>';
                $html .= '<td>' . $product->created_at . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('products_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
        } elseif ($as === 'excel') {
            // Export to Excel
        }
    }
}