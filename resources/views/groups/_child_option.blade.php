@foreach($groupsFilter as $group)
    <option value="{{$group->uuid}}">
        @for($i = 1; $i < $group->level; $i++)
            --
        @endfor
        {{$group->name}}
    </option>
    @if($group->childrens)
        @include('groups._child_option', ['groupsFilter' => $group->childrens])
    @endif
@endforeach