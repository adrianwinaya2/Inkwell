@extends('layouts.layout')

@section('title', 'Create Post')

@section('body')
    <form method="POST" onsubmit="submitForm(event)" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="image">Image</label>
          <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
          
        <div class="form-group">
            <label for="caption">Caption</label>
            <textarea name="caption" id="caption" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>

    <script>
        function submitForm(e) {
            e.preventDefault();

            fetch("{{ route('post.store') }}", {
                method: 'POST',
                body: new FormData(e.target)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.href = "{{ route('view_post', ':id') }}".replace(':id', data.id)
            });
        }
    </script>
@endsection