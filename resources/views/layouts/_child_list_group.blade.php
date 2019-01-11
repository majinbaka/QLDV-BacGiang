@foreach($groups as $gr)
    @if(count($gr->childrens))
        <li class="has_sub {{$gr->uuid}} @isset($group)@if($group->hasFatherRelation($gr->id) === true || $group->id == $gr->id) active @endif @endisset"
             data-uuid="{{$gr->uuid}}" data-parent="{{$gr->father->uuid}}">
        <div class="@isset($group)@if($group->hasFatherRelation($gr->id) === true || $group->id == $gr->id) sub-ico @else plus-ico @endif @endisset position-list" style="margin-left:{{12 + $gr->level*2}}px"></div>
        <a href="{{route('group.show', $gr->uuid)}}">
            @for($i = 1; $i < $gr->level; $i++)
                &nbsp;
            @endfor
            {{$gr->name}}
        </a>
            <ul @isset($group)@if(!$group->hasFatherRelation($gr->id) === true && $group->id != $gr->id) style="display:none" @endif @else style="display:none" @endisset>
                @isset($group)
                    @include('layouts._child_list_group', ['groups' => $gr->childrens, 'group' => $group])
                @else
                    @include('layouts._child_list_group', ['groups' => $gr->childrens])
                @endisset
            </ul>
        </li>
    @else
        <li class="@isset($group)@if($group->id == $gr->id) active @endif @endisset"><a href="{{route('group.show', $gr->uuid)}}">
            @for($i = 1; $i < $gr->level; $i++)
                &nbsp;
            @endfor
            {{$gr->name}}
        </a></li>
    @endif
@endforeach