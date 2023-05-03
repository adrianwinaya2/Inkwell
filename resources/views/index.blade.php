@extends('layouts.layout')

@section('body')
    <!-- Main Content -->
    <div class="container mt-4">

        <!-- Post 1 -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>John Doe</h4>
            </div>
            <img src="https://picsum.photos/id/1/600/400" class="card-img-top" alt="Post image">
            <div class="card-body">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2">
                    <i class="fas fa-thumbs-up"></i> Like
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-comment"></i> Comment
                </button>
            </div>
        </div>

        <!-- Post 2 -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Jane Smith</h4>
            </div>
            <img src="https://picsum.photos/id/2/600/400" class="card-img-top" alt="Post image">
            <div class="card-body">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2">
                    <i class="fas fa-thumbs-up"></i> Like
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-comment"></i> Comment
                </button>
            </div>
        </div>
    </div>
@endsection