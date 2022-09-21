<style>
    div.post-preview img {
        width: 100%;
        border-radius: 20px;
        padding: 3px;
        margin: 0 15px 10px 0;
        object-fit: fill;
        object-position: 50% 15%;
    }
</style>
<!-- Post preview-->
@if(count($contents)>0)
    @foreach($contents as $content)
        <div class="post-preview">
            <a href="{{route('single',[$content->getCategory->slug,$content->slug])}}">
                <h2 class="post-title">
                    {{$content->title}}
                </h2>
                <img src="{{ asset($content->image) }}">
                <h3 class="post-subtitle">
                    {!! Str::limit($content->content,70) !!}
                </h3>
            </a>
            <p class="post-meta"> Kategori:
                <a href="#!">{{$content->getCategory->name}}</a>
                <span class="float-end">{{$content->created_at->diffForHumans()}}</span>
            </p>
        </div>
        @if(!$loop->last)
            <hr>
        @endif
    @endforeach
    {{$contents->links('pagination::bootstrap-4')}}
@else
    <div class="alert alert-danger">
        <h2>Bu Kategoriye Ait İçerik Bulunumadı</h2>
    </div>
@endif
