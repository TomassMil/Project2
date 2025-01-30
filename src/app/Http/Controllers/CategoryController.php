<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function list(): View
    {
        $items = Category::orderBy('name', 'asc')->get();
        return view(
            'category.list',
            [
            'title' => 'Categories',
            'items' => $items,
            ]
        );
    }

    public function create(): View
    {
        return view(
            'category.form',
            [
                'title' => 'Add new category',
                'category' => new Category()
            ]
        );
    }

    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->save();

        return redirect('/categories');
    }

    public function update(Category $category): View
    {
        return view(
            'category.form',
            [
            'title' => 'Edit category',
            'category' => $category
            ]
        );
    }

    public function patch(Category $category, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $validatedData['name'];
        $category->save();

        return redirect('/categories');
    }

    public function delete(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect('/categories');
    }
}
