<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Models\Category;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use TCPDF;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new Category())->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = (new Category())->get();

        return view('admin.categories.create', compact('categories'));
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255|unique:categories,name',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/categories/create');
        }

        $validatedData = $validation->getValidatedData();

        try {
            $category = new Category();
            $category->create($validatedData);

            return redirect('/admin-panel/categories');
        } catch (\Exception $e) {
            error_log($e->getMessage());

            // Throw an exception to stop further execution
            throw new ServerException('The process not successfully!');
        }
    }

    public function edit(int $categoryId)
    {
        $selfCategory = (new Category())->find($categoryId);

        return view('admin.categories.edit', compact('selfCategory'));
    }

    public function update()
    {
        if (request()->has('category_id')) {
            $categoryId = request()->input('category_id');
            $category = (new Category())->find($categoryId);
            $validation = $this->validate(
                request()->all(),
                [
                    'name' => 'required|min:3|max:255|unique:categories,name,' . $category->name,
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/categories/edit/' . $categoryId);
            }

            $validatedData = $validation->getValidatedData();

            try {
                $category->update($categoryId, $validatedData);

                return redirect('/admin-panel/categories');
            } catch (\Exception $e) {
                error_log($e->getMessage());

                // Throw an exception to stop further execution
                throw new ServerException();
            }
        }

        throw new NotFoundException('This category not fount!');
    }

    public function delete()
    {
        if (request()->has('category_id')) {
            $categoryId = request()->input('category_id');
            (new Category())->delete($categoryId);

            return redirect('/admin-panel/categories');
        }

        throw new NotFoundException('This category not fount!');
    }

    public function export(string $as)
    {
        $categories = (new Category())->get();

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Categories Data');
            $pdf->SetHeaderData('', 30, 'Categories table');
            $pdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="40%">Name</th><th width="20%">Created At</th></tr>';
            foreach ($categories as $category) {
                $html .= '<tr>';
                $html .= '<td>' . $category->id . '</td>';
                $html .= '<td>' . $category->name . '</td>';
                $html .= '<td>' . $category->created_at . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('categories_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(array('orientation' => 'landscape'));

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(500)->addText('Id');
            $table->addCell(5000)->addText('Name');
            $table->addCell(3000)->addText('Created At');

            foreach ($categories as $category) {
                $table->addRow();
                $table->addCell(500)->addText($category->id);
                $table->addCell(5000)->addText($category->name);
                $table->addCell(3000)->addText($category->created_at);
            }

            $writer = new Word2007($phpWord);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="categories_data.docx"');
            $writer->save('php://output');
        } elseif ($as === 'excel') {
            // Export to Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Created At');

            $row = 2;
            foreach ($categories as $category) {
                $sheet->setCellValue('A' . $row, $category->id);
                $sheet->setCellValue('B' . $row, $category->name);
                $sheet->setCellValue('C' . $row, $category->created_at);
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="categories_data.xlsx"');
            $writer->save('php://output');
        }
    }
}