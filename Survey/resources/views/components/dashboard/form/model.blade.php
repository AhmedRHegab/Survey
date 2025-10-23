@props(['action', 'method','' ,'title', 'modelId' , 'inputs' , 'methodBody' => 'post'])
<!--/Start : Model-->
<form action="{{$action}}" method="{{$method}}">
    @csrf
    @method($methodBody)
    <div class="modal text-left" id="{{$modelId}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel42" style="display: none;" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel42">{{$title}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{$inputs}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">غلق</button>
                    <button type="submit" class="btn btn-outline-success">حفظ</button>
                </div>
            </div>
        </div>
    </div>

</form>
<!--/End : Model-->
