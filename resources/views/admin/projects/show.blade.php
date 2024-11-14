@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Project Details') }}</span>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm">Back to Projects</a>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h2>{{ $project->title }}</h2>
                        <p class="text-muted">Category: {{ $project->category->name }}</p>
                    </div>

                    @if($project->image_path)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="img-fluid rounded">
                        </div>
                    @endif

                    <div class="mb-4">
                        <h4>Description</h4>
                        <p>{{ $project->description }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-primary">Edit Project</a>

                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">Delete Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
