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
    <title>Create</title>
    
</head>
<body>
    <div class="container">
        <div class="flex justify-between my-5">
            <h2 class="text-red-500 text-xl">Create</h2>
            <a href="/" class="bg-green-600 text-white rounded py-2 px-4">Back To Home</a>
        </div>

        <div>
            <form method="POST" action="{{route('store')}}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-5">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{old('name')}}" placeholder="Enter post name">
                    @error('name')
                        <p class="text-red-600">{{$message}}</p>
                    @enderror

                    <label for="dexcripption">Description</label>
                    <input type="text" name="description" value="{{old('description')}}" placeholder="Enter post details">
                    @error('description')
                        <p class="text-red-600">{{$message}}</p>
                    @enderror

                    <label for="image">Image</label>
                    <input type="file" name="image">
                    @error('image')
                        <p class="text-red-600">{{$message}}</p>
                    @enderror

                    <div>
                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded inline block">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>