@extends('Layouts.app')

@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection

@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">شخصی سازی قالب</h4>
        </div>
        <div class="card-body">

            {{-- نمایش پیام‌های فلش --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ri-checkbox-circle-line ms-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ri-alert-line ms-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="ri-alert-warning-line ms-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="ri-information-line ms-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ri-error-warning-line ms-2"></i>
                    <strong>لطفاً خطاهای زیر را بررسی کنید:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                </div>
            @endif

            <form method="POST" action="{{route('company.template.save')}}" enctype="multipart/form-data">
                @csrf

                <!-- ردیف اول: اطلاعات پایه -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">نام</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="name" name="name" placeholder="نام" value="{{ old('name', $template->name ?? '') }}">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="title" name="title" placeholder="عنوان" value="{{ old('title', $template->title ?? '') }}">
                                <i class="ri-text-wrap position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">آدرس</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="address" name="address" placeholder="آدرس" value="{{ old('address', $template->address ?? '') }}">
                                <i class="ri-map-pin-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">آیکون (تصویر)</label>
                            <div class="form-group position-relative">
                                <input type="file" class="form-control text-dark ps-5 h-58" id="icon" name="icon">
                                <i class="ri-image-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                            @if(!empty($template->icon))
                                <small class="form-text text-muted">فایل فعلی: {{ $template->icon }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- بخش اسلایدر -->
                <h5 class="mt-3 mb-3">اسلایدر</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">متن اسلایدر</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="slider_t" name="slider_t" placeholder="متن اسلایدر" value="{{ old('slider_t', $template->slider_t ?? '') }}">
                                <i class="ri-slideshow-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات اسلایدر</label>
                            <div class="form-group position-relative">
                                <textarea class="form-control ps-5 text-dark" id="slider_d" name="slider_d" placeholder="توضیحات اسلایدر" rows="2">{{ old('slider_d', $template->slider_d ?? '') }}</textarea>
                                <i class="ri-chat-1-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بخش اول -->
                <h5 class="mt-3 mb-3">بخش اول</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان بخش اول</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="sec_1_t" name="sec_1_t" placeholder="عنوان" value="{{ old('sec_1_t', $template->sec_1_t ?? '') }}">
                                <i class="ri-heading position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">متن کوتاه بخش اول</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="sec_1_m" name="sec_1_m" placeholder="متن کوتاه" value="{{ old('sec_1_m', $template->sec_1_m ?? '') }}">
                                <i class="ri-pencil-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات بخش اول</label>
                            <div class="form-group position-relative">
                                <textarea class="form-control ps-5 text-dark" id="sec_1_d" name="sec_1_d" placeholder="توضیحات" rows="2">{{ old('sec_1_d', $template->sec_1_d ?? '') }}</textarea>
                                <i class="ri-chat-1-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بخش دوم: سه نقطه با عنوان و توضیحات -->
                <h5 class="mt-3 mb-3">بخش دوم (سه نقطه)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان نقطه ۱</label>
                            <input type="text" class="form-control" id="sec_2_p_1_t" name="sec_2_p_1_t" value="{{ old('sec_2_p_1_t', $template->sec_2_p_1_t ?? '') }}" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات نقطه ۱</label>
                            <textarea class="form-control" id="sec_2_p_1_d" name="sec_2_p_1_d" rows="2" placeholder="توضیحات">{{ old('sec_2_p_1_d', $template->sec_2_p_1_d ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان نقطه ۲</label>
                            <input type="text" class="form-control" id="sec_2_p_2_t" name="sec_2_p_2_t" value="{{ old('sec_2_p_2_t', $template->sec_2_p_2_t ?? '') }}" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات نقطه ۲</label>
                            <textarea class="form-control" id="sec_2_p_2_d" name="sec_2_p_2_d" rows="2" placeholder="توضیحات">{{ old('sec_2_p_2_d', $template->sec_2_p_2_d ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان نقطه ۳</label>
                            <input type="text" class="form-control" id="sec_2_p_3_t" name="sec_2_p_3_t" value="{{ old('sec_2_p_3_t', $template->sec_2_p_3_t ?? '') }}" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات نقطه ۳</label>
                            <textarea class="form-control" id="sec_2_p_3_d" name="sec_2_p_3_d" rows="2" placeholder="توضیحات">{{ old('sec_2_p_3_d', $template->sec_2_p_3_d ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- بخش سوم -->
                <h5 class="mt-3 mb-3">بخش سوم</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان بخش سوم</label>
                            <input type="text" class="form-control" id="sec_3_t" name="sec_3_t" value="{{ old('sec_3_t', $template->sec_3_t ?? '') }}" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">متن کوتاه بخش سوم</label>
                            <input type="text" class="form-control" id="sec_3_m" name="sec_3_m" value="{{ old('sec_3_m', $template->sec_3_m ?? '') }}" placeholder="متن کوتاه">
                        </div>
                    </div>
                </div>

                <!-- بخش چهارم -->
                <h5 class="mt-3 mb-3">بخش چهارم</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان بخش چهارم</label>
                            <input type="text" class="form-control" id="sec_4_t" name="sec_4_t" value="{{ old('sec_4_t', $template->sec_4_t ?? '') }}" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">متن کوتاه بخش چهارم</label>
                            <input type="text" class="form-control" id="sec_4_m" name="sec_4_m" value="{{ old('sec_4_m', $template->sec_4_m ?? '') }}" placeholder="متن کوتاه">
                        </div>
                    </div>
                </div>

                <!-- بخش پنجم -->
                <h5 class="mt-3 mb-3">بخش پنجم</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">عنوان بخش پنجم</label>
                            <input type="text" class="form-control" id="sec_5_t" name="sec_5_t" value="{{ old('sec_5_t', $template->sec_5_t ?? '') }}" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">متن کوتاه بخش پنجم</label>
                            <input type="text" class="form-control" id="sec_5_m" name="sec_5_m" value="{{ old('sec_5_m', $template->sec_5_m ?? '') }}" placeholder="متن کوتاه">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات بخش پنجم</label>
                            <textarea class="form-control" id="sec_5_d" name="sec_5_d" rows="2" placeholder="توضیحات">{{ old('sec_5_d', $template->sec_5_d ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- بخش آیکون‌های تصویری -->
                <h5 class="mt-3 mb-3">تصاویر بخش ویژه (s_1_i تا s_5_i)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">تصویر s_1_i</label>
                            <input type="file" class="form-control" id="s_1_i" name="s_1_i">
                            @if(!empty($template->s_1_i))
                                <small class="form-text text-muted">فایل فعلی: {{ $template->s_1_i }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">تصویر s_2_i</label>
                            <input type="file" class="form-control" id="s_2_i" name="s_2_i">
                            @if(!empty($template->s_2_i))
                                <small class="form-text text-muted">فایل فعلی: {{ $template->s_2_i }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">تصویر s_3_i</label>
                            <input type="file" class="form-control" id="s_3_i" name="s_3_i">
                            @if(!empty($template->s_3_i))
                                <small class="form-text text-muted">فایل فعلی: {{ $template->s_3_i }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">تصویر s_4_i</label>
                            <input type="file" class="form-control" id="s_4_i" name="s_4_i">
                            @if(!empty($template->s_4_i))
                                <small class="form-text text-muted">فایل فعلی: {{ $template->s_4_i }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">تصویر s_5_i</label>
                            <input type="file" class="form-control" id="s_5_i" name="s_5_i">
                            @if(!empty($template->s_5_i))
                                <small class="form-text text-muted">فایل فعلی: {{ $template->s_5_i }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">ذخیره داده‌های قالب</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
