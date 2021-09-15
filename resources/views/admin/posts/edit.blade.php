@extends('layouts.app')

@section('content')


<div class="container">
    {{-- @if($errors->any())
        <div class="alert alert-warning">

              <ul>
                @foreach ($errors->all() as $error )

                <li>{{$error}}</li>


                @endforeach
              </ul>
         
        </div>
    @endif --}}



    <form action="{{route('admin.posts.update', $post->id)}}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label for="titolo" class="form-label">Titolo</label>
          <input type="text" class="form-control
          @error('title')
          is-invalid
          @enderror" 
          id="titolo" name="title" value="{{ old('title', $post->title)}}">
          @error('title')
          <div class="alert alert-warning">{{$message}}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="descrizione" class="form-label">Descrizione</label>
         <textarea name="content" id="" cols="30" rows="10" class="form-control
          @error('content')
            is-invalid
          @enderror"
          id="descrizione">{{ old('content', $post->content)}}</textarea>
          @error('content')
          <div class="alert alert-warning">{{$message}}</div>
          @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>









@endsection