@props(['status' => '' , 'class' => 'col-md-12'])

<div class="form-group {{$class}}">
    <label for="status">الحالة</label>
    <select name="status" id="status" class="form-control">
        <option disabled selected {{$status == '' ? 'selected' : ''}}> اختار الحالة</option>
        <option value="1" {{$status == '1' ? 'selected' : 1}} selected> مفعل</option>
        <option value="0" {{$status == '0' ? 'selected' : 0}}> غير مفعل</option>
    </select>
</div>
