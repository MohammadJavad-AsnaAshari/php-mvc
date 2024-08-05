<?php

namespace App\Http\Controllers\Admin\Comments;

use App\Models\Comment;
use App\Models\Product;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Exceptions\NotFoundException;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use TCPDF;

class CommentController extends Controller
{
    public function index()
    {
        $sql = "SELECT * FROM comment_index";

        $comments = (new Comment())->query($sql);

        return view('admin.comments.index', compact('comments'));
    }

    public function edit(int $commentId)
    {
        $comment = (new Comment())->find($commentId);

        return view('admin.comments.edit', compact('comment'));
    }

    public function update()
    {
        if (request()->has('comment_id')) {
            $commentId = request()->input('comment_id');
            $comment = (new Comment())->find($commentId);
            $validation = $this->validate(
                request()->all(),
                [
                    'comment' => 'required|min:3|max:255',
                    'status' => 'boolean'
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/comments/edit/' . $commentId);
            }

            $validatedData = $validation->getValidatedData();
            $comment->update($commentId, $validatedData);

            return redirect('/admin-panel/comments');
        }

        throw new NotFoundException('Comment not exist!');
    }

    public function delete()
    {
        if (request()->has('comment_id')) {
            $commentId = request()->input('comment_id');
            (new Comment())->delete($commentId);

            return redirect('/admin-panel/comments');
        }

        return redirect('/admin-panel/comments');
    }

    public function export(string $as)
    {
        $sql = "SELECT * FROM comment_index";
        $comments = (new Comment())->query($sql);

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Comments Data');
            $pdf->SetHeaderData('', 30, 'Comments table');
            $pdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="15%">User Name</th><th width="20%">Product Name</th><th width="30%">Comment</th><th width="8%">Status</th><th width="15%">Created At</th></tr>';
            foreach ($comments as $comment) {
                $html .= '<tr>';
                $html .= '<td>' . $comment->id . '</td>';
                $html .= '<td>' . $comment->user_name . '</td>';
                $html .= '<td>' . $comment->product_name . '</td>';
                $html .= '<td>' . $comment->comment . '</td>';
                $html .= '<td>' . $comment->status . '</td>';
                $html .= '<td>' . $comment->created_at . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('comments_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(array('orientation' => 'landscape'));

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(500)->addText('Id');
            $table->addCell(2000)->addText('User Name');
            $table->addCell(3000)->addText('Product Name');
            $table->addCell(6000)->addText('Comment');
            $table->addCell(500)->addText('Status');
            $table->addCell(2000)->addText('Created At');

            foreach ($comments as $comment) {
                $table->addRow();
                $table->addCell(500)->addText($comment->id);
                $table->addCell(2000)->addText($comment->user_name);
                $table->addCell(3000)->addText($comment->product_name);
                $table->addCell(6000)->addText($comment->comment);
                $table->addCell(500)->addText($comment->status);
                $table->addCell(2000)->addText($comment->created_at);
            }

            $writer = new Word2007($phpWord);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="comments_data.docx"');
            $writer->save('php://output');
        } elseif ($as === 'excel') {
            // Export to Excel
        }
    }
}