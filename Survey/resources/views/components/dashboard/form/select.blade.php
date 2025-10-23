@props(['options', 'name' , 'id' , 'selected' => '' , 'label', 'class' => 'col-md-12'])

<div class="form-group {{$class}}">
    <label for="{{$id}}">{{$label}}</label>
    <select name="{{$name}}" id="{{$id}}" class="form-control">
        <option disabled selected> اختار .....</option>
        @foreach($options as $option)
            <option value="{{$option->id}}" {{$selected == $option->id ? 'selected' : ''}}>{{$option->name}}</option>
        @endforeach
    </select>
</div>
