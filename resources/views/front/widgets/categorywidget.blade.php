<style>

    div.list-group {

    }

    div.list-group-item {
        text-align: center;
    }

    div.list-group-item ul {
        list-style: none;
        float: end;
    }

    div.list-group-item span {
        float: right;
    }

</style>

<div class="col-md-3" Style="float:left;">
    <div class="card">
        <div class="card-header" style="text-align: center">
            Kategoriler
        </div>
        <ul class="list-group">
            @foreach($data as $d)
                <a href="{{route('category',$d->slug)}}">
                    <li class="list-group-item d-flex justify-content-between align-items-center">{{$d->name}}
                        <span class="badge bg-primary rounded-pill">{{$d->total}}</span>
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
</div>
