@foreach($groupsFilter as $group)
    <option value="{{$group->uuid}}" @if($group->id == $selected) selected @endif>
        @for($i = 1; $i < $group->level; $i++)
            --
        @endfor
        {{$group->name}}
    </option>
    @isset($except)
        @if($group->getExceptChildrens($except))
        
            @include('groups._child_option', ['groupsFilter' => $group->getExceptChildrens($except), 'selected' => $selected, 'except' => $except])
        @endif
    @else
        @if($group->childrens)
            @include('groups._child_option', ['groupsFilter' => $group->childrens, 'selected' => $selected])
        @endif
    @endisset
    
@endforeach