<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\Permission;
use App\Models\User;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;
use Mj\PocketCore\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use TCPDF;

class UserController extends Controller
{
    public function index()
    {
        $sql = "SELECT * FROM user_index";
        $users = (new User())->query($sql);

        return view('admin.users.index', compact('users'));
    }

    public function admin()
    {
        $sql = "SELECT users.*, GROUP_CONCAT(permissions.name) as permissions
            FROM users
            LEFT JOIN permission_user ON users.id = permission_user.user_id
            LEFT JOIN permissions ON permission_user.permission_id = permissions.id
            WHERE users.id IN (
                SELECT user_id
                FROM permission_user
                JOIN permissions ON permission_user.permission_id = permissions.id
                WHERE permissions.name = 'admin'
            )
            GROUP BY users.id
            ";
        $users = (new User())->query($sql);

        return view('admin.users.index', compact('users'));
    }

    public function show(int $userId)
    {

    }

    public function create()
    {
        $permissions = (new Permission())->get();

        return view('admin.users.create', compact('permissions'));
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|email||max:255|unique:users,email',
                'password' => 'required|min:6||max:255',
                'confirm_password' => 'required|same:password',
                'permissions' => 'array',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/users/create');
        }

        $validatedData = $validation->getValidatedData();
        $validatedPermissions = $validatedData['permissions'];

        unset($validatedData['confirm_password']);
        unset($validatedData['permissions']);

        // Start a new transaction
        $db = Database::getInstance();
        $pdo = $db->getPDO();
        $pdo->beginTransaction();

        try {
            $user = (new User());
            $user->create([
                ...$validatedData,
                'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT)
            ]);

            // Attach permissions to the user
            if (!empty($validatedPermissions)) {
                foreach ($validatedPermissions as $key => $permissionId) {
                    $user->attachPermission($permissionId);
                }
            }

            $pdo->commit();

            return redirect('/admin-panel/users');
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Rollback the transaction
            $pdo->rollback();

            throw new ServerException('Create User failed!');
        }
    }

    public function edit(int $userId)
    {
        $user = (new User())->find($userId);
        $allPermissions = (new Permission())->get();

        $userPermissions = $user->permissions();

        return view('admin.users.edit',
            compact('user', 'allPermissions', 'userPermissions')
        );
    }

    public function update()
    {
        if (request()->has('user_id')) {
            $userId = request()->input('user_id');
            $user = (new User())->find($userId);
            $validation = $this->validate(
                request()->all(),
                [
                    'user_id' => 'required|numeric|exists:users,id',
                    'name' => 'required|min:3|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->email,
                    'password' => 'min:6|max:255',
                    'confirm_password' => 'same:password',
                    'permissions' => 'array',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/users/edit/' . $userId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedUserId = $validatedData['user_id'];
            $validatedPermissions = $validatedData['permissions'];

            unset($validatedData['user_id']);
            unset($validatedData['confirm_password']);
            unset($validatedData['permissions']);


            if (empty($validatedData['password'])) {
                unset($validatedData['password']);
            } else {
                $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);
            }

            // Start a new transaction
            $db = Database::getInstance();
            $pdo = $db->getPDO();
            $pdo->beginTransaction();

            try {
                $user = (new User())->find($validatedUserId);
                if ($user) {
                    $user->update($validatedUserId, [...$validatedData]);

                    // Detach all existing permissions
                    $user->detachAllPermissions();

                    // Attach new permissions
                    foreach ($validatedPermissions as $permissionId) {
                        $user->attachPermission($permissionId);
                    }

                    // Commit the transaction
                    $pdo->commit();

                    return redirect('/admin-panel/users');
                }

                throw new NotFoundException('This user does not exist!');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $pdo->rollback();

                throw new ServerException('Update user failed!');
            }
        }

        throw new NotFoundException('This User Id does not exist!');
    }

    public function delete()
    {
        if (request()->has('user_id')) {
            $db = Database::getInstance();
            $pdo = $db->getPDO();
            $pdo->beginTransaction();

            try {
                $userId = request()->input('user_id');
                $user = (new User())->find($userId);
                // Detach all existing permissions
                $user->detachAllPermissions();
                $user->delete($userId);

                $pdo->commit();

                return redirect('/admin-panel/users');
            } catch (\Exception $exception) {
                $pdo->rollBack();

                throw new ServerException('Delete user failed!');
            }
        }

        throw new NotFoundException('This User Id does not exist!');
    }

    public function createAdmin()
    {
        $user = (new User())->find('admin@gmail.com', 'email');

        if (!$user) {
            $admin = (new User());
            $admin->create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$9/MqqIbeJomr3mqhIrQFuO89k/ghsUqa0FRsfwg8NpldE0tQqkv8O' // password
            ]);

            $permission = (new Permission());
            $permission->create([
                'name' => 'admin',
                'label' => 'admin'
            ]);

            $admin->attachPermission($permission->id);

            return redirect('/auth/login');
        }

        return redirect('/');
    }

    public function export(string $as)
    {
        $sql = "SELECT * FROM user_index";
        $users = (new User())->query($sql);

        if ($as === 'pdf') {
            // Export to PDF
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Users Data');
            $pdf->SetHeaderData('', 30, 'Users table');
            $pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(10.0, 20.0, 10.0);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();

            $html = '<table border="1" cellpadding="5">';
            $html .= '<tr><th width="5%">Id</th><th width="20%">User Name</th><th width="20%">Email</th><th width="20%">Date</th><th width="35%">Permissions</th></tr>';
            foreach ($users as $user) {
                $html .= '<tr>';
                $html .= '<td>' . $user->id . '</td>';
                $html .= '<td>' . $user->name . '</td>';
                $html .= '<td>' . $user->email . '</td>';
                $html .= '<td>' . $user->created_at . '</td>';
                $html .= '<td>' . $user->permissions . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('users_data.pdf', 'D');

        } elseif ($as === 'word') {
            // Export to Word
            $phpWord = new PhpWord();
            $section = $phpWord->addSection(array('orientation' => 'landscape'));

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(500)->addText('Id');
            $table->addCell(2200)->addText('User Name');
            $table->addCell(3600)->addText('Email');
            $table->addCell(2000)->addText('Date');
            $table->addCell(5000)->addText('Permissions');

            foreach ($users as $user) {
                $table->addRow();
                $table->addCell(500)->addText($user->id);
                $table->addCell(2200)->addText($user->name);
                $table->addCell(3600)->addText($user->email);
                $table->addCell(2000)->addText($user->created_at);
                $table->addCell(5000)->addText($user->permissions);
            }

            $writer = new Word2007($phpWord);
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="users_data.docx"');
            $writer->save('php://output');
        } elseif ($as === 'excel') {
            // Export to Excel
        }
    }
}