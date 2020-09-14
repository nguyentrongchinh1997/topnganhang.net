<div class="widget">
    <div class="widget-title">
        <h2>Ngân hàng</h2>
    </div>
    <div class="social">
        <ul class="list-unstyled">
            @foreach ($viewShare['bank'] as $bankItem)
                <li>
                    <a title="Tỷ giá ngân hàng {{ $bankItem->name_en }}"
                        href="{{ route('bank-intro', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}">
                        » {{ $bankItem->name_en }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
