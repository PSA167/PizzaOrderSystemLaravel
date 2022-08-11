<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    /// direct admin Pizza page
    public function pizza()
    {
        if (Session::has('PIZZA_DOWNLOAD')) {
            Session::forget('PIZZA_DOWNLOAD');
        }

        $data = Pizza::paginate(7);
        if (count($data) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        return view('admin.pizza.list')->with(['pizza' => $data, 'status' => $emptyStatus]);
    }

    // Direct Create Pizza Page
    public function createPizza()
    {
        $data = Category::get();
        if (count($data) == 0) {
            return redirect()->route('admin#category')->with(['pizzaError' => 'Need at least one category to create pizza!!!']);
        } else {
            return view('admin.pizza.create')->with(['category' => $data]);
        }
    }

    // Insert Pizza
    public function insertPizza(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'publish' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('image');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path() . '/uploads/', $fileName);

        $data = $this->requestPizzaData($request, $fileName);
        Pizza::create($data);
        return redirect()->route('admin#pizza')->with(['createSuccess' => 'Pizza Created!']);
    }

    // Delete Pizza
    public function deletePizza($id)
    {
        $data = Pizza::select('image')->where('pizza_id', $id)->first();
        $fileName = $data['image'];
        Pizza::where('pizza_id', $id)->delete();

        // project file delete
        if (File::exists(public_path() . '/uploads/' . $fileName)) {
            File::delete(public_path() . '/uploads/' . $fileName);
        }

        return back()->with(['deleteSuccess' => 'Delete Success!']);
    }

    // Pizza Info Detail
    public function infoPizza($id)
    {
        $data = Pizza::where('pizza_id', $id)->first();
        return view('admin.pizza.info')->with(['pizza' => $data]);
    }

    // Edit Pizza
    public function editPizza($id)
    {
        $category = Category::get();
        $data = Pizza::select('pizzas.*', 'categories.category_name')
            ->join('categories', 'categories.category_id', 'pizzas.category_id')
            ->where('pizza_id', $id)
            ->first();
        return view('admin.pizza.edit')->with(['pizza' => $data, 'category' => $category]);
    }

    // Update Pizza
    public function updatePizza($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'publish' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = $this->requestUpdatePizzaData($request);

        if (isset($updateData['image'])) {
            // get old image
            $data = Pizza::select('image')->where('pizza_id', $id)->first();
            $fileName = $data['image'];

            // delete old image
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }

            // get new image
            $file = $updateData['image'];
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // upload new image
            $file->move(public_path() . '/uploads/', $fileName);
            $updateData['image'] = $fileName;
        }
        // update
        Pizza::where('pizza_id', $id)->update($updateData);
        return redirect()->route('admin#pizza')->with(['updateSuccess' => 'Pizza Updated!']);
    }

    // Search Pizza
    public function searchPizza(Request $request)
    {
        $searchKey = $request->tableSearch;
        $searchData = Pizza::orWhere('pizza_name', 'like', '%' . $searchKey . '%')
            ->orWhere('price', $searchKey)
            ->paginate(2);
        Session::put('PIZZA_SEARCH', $request->tableSearch);
        $searchData->appends($request->all());

        if (count($searchData) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        return view('admin.pizza.list')->with(['pizza' => $searchData, 'status' => $emptyStatus]);
    }

    // Download Pizza
    public function pizzaDownload()
    {
        if (Session::has('PIZZA_SEARCH')) {
            $pizza = Pizza::orWhere('pizza_name', 'like', '%' . Session::get('PIZZA_SEARCH') . '%')
                ->orWhere('price', Session::get('PIZZA_SEARCH'))
                ->get();
        } else {
            $pizza = Pizza::get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($pizza) {
            if ($pizza->publish_status == 1) {
                $pizza->publish_status = "Publish";
            } elseif ($pizza->publish_status == 0) {
                $pizza->publish_status = "Unpublish";
            }

            if ($pizza->buy_one_get_one_status == 1) {
                $pizza->buy_one_get_one_status = "Yes";
            } elseif ($pizza->buy_one_get_one_status == 0) {
                $pizza->buy_one_get_one_status = "No";
            }
        });

        $csvExporter->build($pizza, [
            'pizza_id' => 'No',
            'pizza_name' => 'Pizza Name',
            'publish_status' => 'Publish Status',
            'buy_one_get_one_status' => 'Buy One Get One',
            'created_at' => 'Created Date',
            'updated_at' => 'updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'pizzaList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Request Update Pizza Data
    private function requestUpdatePizzaData($request)
    {
        $arr = [
            'pizza_name' => $request->name,
            'price' => $request->price,
            'publish_status' => $request->publish,
            'category_id' => $request->category,
            'discount_price' => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time' => $request->waitingTime,
            'description' => $request->description,
            'updated_at' => Carbon::now(),
        ];

        if (isset($request->image)) {
            $arr['image'] = $request->image;
        }

        return $arr;
    }

    // Request Pizza Data
    private function requestPizzaData($request, $fileName)
    {
        return [
            'pizza_name' => $request->name,
            'image' => $fileName,
            'price' => $request->price,
            'publish_status' => $request->publish,
            'category_id' => $request->category,
            'discount_price' => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time' => $request->waitingTime,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
