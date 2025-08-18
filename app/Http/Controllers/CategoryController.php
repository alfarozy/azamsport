<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::with(['products'])->latest()->get();
        return view('backoffice.category.index', compact('data'));
    }


    public function create()
    {
        return view('backoffice.category.create');
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'name'      => 'required',
        ]);
        $attr['slug'] = Str()->slug($attr['name']);
        Category::create($attr);
        return redirect()->route("category.index")->with('success', 'Created new category');
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view("backoffice.category.edit", compact("data"));
    }
    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        $attr = $request->validate([
            'name'      => 'required',
        ]);

        $attr['slug'] = Str()->slug($attr['name']);
        $data->update($attr);
        return redirect()->route("category.index")->with('success', 'Category successfully updated');
    }


    public function setActive($id)
    {
        $data = Category::findOrFail($id);
        if ($data->enabled == 1) {
            $data->update(['enabled' => 0]);
            return redirect()->back()->with('success', $data->name . " has been nonactived");
        } else {
            $data->update(['enabled' => 1]);
            return redirect()->back()->with('success', $data->name . " has been actived");
        }
    }
}
