<?php

namespace App\Http\Controllers\Admin\Database;

use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\ServerException;
use Mj\PocketCore\Request;

class DatabaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    // Display the backup form
    public function backupIndex()
    {
        return view('admin.database.backup');
    }

    // Handle the backup creation and download
    public function backupDownload(Request $request)
    {
        try {
            // Ensure the backup procedure is defined and accessible
            $sql = "CALL backup_database()";
            $pdo = $this->database->getPDO();
            $stmt = $pdo->query($sql);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $command = $result['command'];

            // Execute the shell command to create the backup
            exec($command, $output, $return_var);

            if ($return_var !== 0) {
                throw new ServerException('Backup failed');
            }

            // Search for the latest backup file in the temporary directory
            $backupFiles = glob('/tmp/*.sql');
            if (empty($backupFiles)) {
                throw new ServerException('Backup file not found');
            }

            // Sort files by modification time (latest first)
            array_multisort(array_map('filemtime', $backupFiles), SORT_DESC, $backupFiles);

            // Get the latest backup file
            $latestBackup = reset($backupFiles);

            // Set headers for the response
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($latestBackup) . '"');
            header('Content-Length: ' . filesize($latestBackup));

            // Output the file content
            readfile($latestBackup);

            // Exit to prevent further output
            exit;
        } catch (\Exception $e) {
            throw new ServerException($e);
        }
    }

    // Display the recovery form
    public function recoveryIndex()
    {
        return view('admin.database.recovery');
    }

    // Handle the recovery process
    public function recoveryUpload(Request $request)
    {
        try {
            // Check if the file was uploaded
            if ($request->hasFile('backup_file')) {
                $file = $request->file('backup_file');
                $fileName = $file->getClientOriginalName();
                $filePath = "/tmp/" . $fileName;

                // Move the uploaded file to the temporary directory
                if ($file->move("/tmp/", $fileName)) {
                    // Ensure the restore procedure is defined and accessible
                    $sql = "CALL restore_database('$filePath')";
                    $pdo = $this->database->getPDO();
                    $stmt = $pdo->query($sql);
                    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                    $command = $result['command'];

                    // Execute the shell command to restore the backup
                    exec($command, $output, $return_var);

                    if ($return_var !== 0) {
                        throw new ServerException('Restore failed');
                    }

                    // Delete the temporary backup file
                    unlink($filePath);

                    // Redirect to a success page or display a success message
                    return redirect('/admin-panel/database/recovery');
                } else {
                    throw new ServerException('Failed to move uploaded file');
                }
            } else {
                throw new ServerException('File upload error', 400);
            }
        } catch (\Exception $e) {
            throw new ServerException($e);
        }
    }
}