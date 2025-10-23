@props(['action', 'method', 'inputs' , 'methodBody' => 'post'])
<!--/Start : Model-->
<form action="{{$action}}" method="{{$method}}">
    @csrf
    @method($methodBody)
    {{$inputs}}

    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-sm btn-outline-success">
                حفظ
            </button>
        </div>
    </div>
</form>
<!--/End : Model-->
