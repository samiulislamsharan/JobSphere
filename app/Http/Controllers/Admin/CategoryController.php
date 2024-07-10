<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);

        if ($category == NULL) {
            $message = 'Either category was deleted or you are not authorized to delete this category!';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $category->delete();

        $message = 'Category deleted successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}