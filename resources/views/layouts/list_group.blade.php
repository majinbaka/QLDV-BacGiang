<span>TỈNH ĐOÀN BẮC GIANG</span>
<ul class="main-list">
    @foreach($groups as $gr)
        @if(count($gr->childrens) > 0)
            <li class="has_sub {{$gr->uuid}}" data-uuid="{{$gr->uuid}}" data-parent="0" style="background-color: #c0ebff;">
                <a style="color: #000;" href="#">{{$gr->name}}</a>
                <ul style="display:none">
                    @include('layouts._child_list_group', ['groups' => $gr->childrens])
                </ul>
            </li>
        @else
            <li style="background-color: #c0ebff;"><a href="#">{{$gr->name}}</a></li>
        @endif
    @endforeach
</ul>
@push('script')
<script>
    $(".main-list li").click(function(e) {
        var active = $(this).hasClass( "active" );
        var uuid = $(this).attr("data-uuid");
        var parent = $(this).attr("data-parent");
        if (active && parent == "0")
        {
            $(".has_sub").removeClass( "active" );
            $(".has_sub ul").hide();
            e.stopPropagation();
        }
        else if (active && parent != "0")
        {
            $(".has_sub").removeClass( "active" );
            $('.position-list').removeClass( "sub-ico" );
            $('.position-list').addClass( "plus-ico" );
            $(".has_sub ul").hide();
            while(true){
                if (parent == "0") break;
                $("."+parent+" > ul").show();
                $("."+parent).addClass('active');
                parent = $("."+parent).attr("data-parent");
            }
            e.stopPropagation();
        }
        else if (!active)
        {
            if (uuid === undefined)
            {
                e.stopPropagation();
            }
            else{
                $(this).addClass( "active" );
                $(".has_sub ul").hide();
                $("."+uuid+" > ul").show();
                $('.position-list').addClass( "plus-ico" );
                $('.position-list').removeClass( "sub-ico" );
                $("."+uuid+" > div").addClass( "sub-ico" );
                $("."+uuid+" > div").removeClass( "plus-ico" );
                while(true){
                    if (parent == "0") break;
                    $("."+parent+" > ul").show();
                    parent = $("."+parent).first().attr("data-parent");
                }
                e.stopPropagation();
            }
        }
        else
        e.stopPropagation();
    }) 
</script>
@endpush
