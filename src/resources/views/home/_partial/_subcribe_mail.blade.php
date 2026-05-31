<section class="section-parallax" data-src="{{asset('assets/home/images/bg/7.jpg')}}" data-stellar-background-ratio="0.5">
    <span class="overlay-section-bg black-section-bg"></span>
    <div class="container section-typo-white">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 text-center">
                <div class="subscribe-form">
                    <p id="subscribe-status-msg" class="hide"></p>
                    <form id="subscribe-form" class="subscribe-form" method="post" action="{{route('home.subscribe_mail')}}">
                        <div class="input-group subscribe-box">
                            <input type="text" class="form-control" name="mcemail" autocomplete="off" id="mcemail" placeholder="ایمیل شما">
                            <span class="input-group-btn">
										<button class="btn btn-default white-border typo-gray subscribe-btn" type="submit">عضویت</button>
										</span>
                        </div>
                        <!-- /input-group -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
