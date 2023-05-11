@extends('layouts.layout')

@section('title', 'Home')

@section('body')

    <div id="post-section">
        <p hidden id="no-post">There are no posts in your feed.</p>
    </div>

@endsection

@section('script')
    <script>
        const no_comment = document.getElementById('no-comment');
        const no_post = document.getElementById('no-post');
        const post_sec = document.querySelector('#post-section');

        fetchPost();
        
        // FETCH POST
        function fetchPost() {
            fetch("{{ route('post.index') }}", {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.posts.length == 0) {
                    no_post.hidden = false;
                } else {
                    data.posts.forEach(post => {
                        const elem = document.createElement('div');
                        elem.classList.add('container', 'mb-5');
                        elem.id = `post-${post.id}`;
                        elem.innerHTML = `<x-post id="${post.id}" isPoster="${post.poster_id == {{ auth()->user()->id }}}" src="{{ asset('storage/${post.image}') }}" caption="${post.caption}" date="${formatDate(post.created_at)}" />`;
                        post_sec.appendChild(elem);

                        fetchUser(post.id);
                        fetchComment(post.id);
                    });
                }
            });
        }

        // SUBMIT COMMENT
        function submitComment(e, post_id) {
            e.preventDefault();

            const url_submit = "{{ route('comment.store', ':id') }}";
            fetch(url_submit.replace(':id', post_id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new FormData(e.target)
            })
            .then(response => response.json())
            .then(data => {
                fetchComment(post_id);
            });
            
            document.querySelector('#comment').value = '';
        }

        // FETCH USER
        function fetchUser(poster_id) {
            const url_user = "{{ route('user.show', ':id') }}";
            return fetch(url_user.replace(':id', poster_id), {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`name-${poster_id}`).innerHTML = data.user.name;
            });
        }

        // FETCH COMMENT
        function fetchComment(post_id) {
            const url_comment = "{{ route('comment.show', ':id') }}";
            return fetch(url_comment.replace(':id', post_id), {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                const com_sec = document.getElementById(`comment-${post_id}`);

                if (data.comments.length == 0) {
                    no_comment.hidden = false;
                } else {
                    com_sec.innerHTML = '';
                    data.comments.forEach(comment => {
                        const elem = document.createElement('div');
                        elem.classList.add('container');
                        elem.innerHTML = `<x-comment commenter="${comment.commenter.name}" created="${formatDate(comment.created_at)}" content="${comment.content}" />`;
                        com_sec.appendChild(elem);
                    });
                }
                return com_sec;
            });
        }

        // FORMAT DATE
        function formatDate(date) {
            const datetime = new Date(date);
            return `${datetime.getDate()}/${datetime.getMonth() + 1}/${datetime.getFullYear()}`;
        }

        function deletePost(post_id) {
            const url_delete = "{{ route('post.destroy', ':id') }}";
            fetch(url_delete.replace(':id', post_id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status == 'success') {
                    document.getElementById(`post-${post_id}`).remove();
                }
            })
        }
        
    </script>
@endsection