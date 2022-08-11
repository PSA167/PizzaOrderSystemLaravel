<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // Create Contact User
    public function createContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('user#contact')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $this->requestUserData($request);
        Contact::create($data);
        return redirect('user#contact')->with(['contactSuccess' => 'Message Send!']);
    }

    // Contact List Admin
    public function contactList()
    {
        if (Session::has('CONTACT_SEARCH')) {
            Session::forget('CONTACT_SEARCH');
        }

        $data = Contact::orderByDesc('contact_id')
            ->paginate(7);
        if (count($data) == 0) {
            $status = 0;
        } else {
            $status = 1;
        }

        return view('admin.contact.list')->with(['contact' => $data, 'status' => $status]);
    }

    // Search Contact Admin
    public function searchContact(Request $request)
    {
        $key = $request->searchData;

        $data = Contact::orwhere('name', 'like', '%' . $key . '%')
            ->orwhere('email', 'like', '%' . $key . '%')
            ->orwhere('message', 'like', '%' . $key . '%')
            ->paginate(7);
        Session::put('CONTACT_SEARCH', $data->items());
        $data->appends($request->all());
        return view('admin.contact.list')->with(['contact' => $data]);
    }

    // Download Contact List
    public function contactDownload()
    {
        if (Session::has('CONTACT_SEARCH')) {
            $contact = collect(Session::get('CONTACT_SEARCH'));
        } else {
            $contact = Contact::get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($contact) {

        });

        $csvExporter->build($contact, [
            'contact_id' => 'No',
            'user_id' => 'Customer ID',
            'name' => 'Customer Name',
            'email' => 'Customer Email',
            'message' => 'Message',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'contactList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Request User Data Private
    private function requestUserData($request)
    {
        return [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
    }
}
