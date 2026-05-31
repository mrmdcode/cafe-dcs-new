
<section class="contact-section" id="contact">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="section-title">
                    <h2 class="section-title-divider primary-divider">(درخواست مشاوره)تماس با ما</h2>
                    <!-- SECTION TITLE -->
                    <p>
                        اگر چنانچه به کمک بیشتری برای ثبت درخواست یا برای سفارش دادن پلتفرم نیاز دارید ، میتوانید درخواست مشاوره یا خرید بدهید .
                    </p>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-4">
                <div class="contact-adress">
                    <p class="contact-icons"><i class="fa fa-map-marker primary-color"></i></p>
                    <div class="padding-tb-20">
                        <p>
                            ایران<br />
                            سبزوار
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-mail">
                    <p class="contact-icons"><i class="fa fa-envelope-o primary-color"></i></p>
                    <div class="padding-tb-20">
                        <a href="mail:mrmdcode@gmail.com">mrmdcode@gmail.com</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-number">
                    <p class="contact-icons"><i class="fa fa-phone primary-color"></i></p>
                    <div class="padding-tb-20">
                        <p>
                            <a href="tel:+989389512885">09389512885</a>
                            <br />
                            <a href="tel:+989154738625">09154738625</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="contact-form">
                <p id="contact-status-msg" class="hide"></p>
                <form id="contact-form" class="contact-form" method="post" action="{{route('home.contact_us')}}">
                    @csrf
                    <div class="col-md-4 col-md-offset-2 padding-bottom-20">
                        <div class="form-group">
                            <input id="name" class="form-control" name="name" autocomplete="off" placeholder="نام" data-bv-field="name" type="text" />
                        </div>
                    </div>
                    <div class="col-md-4 padding-bottom-20">
                        <div class="form-group">
                            <input id="email" class="form-control" name="email" autocomplete="off" placeholder="ایمیل" data-bv-field="email" type="email">
                        </div>
                    </div>
                    <span class="clearfix"></span>
                    <div class="contact-message col-md-8 col-md-offset-2">
                        <div class="form-group margin-bottom-0">
                            <textarea id="message" class="form-control textarea" rows="3" name="message" placeholder="پیام" data-bv-field="message"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 padding-top-30">
                        <button type="submit" class="btn btn-default btn-xl btn-normal margin-top-20 contact-btn">ثبت درخواست</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
