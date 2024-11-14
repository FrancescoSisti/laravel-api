<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index(): JsonResponse
    {
        $projects = Project::with(['category'])->get();
        return response()->json($projects);
    }

    /**
     * Store a new project
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            // Aggiungi altre validazioni se necessario
        ]);

        $project = Project::create($validatedData);

        return response()->json($project, 201);
    }

    /**
     * Display the specified project
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json($project->load('category'));
    }

    /**
     * Update the specified project
     */
    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        if (isset($data['technologies'])) {
            $data['technologies'] = explode(',', $data['technologies']);
        }

        // Explicitly specify fields to update
        $project->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'image_path' => $data['image_path'] ?? $project->image_path,
            'category_id' => $data['category_id']
        ]);

        return response()->json($project->load('category'));
    }

    /**
     * Remove the specified project
     */
    public function destroy(Project $project): JsonResponse
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        $project->delete();
        return response()->json(null, 204);
    }
}
