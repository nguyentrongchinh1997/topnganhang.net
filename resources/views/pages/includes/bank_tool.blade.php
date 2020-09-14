<div class="widget">
    <div class="widget-title">
    <h2>Dịch vụ NH {{$bank->name_en}}</h2>
    </div>
    <div class="social">
        <ul class="list-unstyled">
            <li>
                <a href="{{route('exchange-rate', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Xem tỷ giá</a>
            </li>
            <li>
                <a href="{{route('interest-rate', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Xem lãi suất</a>
            </li>
            <li>
                <a href="{{route('bank', ['bank' => str_slug($bank->slug)])}}"> » Xem chi nhánh</a>
            </li>
            <li>
                <a href="{{route('bank-atm', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Tra cứu ATM</a>
            </li>
            <li>
                <a href="{{ route('news-detail', ['slug' => $viewShare['swift_code']->slug, 'id' => $viewShare['swift_code']->id]) }}"> » Mã Swift Code</a>
            </li>
            <li>
                <a href="{{route('bank-intro', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Giới thiệu</a>
            </li>
        </ul>
    </div>
</div>