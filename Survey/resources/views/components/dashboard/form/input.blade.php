@props(['class' => 'col-md-12' , 'id', 'label' , 'inputName', 'class' , 'type' => 'text' , 'value' => ''])
<div class="form-group {{$class}}">
    <label for="{{$id}}"><b>{{$label}}</b></label>
    <input type="{{$type}}" placeholder="{{$label}}" id="{{$id}}" name="{{$inputName}}" class="form-control" value="{{$value}}">
</div>
