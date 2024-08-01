<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        // $id = $request->update_id;

        $validator = Validator::make($request->all(), [
            'update_name' => 'required',
        ], [
            'update_name.required' => 'The name field is required.',
        ]);

        if ($validator->passes()) {
            Category::query()
                ->where('id', $id)
                ->update([
                    'name' => $request->update_name,
                ]);

            $message = 'Category updated successfully!';
            session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
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

    public function setStatus(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);

        if ($category == NULL) {
            $message = 'Either category was deleted or you are not authorized to change status of this category!';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $category->status = !$category->status;
        $category->save();

        $message = 'Category status changed successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}