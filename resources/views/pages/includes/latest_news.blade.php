<div class="widget">
    <div class="widget-title">
        <h2>Tin mới</h2>
    </div>
    @foreach($viewShare['latestNews'] as $newsItem)
        <div class="row d-flex mb-3 align-items-start">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 20px">
                <a href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">
                    <img class="img-fluid" src='{{asset("upload/thumbnails/$newsItem->image")}}' alt="">
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">{{$newsItem->title}}</a>
                <a class="d-block font-sm mt-1 text-light" href="#">
                    {{getWeekday($newsItem->created_at)}}
                </a>
            </div>
        </div><hr>
    @endforeach
</div>