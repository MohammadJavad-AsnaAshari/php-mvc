<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Models\Permission;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use TCPDF;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = (new Permission())->get();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'label' => 'required|min:3|max:255',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/permissions/create');
        }

        $validatedData = $validation->getValidatedData();

        (new Permission())->create([...$validatedData]);

        return redirect('/admin-panel/permissions');
    }

    public function edit(int $permissionId)
    {
        $permission = (new Permission())->find($permissionId);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update()
    {
        if (request()->has('permission_id')) {
            $permissionId = request()->input('permission_id');
            $validation = $this->validate(
                request()->all(),
                [
                    'permission_id' => 'required|numeric|exists:permissions,id',
                    'name' => 'required|min:3|max:255',
                    'label' => 'required|min:3|max:255',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/permissions/edit/' . $permissionId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedRoleId = $validatedData['permission_id'];
            unset($validatedData['permission_id']);

            (new Permission())->update($validatedRoleId, [...$validatedData]);

            return redirect('/admin-panel/permissions');
        }

        return redirect('/admin-panel/permissions');
    }

    public function delete()
    {
        if (request()->has('permission_id')) {
            $permissionId = request()->input('permission_id');

            // Start a new transaction
            $db = new Database();
            $db->beginTransaction();

            try {
                $permission = (new Permission())->find($permissionId);

                if ($permission) {
                    // Detach the permission from the permission
                    $permission->detachAllUsers();
                    $permission->delete($permissionId);

                    // Commit the transaction
                    $db->commit();
                }

                return redirect('/admin-panel/permissions');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $db->rollback();

                throw new ServerException('Can not delete permissions!');
            }
        }

        throw new NotFoundException('Permission id not fount!');
    }

    public function export(string $as)
    {
        $permissions = (new Permission())->get();

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Permissions Data');
            $pdf->SetHeaderData('', 30, 'Permissions table');
            $pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="30%">Name</th><th width="30%">Label</th><th width="20%">Date</th></tr>';
            foreach ($permissions as $permission) {
                $html .= '<tr>';
                $html .= '<td>' . $permission->id . '</td>';
                $html .= '<td>' . $permission->name . '</td>';
                $html .= '<td>' . $permission->label . '</td>';
                $html .= '<td>' . $permission->created_at . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('permissions_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(array('orientation' => 'landscape'));

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(1000)->addText('Id');
            $table->addCell(3000)->addText('Name');
            $table->addCell(3000)->addText('Label');
            $table->addCell(2000)->addText('Date');

            foreach ($permissions as $permission) {
                $table->addRow();
                $table->addCell(1000)->addText($permission->id);
                $table->addCell(3000)->addText($permission->name);
                $table->addCell(3000)->addText($permission->label);
                $table->addCell(2000)->addText($permission->created_at);
            }

            $writer = new Word2007($phpWord);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="permissions_data.docx"');
            $writer->save('php://output');
        } elseif ($as === 'excel') {
            // Export to Excel
        }
    }
}