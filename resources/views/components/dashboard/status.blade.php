@props(['status'])

@if($status == 1)
    <div class="badge badge-success">مفعل</div>
@else
    <div class="badge badge-danger">غير مفعل</div>
@endif
