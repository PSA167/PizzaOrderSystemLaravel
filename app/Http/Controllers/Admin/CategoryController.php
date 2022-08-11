<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /// direct admin Category page
    public function category()
    {
        if (Session::has('CATEGORY_SEARCH')) {
            Session::forget('CATEGORY_SEARCH');
        }
        $data = Category::select('categories.*', DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas', 'pizzas.category_id', 'categories.category_id')
            ->groupBy('categories.category_id')
            ->paginate(7);
        return view('admin.category.list')->with(['category' => $data]);
    }

    /// direct admin AddCategory page
    public function addCategory()
    {
        return view('admin.category.addCategory');
    }

    // Create Category
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Pizza name required!',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'category_name' => $request->name,
        ];

        Category::create($data);
        return redirect()->route('admin#category')->with(['successCreate' => 'Category Added!']);
    }

    // Delete Category
    public function deleteCategory($id)
    {
        Category::where('category_id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Category Deleted!']);
    }

    // Edit Category
    public function editCategory($id)
    {
        $data = Category::where('category_id', $id)->first();
        return view('admin.category.updateCategory')->with(['category' => $data]);
    }

    // Update Category
    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Name required!!!',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'category_name' => $request->name,
        ];

        Category::where('category_id', $request->id)->update($data);
        return redirect()->route('admin#category')->with(['updateSuccess' => 'Category Updated!']);
    }

    // Search Category
    public function searchCategory(Request $request)
    {
        $data = Category::select('categories.*', DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas', 'pizzas.category_id', 'categories.category_id')
            ->where('category_name', 'like', '%' . $request->searchData . '%')
            ->groupBy('categories.category_id')
            ->paginate(7);
        Session::put('CATEGORY_SEARCH', $request->searchData);
        $data->appends($request->all());
        return view('admin.category.list')->with(['category' => $data]);
    }

    // Category Product Count Show
    public function categoryItem($id)
    {
        $data = Pizza::select('pizzas.*', 'categories.category_name as categoryName')
            ->join('categories', 'categories.category_id', 'pizzas.category_id')
            ->where('pizzas.category_id', $id)
            ->paginate(5);
        return view('admin.category.item')->with(['pizza' => $data]);
    }

    // Download Category
    public function categoryDownload()
    {
        if (Session::has('CATEGORY_SEARCH')) {
            $category = Category::select('categories.*', DB::raw('COUNT(pizzas.category_id) as count'))
                ->leftJoin('pizzas', 'pizzas.category_id', 'categories.category_id')
                ->where('category_name', 'like', '%' . Session::get('CATEGORY_SEARCH') . '%')
                ->groupBy('categories.category_id')
                ->get();

        } else {
            $category = Category::select('categories.*', DB::raw('COUNT(pizzas.category_id) as count'))
                ->leftJoin('pizzas', 'pizzas.category_id', 'categories.category_id')
                ->groupBy('categories.category_id')
                ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($category, [
            'category_id' => 'ID',
            'category_name' => 'Category Name',
            'count' => 'Product Count',
            'created_at' => 'Created Date',
            'updated_at' => 'updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'categoryList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
