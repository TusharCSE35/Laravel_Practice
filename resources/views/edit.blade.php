<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    
    <style type="text/tailwindcss">
        @layer utilities {
            .container {
                @apply px-10 mx-auto;
            }
        }
    </style>
    <title>Update</title>
    
</head>
<body>
    <div class="container">
        <div class="flex justify-between my-5">
            <h2 class="text-red-500 text-xl">Edit - {{$post->name}}</h2>
            <a href="/" class="bg-green-600 text-white rounded py-2 px-4">Back To Home</a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div>
            <form method="POST" action="{{route('update', $post->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-5">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{$post->name}}" placeholder="Enter post name">
                    @error('name')
                        <p class="text-red-600">{{$message}}</p>
                    @enderror

                    <label for="dexcripption">Description</label>
                    <input type="text" name="description" value="{{$post->description}}" placeholder="Enter post details">
                    @error('description')
                        <p class="text-red-600">{{$message}}</p>
                    @enderror

                    <label for="image">Image</label>
                    <input type="file" name="image">
                    @if($post->image)
                        <p>Current Image:</p>
                        <img src="{{ asset('images/' . $post->image) }}" width="80">
                    @endif

                    <div>
                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded inline block">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>