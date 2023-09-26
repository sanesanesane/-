<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function create()
    {
        $categories = Category::all();  // カテゴリの一覧を取得
        return view('categories.create', compact('categories')); // カテゴリ作成のビューファイルへのパスと一緒に$categoriesを渡す
    }
    

    public function store(Request $request)
    {
        
    $request->validate([
    'name' => ['required', 'string', 'max:255', Rule::unique('categories')->whereNull('deleted_at')],
], 
[
    'name.required' => 'カテゴリ名は必須です。',
    'name.unique' => 'このカテゴリ名はすでに存在します。',
]);

        $category = new Category;
        $category->name = $request->name;
        $category->user_id = auth()->id();
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }
    
public function edit(Category $category)
{
    return view('categories.edit', compact('category'));
}


public function update(Request $request, Category $category)
{
    $category->update($request->all());
    return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
}

public function destroy(Category $category)
{
    $category->delete();
    return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
}


}

