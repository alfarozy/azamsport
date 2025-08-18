<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $data = Project::with(['category'])->get();
        return view('backoffice.project.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::whereEnabled(1)->whereIsProject(1)->orderBy('name')->get();
        $technologies = Technology::whereEnabled(1)->orderBy('name')->get();
        return view('backoffice.project.create', compact('categories', 'technologies'));
    }


    public function store(Request $request)
    {

        $attr = $request->validate([
            'title'      => 'required',
            'description'      => 'required',
            'image'      => 'required|image:mimes:png,jpeg,jpg,svg',
            'tags'  => 'required',
            'category_id' => 'required',
            'technology' => 'required',
            'content'   => 'required',
            'link_github' => 'sometimes',
            'link_demo' => 'sometimes',
        ]);
        $img = $request->file('image')->store('projects');
        $attr['image'] = $img;
        $attr['user_id'] = Auth()->id();
        $attr['slug'] = Str()->slug($attr['title']) . '-' . str()->random(2) . '.html';
        $data = Project::create($attr);
        $data->technologies()->attach($attr['technology']);
        toastr()->success("Created new project", 'Success');
        return redirect()->route("project.index");
    }
    public function edit($id)
    {
        $categories = Category::whereEnabled(1)->whereIsProject(1)->orderBy('name')->get();
        $technologies = Technology::whereEnabled(1)->orderBy('name')->get();
        $data = Project::findOrFail($id);
        return view('backoffice.project.edit', compact('categories', 'technologies', 'data'));
    }
    public function update(Request $request, $id)
    {
        $data = Project::findOrFail($id);
        $attr = $request->validate([
            'title'      => 'required',
            'description'      => 'required',
            'image'      => 'sometimes|image:mimes:png,jpeg,jpg,svg',
            'tags'  => 'required',
            'category_id' => 'required',
            'technology' => 'sometimes',
            'content'   => 'required',
            'link_github' => 'sometimes',
            'link_demo' => 'sometimes',
        ]);
        if ($request->image) {
            Storage::delete($data->image);
            $img = $request->file('image')->store('projects');
            $attr['image'] = $img;
        }
        $attr['user_id'] = Auth()->id();

        $data->update($attr);
        if ($request->technology) {

            $data->technologies()->attach($attr['technology']);
        }
        toastr()->success("project successfully updated", 'Success');
        return redirect()->route("project.index");
    }
    public function setActive($id)
    {
        $data = Project::findOrFail($id);
        if ($data->enabled == 1) {
            $data->update(['enabled' => 0]);
            toastr()->success(str()->limit($data->title, 40) . " has been nonactived", "Success");
        } else {
            $data->update(['enabled' => 1]);
            toastr()->success(str()->limit($data->title, 40) . " has been activated", "Success");
        }
        return redirect()->route('project.index');
    }
}
