@extends('layout.master')
@section('title')
    اشراف العمارات
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css-rtl/plugins/animate/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css-rtl/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css-rtl/plugins/forms/checkboxes-radios.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css-rtl/main.css')}}">
@endsection

@section('content')
    <div class="row">

        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-content">
                    <!-- Type Here Form Code-->
                    <!--start card input form-->

                    <div class="card-header">
                        <h2 class="h1 text-center text-monospace mt-md-2">  اشراف العمارات
                        </h2>

                    </div>
                    <div class="card-content collapse show ">
                        <div class="card-body card-size">
                            <form action="{{route('dashboard.surveys.safe-security.update', $survey->id)}}" method="post" class=" mx-3" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label label-name ">المرحلة :
                                        </label>
                                        <div class="col-md-7">
                                            <select class="custom-select d-block w-100" id="step" name="step">
                                                <option selected disabled>المرحلة....</option>
                                                @foreach($steps as $step)
                                                    <option value="{{$step->id}}" {{$survey->step_id == $step->id ? 'selected' : ''}}>{{$step->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label label-name">رقم العمارة :
                                        </label>
                                        <div class="col-md-7">
                                            <select class="custom-select d-block w-100" id="groups" name="group"  data-current-group="{{$survey->group_id}}">
                                                <option selected disabled>رقم العمارة....</option>
                                                @foreach($groups as $group)
                                                    <option value="{{$group->id}}" {{$group->id == $survey->group_id ? 'selected' : ''}}> {{$group->number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @foreach($questions as $question)
                                        <div class="custom-control custom-checkbox my-2 row">
                                            <input type="checkbox"
                                                   id="question-{{$question->id}}"
                                                   class="custom-control-input col-md-4"
                                                   name="questions[]"
                                                   value="{{$question->id}}"
                                                   {{in_array($question->id, $answers) ? 'checked' : ''}}
                                            >
                                            <label class="custom-control-label col-md-8" for="question-{{$question->id}}">
                                                {{$question->question}}
                                            </label>
                                        </div>
                                    @endforeach
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label label-name ">ارفق الملف :
                                        </label>
                                        <div class="col-md-7">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="attachments[]"  accept="image/jpeg , image/png ,image/gif,image/jpg, image/svg" multiple >
                                                <label class="custom-file-label" for="inputGroupFile02"
                                                       aria-describedby="inputGroupFile02">ارفق الملف</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#" data-toggle="modal" data-target="#album">مشاهدة الصور</a>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label label-name ">ملاحظات :
                                        </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" id="placeTextarea" name="notes" rows="3" placeholder="ملاحظات">{{$survey->notes}}</textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="safeSecurity">
                                </div>
                                <hr class="mb-4 mx-5">
                                <div class=" form-actions pb-5 text-center">
                                    <div class="save-btn ">
                                        <button type="submit" class=" btn btn-primary px-2 "><i class=" ft-log-in position-left "></i>ارسال</button>
                                    </div>
                                </div>

                            </form>
                            <!--/Start : Model -->
                            <form action="{{route('dashboard.surveys.attachment.destroy', $survey->id)}}" method="post">
                                @csrf
                                @method('post')
                                <div class="modal fade text-left animated shake" id="album" tabindex="-1" role="dialog" aria-labelledby="myModalLabel10" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger white">
                                                <h4 class="modal-title white" id="myModalLabel10">معرض الصور الخاص بنموذج</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!--/Start :Image Checkbox-->
                                                <fieldset class="form-group">
                                                    <div class="row">
                                                        @foreach($survey->attachments as $attachment)
                                                            <label class="btn col-md-3">
                                                                <input type="checkbox" name="attachments[]" id="item1" value="{{$attachment->id}}" class="hidden">
                                                                <img src="{{URL::asset('files/survey/' . $attachment->photo)}}" alt="..." class="check img-thumbnail attachment">
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </fieldset>
                                                <!--/End :Image Checkbox-->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">غلق</button>
                                                <button type="submit" class="btn btn-outline-danger">حفظ </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <!--/End : Model -->
                        </div>
                    </div>
                    <!--end card input form-->



        @endsection
@section('scripts')
<script src="{{URL::asset('assets/js/main.js')}}"></script>
<!-- BEGIN: Page Vendor JS-->
<script src="{{URL::asset('assets/vendors/js/forms/icheck/icheck.min.js')}}"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
<script src="{{URL::asset('assets/js/scripts/forms/checkbox-radio.js')}}"></script>
<!-- END: Page JS-->

@endsection
