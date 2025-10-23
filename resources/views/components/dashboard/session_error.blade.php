{{-- Start Alert Danger For Error  --}}
@if ($errors->any())
    @foreach ($errors->all() as $error)

        <div class="alert alert-danger alert-dismissible mb-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>خطاء </strong> {{$error}}
        </div>


    @endforeach
@endif
{{-- End Alert Danger For Error  --}}
