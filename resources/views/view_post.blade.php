@extends('layouts.layout')

@section('title', 'View Post')

@section('body')

    <div id="post-section">
        <p hidden id="no-post">There are no post found.</p>
    </div>

@endsection

@section('script')
    <script>
        // const id = document.querySelector('#post-id');
        // const img = document.querySelector('#post-img');
        // const caption = document.querySelector('#post-caption');
        // const name = document.querySelector('#post-name');
        // const date = document.querySelector('#post-date');

        const no_comment = document.getElementById('no-comment');
        const no_post = document.getElementById('no-post');
        
        const post_sec = document.querySelector('#post-section');

        // FETCH POST
        fetch("{{ route('post.show', $id) }}", {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.posts.length == 0) {
                no_post.hidden = false;
            } else {
                data.posts.forEach(post => {
                    const elem = document.createElement('div');
                    elem.classList.add('container');
                    elem.innerHTML = `<x-post id="${post.id}" src="{{ asset('storage/${post.image}') }}" caption="${post.caption}" date="${formatDate(post.created_at)}" />`;
                    post_sec.appendChild(elem);

                    fetchUser(post.id);
                    fetchComment(post.id);
                });
            }

            // const posts = data.posts;
            // id.innerHTML = `Post ID ${posts.id}`;
            // img.src = `{{ asset('storage/${posts.image}') }}`;
            // caption.innerHTML = posts.caption;
            // name.innerHTML = fetchUser(posts.poster_id);
            // date.innerHTML = formatDate(posts.created_at)

        });

        // SUBMIT COMMENT
        function submitComment(e, post_id) {
            e.preventDefault();

            fetch("{{ route('comment.store', $id) }}", {
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
            return fetch("{{ route('user.show', $id) }}", {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`name-${poster_id}`).innerHTML = data.user.name;
            });
        }

        // FETCH COMMENT
        function fetchComment(poster_id) {
            return fetch("{{ route('comment.show', $id) }}", {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                const com_sec = document.getElementById(`comment-${poster_id}`);

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
    </script>
@endsection