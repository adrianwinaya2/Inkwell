<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <h2>Post ID {{ $id }}</h2>
                    </div>
                    @if ($isPoster)
                        <div class="col-6 text-right">
                            <form onsubmit="deletePost({{ $id }})" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger m-1">Delete</button>
                            </form>
                            <form action="{{ route('post.update', '$id') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning m-1">Update</button>
                            </form>
                        </div>
                    @endif
                
                </div>

                <hr>

                <img src="{{ $src }}" alt="Post image" class="card-img-top">
                <br><br>
                <div class="container">
                    <h6 class="card-title">{{ $caption }}</h5>
                    <small class="card-text">Posted by <strong id="name-{{ $id }}"></strong> on <strong>{{ $date }}</strong></small>
                </div>
            </div>

            <div class="col-md-6">
                <h4>Comments</h4>
                <div class="overflow-auto" style="max-height: 80vh;">
                    <p hidden id="no-comment">No comments on this post.</p>
                    <ul id="comment-{{ $id }}" class="list-group">
                        {{-- COMMENT SECTION --}}
                    </ul>
                </div>

                <hr>

                <form onsubmit="submitComment(event, {{ $id }})" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment">Leave a comment:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>