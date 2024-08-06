<?php

namespace App\Http\Controllers\Client;

use App\Models\ContactUs;
use Mj\PocketCore\Controller;

class ContactUsController extends Controller
{
    public function create()
    {
        return view('client.contact');
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'comment' => 'required|min:3|max:255',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect("/contact-us");
        }

        $validatedData = $validation->getValidatedData();

        $contact = (new ContactUs());
        $contact->create([
            'user_id' => auth()->user()->id,
            'comment' => $validatedData['comment'],
        ]);

        return redirect("/");
    }
}