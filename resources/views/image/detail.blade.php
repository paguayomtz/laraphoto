@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')               
            <div class="card pub-image pub-image-detail">
                <div class="card-header">
                    @if($image->user->image)                            
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" class="avatar">
                        </div>
                    @endif
                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname }}
                        <span class="nickname">
                            {{ ' | @'.$image->user->nick }}
                        </span>
                    </div>
                </div>                
                <div class="card-body">
                    <div class="img-container img-detail">
                        <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" />
                    </div>
                    <div class="description">
                        <span class="nickname">{{ '@'.$image->user->nick }}</span>
                        <p>{{ $image->description }}</p>
                    </div>
                    <div class="likes">
                        <img src="{{ asset('img/heart-gray.png') }}">
                    </div>
                    <div class="clearfix"></div>
                    <div class="comments">
                        <h3>Comentarios ({{ count($image->comments) }})</h3>
                        <hr>
                        <form action="{{route('comment.save')}}" method="post">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}">
                            <p>
                                <textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''}}" name="content"></textarea>
                                @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('content')}}</strong>
                                </span>
                                @endif
                            </p>
                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                        <hr>
                        @foreach ($image->comments as $comment)
                        <div class="comment">
                            <span class="nickname">{{ '@'.$image->user->nick }}</span>
                            <span class="nickname">{{ ' | '.\FormatTime::LongTimeFilter($comment->created_at) }}</span>
                            <p>{{ $comment->content }}</p>
                        </div>                            
                        @endforeach
                    </div>
                </div>
            </div>                
    </div>
</div>
@endsection
