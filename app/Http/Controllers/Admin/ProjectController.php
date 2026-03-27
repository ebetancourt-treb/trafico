<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', [
            'projects' => Project::with('industry')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.projects.form', [
            'project' => new Project(),
            'industries' => Industry::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'location' => 'nullable|string|max:255',
            'client' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean',
            'gallery.*' => 'image|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        unset($data['gallery']);
        $project = Project::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image' => $file->store('projects/gallery', 'public'),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto creado correctamente.');
    }

    public function edit(Project $project)
    {
        $project->load('images');

        return view('admin.projects.form', [
            'project' => $project,
            'industries' => Industry::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'location' => 'nullable|string|max:255',
            'client' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean',
            'gallery.*' => 'image|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($project->image) Storage::disk('public')->delete($project->image);
            $data['image'] = $request->file('image')->store('projects', 'public');
        } else {
            unset($data['image']);
        }

        unset($data['gallery']);
        $project->update($data);

        if ($request->hasFile('gallery')) {
            $maxOrder = $project->images()->max('order') ?? 0;
            foreach ($request->file('gallery') as $index => $file) {
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image' => $file->store('projects/gallery', 'public'),
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        if ($request->has('delete_images')) {
            $imagesToDelete = ProjectImage::whereIn('id', $request->input('delete_images'))
                ->where('project_id', $project->id)->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) Storage::disk('public')->delete($project->image);
        foreach ($project->images as $img) {
            Storage::disk('public')->delete($img->image);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}
