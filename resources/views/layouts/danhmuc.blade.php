<span>DANH MỤC</span>
<ul class="main-list">
    <li><a href="{{route('group.index')}}">Đơn vị</a></li>
    @if (Auth::user()->isAn('admin'))
        <li><a href="{{route('position.index')}}">Chức vụ</a></li>
        <li><a href="{{route('knowledge.index')}}">Trình độ</a></li>
        <li><a href="{{route('political.index')}}">Chính trị</a></li>
        <li><a href="{{route('it.index')}}">Tin học</a></li>
        <li><a href="{{route('english.index')}}">Tiêng anh</a></li>
    @endif
</ul>