<div class="notification container">
@isset($success)
<div class="my-notify-success">
    {{$success}}
</div>
@endisset
@isset($warning)
@endisset
@if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="my-notify-error">
        {{$error}}
    </div>
    @endforeach
    @endif
</div>