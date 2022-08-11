<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /// direct admin User List page
    public function userList()
    {
        if (Session::has('USER')) {
            Session::forget('USER');
        }
        $data = User::where('role', 'user')->paginate(7);
        return view('admin.user.userList')->with(['user' => $data]);
    }

    /// direct admin Admin List page
    public function adminList()
    {
        if (Session::has('ADMIN')) {
            Session::forget('ADMIN');
        }
        $data = User::where('role', 'admin')->paginate(7);
        return view('admin.user.adminList')->with(['admin' => $data]);
    }

    // Search User List
    public function userSearch(Request $request)
    {
        $response = $this->search($request, 'user');
        $user = $response->items();
        Session::put('USER', $user);
        return view('admin.user.userList')->with(['user' => $response]);
    }

    // Search Admin List
    public function adminSearch(Request $request)
    {
        $response = $this->search($request, 'admin');
        $admin = $response->items();
        Session::put('ADMIN', $admin);
        return view('admin.user.adminList')->with(['admin' => $response]);
    }

    // User Delete
    public function userDelete($id)
    {
        $data = User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'User Deleted!']);
    }

    // Search Data
    private function search($request, $role)
    {
        $key = $request->tableSearch;
        $searchData = User::where('role', $role)
            ->where(function ($query) use ($key) {
                $query->orwhere('name', 'like', '%' . $key . '%')
                    ->orwhere('email', 'like', '%' . $key . '%')
                    ->orwhere('phone', 'like', '%' . $key . '%')
                    ->orwhere('address', 'like', '%' . $key . '%');
            })
            ->paginate(7);
        $searchData->appends($request->all());
        return $searchData;
    }

    // Download User
    public function userDownload()
    {
        if (Session::has('USER')) {
            $user = collect(Session::get('USER'));
        } else {
            $user = User::where('role', 'user')->get();
        }
        return $this->csvDownload($user);
    }

    // Download Admin
    public function adminDownload()
    {
        if (Session::has('ADMIN')) {
            $admin = collect(Session::get('ADMIN'));
        } else {
            $admin = User::where('role', 'admin')->get();

        }

        return $this->csvDownload($admin);
    }

    // Csv Downloader
    private function csvDownload($data)
    {
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($data, [
            'id' => 'No',
            'name' => 'User Name',
            'email' => 'User Email',
            'phone' => 'User Phone',
            'address' => 'User Address',
            'role' => 'User Role',
            'created_at' => 'Created Date',
            'updated_at' => 'updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'userList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Edit user
    public function userEdit($id)
    {
        $data = User::where('id', $id)->first();
        return view('admin.user.edit')->with(['user' => $data]);
    }

    // User Change Role
    public function userChangeRole(Request $request)
    {
        $check = User::where('role', 'admin')->get();
        $data = ['role' => $request->role];
        $id = $request->id;
        if (auth()->user()->id == $id) {
            if (count($check) > 1) {
                User::where('id', $id)->update($data);
                return redirect()->route('user#index');
            } else {
                return redirect()->route('admin#adminList')->with(['errorChange' => 'Need at least One Admin to maintain this Order System!']);
            }
        } else {
            User::where('id', $id)->update($data);
            return redirect()->route('admin#' . $request->role . 'List')->with(['changeRole' => 'User Role Changed!']);
        }
    }
}
