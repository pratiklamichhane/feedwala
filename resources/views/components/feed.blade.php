<style>
        .add-post {
        width: 90%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 20px;
    }

    .add-post form {
        display: flex;
        justify-content: space-between;
    }

    .add-post input {
        width: 70%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .add-post input[type="file"] {
        width: 20%;
    }

    .add-post button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background-color: black;
        color: #fff;
        cursor: pointer;
    }

    .add-post button:hover {
        background-color: #0056b3;
    }

    .alert {
        width: 90%;
        padding: 20px;
        border-radius: 5px;
        margin: 20px;
    }

    .alert ul {
        list-style: none;
    }

    .alert li {
        color: red;
    }

    .post {
        width: 90%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 20px;
    }

    .post h3 {
        margin-bottom: 10px;
    }

    .post img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 5px;
    }

    .uploader-details {
        display: flex;
        align-items: center;
    }

    .uploader-details img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .post-details {
        margin-top: 10px;
    }

    .post-details p.time {
        color: #ccc;
        margin-bottom: 10px;
    }

    .post-details p {
        margin-bottom: 10px;
    }

    .post-details img {
        width: 100%;
        height: 700px;
        object-fit: cover;
        border-radius: 5px;
    }

    .edit-post {
        display: flex;
        justify-content: flex-end;
    }

    .edit-post a {
       margin-right: 2px;

    }

    .edit-post button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .edit-post button:hover {
        background-color: #0056b3;
    }

    .post-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .actions-button button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .actions-button button:hover {
        background-color: #0056b3;
    }

    .actions-button button i {
        font-size: 20px;
    }

    .actions-button button i:hover {
        color: #0056b3;
    }

    .liked {
        background-color: red;
    }
</style>


@if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(auth()->check())
    <div class="add-post">
    <form action="{{route('posts.store')}}" method="post" enctype='multipart/form-data'>
        @csrf
        <input type="text" placeholder="What's on your mind?" name="caption">
        <input type="file" name="image">
        <button type="submit">Post</button>
    </form>
    </div>
    @endif

    @foreach($posts as $post)
        <div class="post">
            <div class="uploader-details">
            @if($post->user->image)
                <img src="{{asset($post->user->image)}}" alt="">
            @else
                <img src="https://th.bing.com/th/id/OIP.uQ4DG8iPTlnHC-dBRiRHjwHaHa?rs=1&pid=ImgDetMain" alt="">
            @endif
            <p>{{$post->user->username}}</p>
            </div>
            <div class="edit-post">

            @if(auth()->check() && auth()->user()->id == $post->user_id)
                <a href="{{route('posts.edit' , $post->id)}}"><button><i class="ri-pencil-line"></i></button></a>
                <form action="{{route('posts.destroy' , $post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><i class="ri-delete-bin-6-line"></i></button>
                </form>
            @endif

            </div>
            <div class="post-details">
            <p class="time">{{$post->created_at->diffForHumans()}}</p>
            <p>{{$post->caption}}</p>
            @if($post->image)
                <img src="{{asset($post->image)}}" alt="">
            @endif
            </div>

            <div class="post-footer">
                <div class="actions-button">
                    <button class="like-button"><i class="ri-heart-line"></i></button>
                    <a href="{{route('posts.show', $post->id)}}"><button><i class="ri-chat-3-line"></i></button></a>
                </div>
            </div>
        </div>
        <script>
       document.querySelectorAll('.like-button').forEach(function(button) {
        button.addEventListener('click', function() {
        this.classList.toggle('liked');
        });
    });
        </script>
    @endforeach