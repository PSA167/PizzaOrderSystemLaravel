<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    // Category List
    public function categoryList()
    {
        $category = Category::get();

        $response = [
            'status' => 'success',
            'data' => $category,
        ];

        return Response::json($response);
    }

    // Create Category
    public function categoryCreate(Request $request)
    {
        $data = [
            'category_name' => $request->categoryName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        Category::create($data);

        $response = [
            'status' => 200,
            'message' => 'success',
        ];

        return Response::json($response);
    }

    // Category Details
    public function categoryDetails(Request $request)
    {
        $id = $request->id;
        $data = Category::where('category_id', $id)->first();

        $response = [
            'status' => 200,
            'message' => 'success',
            'data' => $data,
        ];

        if (empty($data)) {
            $response['message'] = 'fail';
        }

        return Response::json($response);
    }

    // Category Details
    public function categoryDelete($id)
    {
        $data = Category::where('category_id', $id)->first();
        if (empty($data)) {
            return Response::json([
                'status' => 200,
                'message' => 'There is no such data table',
            ]);
        }

        Category::where('category_id', $id)->delete();

        return Response::json([
            'status' => 200,
            'message' => 'success',
        ]);
    }

    // Category Update
    public function categoryUpdate(Request $request)
    {
        $updateData = [
            'category_id' => $request->id,
            'category_name' => $request->categoryName,
            'created_at' => Carbon::now(),
        ];

        $check = Category::where('category_id', $request->id)->first();

        if (isset($check)) {
            Category::where('category_id', $request->id)->update($updateData);
            return Response::json([
                'status' => 200,
                'message' => 'success',
            ]);
        }

        return Response::json([
            'status' => 200,
            'message' => 'There is no such data in table',
        ]);

    }
}
