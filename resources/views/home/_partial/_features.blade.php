<section class="padding-bottom-50" id="features">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-12">
                <div class="section-title">
                    <h2 class="section-title-divider primary-divider">ویژگی های ما</h2>
                    <!-- SECTION TITLE -->
                    <p>با توجه به تعدد رقبا خالی از لطف نیست که بعضی از برتری های ما نسبت به آن ها را نیز ملاحضه کنید .</p>
                </div>
            </div>
        </div>
        @php $features = [
         ['icon'=>'fa fa-fighter-jet','title' => 'رشد کسب کار','description'=>'استفاده از سیستم حسابداری و جلو گیری از به هدر رفتن نیروی انسانی و پردازش ها سریع نیز از ویژگی های متمایز ماست .'],
         ['icon'=>'fa fa-server','title' => 'جلوگیری از عدم دسترسی','description'=>'با توجه به وضیعیت اینترنت در کشور ، این امکان را فراهم کردیم که هیچ موقع با قطعی های شما به سکو قطع نشود .'],
         ['icon'=>'fa fa-code','title' => 'هوشمندسازی','description'=>'یکی از مهمترین ویژگی های پنل استفاده از اتوماسیون همراه با عرف این نوع کسب و کار هست'],
         ['icon'=>'fa fa-cubes','title' => 'امنیت دیتا','description'=>'بزرگترین هدف تیم ما امن بودن داده های کسب و کار شماست'],
         ['icon'=>'fa fa-desktop','title' => 'عدم وابستگی سیستم واحد','description'=>'این امکان فراهم شده تا نیازی به اشغال و استفاده از یک سیستم واحد برای کار با سکو نیازی نباشد .'],
         ['icon'=>'fa fa fa-bar-chart','title' => 'گزارشات جامع','description'=>'امکان تحیه گزارش های جامع و کارآمد برای تحلیل های استراتژیک و هدفمند'],

         ]; @endphp
        <div class="row margin-bottom-0">
            @foreach($features as $feature)
            <div class="col-sm-4">
                <div class="media feature-box">
                    <div class="media-left">
									<span class="feature-icon">
									<i class="{{$feature['icon']}}"></i>
									</span>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{$feature['title']}}</h4>
                        <p>{{$feature['description']}}</p>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>
