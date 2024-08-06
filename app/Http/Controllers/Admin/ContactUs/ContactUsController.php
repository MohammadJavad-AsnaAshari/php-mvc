<?php

namespace App\Http\Controllers\Admin\ContactUs;

use App\Models\ContactUs;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use PDO;

class ContactUsController extends Controller
{
    public function index()
    {
        $sql = "SELECT contact_us.* , users.name as user_name FROM `contact_us` LEFT JOIN users ON users.id = contact_us.user_id;";
        $db = Database::getInstance();
        $pdo = $db->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // use `cursor` here!
        $contacts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = $row;
        }

        return view('admin.contact.index', compact('contacts'));
    }
}