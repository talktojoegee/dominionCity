@foreach($comments as $comment)
    <div class="d-flex py-3 border-top">
        <div class="flex-shrink-0 me-3">
            <div class="avatar-xs">
                <img src="{{url('storage/'.$comment->getUser->image)}}" alt=""
                     class="img-fluid d-block rounded-circle">
            </div>
        </div>
        <div class="flex-grow-1">
            <h5 class="font-size-14 mb-1">{{$comment->getUser->title ?? '' }} {{$comment->getUser->first_name ?? '' }} {{$comment->getUser->last_name ?? '' }} <small
                    class="text-muted float-end">{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</small></h5>
            <p class="text-muted">
                {{$comment->pc_comment ?? '' }}
            </p>
        </div>
    </div>
@endforeach
