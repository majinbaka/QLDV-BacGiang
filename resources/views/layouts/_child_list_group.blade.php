@foreach($groups as $gr)
    @if(count($gr->childrens))
        <li class="has_sub {{$gr->uuid}}" data-uuid="{{$gr->uuid}}" data-parent="{{$gr->father->uuid}}">
        <div class="plus-ico position-list" style="margin-left:{{12 + $gr->level*2}}px"></div><a href="#">
            @for($i = 1; $i < $gr->level; $i++)
                &nbsp;
            @endfor
            {{$gr->name}}
        </a>
            <ul style="display:none">
                @include('layouts._child_list_group', ['groups' => $gr->childrens])
            </ul>
        </li>
    @else
        <li><a href="#">
            @for($i = 1; $i < $gr->level; $i++)
                &nbsp;
            @endfor
            {{$gr->name}}
        </a></li>
    @endif
@endforeach