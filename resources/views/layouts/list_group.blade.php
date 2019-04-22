<span><a href="{{route('home')}}" style="color: white;text-decoration: none; text-transform: uppercase">
         @php
             $user = Auth::user();
             if ($user->isAn('admin')){
                 echo 'TỈNH ĐOÀN BẮC GIANG';
             } else{
                 $group = $user->group;
                 echo $group->name;
             }
         @endphp
    </a></span>
<ul class="main-list">
    @foreach($groups as $gr)
        @if(count($gr->childrens) > 0)
            <li class="has_sub {{$gr->uuid}} @isset($group)@if($group->hasFatherRelation($gr->id) === true || $group->id == $gr->id) active @endif @endisset"
                data-uuid="{{$gr->uuid}}" data-parent="0" style="background-color: #c0ebff;">
                <a style="color: #000;" href="{{route('group.show', $gr->uuid)}}">{{$gr->name}}</a>
                <ul @isset($group)@if(!$group->hasFatherRelation($gr->id) === true && $group->id != $gr->id) style="display:none" @endif @else style="display:none"  @endisset>
                    @isset($group)
                        @include('layouts._child_list_group', ['groups' => $gr->childrens, 'group' => $group])
                    @else
                        @include('layouts._child_list_group', ['groups' => $gr->childrens])
                    @endisset
                </ul>
            </li>
        @else
            <li style="background-color: #c0ebff;" class="@isset($group)@if($group->id == $gr->id) active @endif @endisset">
                <a href="{{route('group.show', $gr->uuid)}}">{{$gr->name}}</a></li>
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
            e.preventDefault();
            e.stopPropagation();
        }
        else if (active && parent != "0")
        {
            $(".has_sub").removeClass( "active" );
            $('.position-list').removeClass( "sub-ico" );
            $('.position-list').addClass( "plus-ico" );
            $(".has_sub ul").hide();
            var counter = 0;
            while(true){
                if (parent == "0") break;
                $("."+parent+" > ul").show();
                $("."+parent).addClass('active');
                parent = $("."+parent).attr("data-parent");
                counter++;
                if(counter >= 20) break;
            }
            if ($(this).hasClass( "has_sub" ))
                e.preventDefault();
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
                var counter = 0;
                while(true){
                    if (parent == "0") break;
                    $("."+parent+" > ul").show();
                    parent = $("."+parent).first().attr("data-parent");
                    counter++;
                    if(counter >= 20) break;
                }
                e.stopPropagation();
            }
        }
        else
        e.stopPropagation();
    }) 
</script>
@endpush
