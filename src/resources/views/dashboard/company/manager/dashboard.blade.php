@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-8">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="stats-box card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-1">
                                <div class="flex-grow-1 me-3">
                                    <h3 class="body-font fw-bold fs-3 mb-2">1100 تومان</h3>
                                    <span>کل فروش</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="icon transition">
                                        <i class="flaticon-donut-chart"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="svg-success me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                </div>
                                <p class="fw-semibold"><span class="text-success">%1.3</span> بالاتر از هفته گذشته</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="stats-box card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-1">
                                <div class="flex-grow-1 me-3">
                                    <h3 class="body-font fw-bold fs-3 mb-2">1100 تومان</h3>
                                    <span>کل سفارش</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="icon transition">
                                        <i class="flaticon-goal"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="svg-danger me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                                </div>
                                <p class="fw-semibold"><span class="text-danger">%1.3</span> پایین تر از هفته گذشته</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="stats-box card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-1">
                                <div class="flex-grow-1 me-3">
                                    <h3 class="body-font fw-bold fs-3 mb-2">183.35 عضو</h3>
                                    <span>کل مشتریان</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="icon transition">
                                        <i class="flaticon-award"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="svg-success me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                </div>
                                <p class="fw-semibold"><span class="text-success">%1.3</span> بالاتر از هفته گذشته</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-xxl-4">
            <div class="stats-box ratings card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-sm-0">
                            <h4 class="fs-18 fw-semibold mb-2">رتبه بندی ها</h4>
                            <span class="fw-semibold d-block mb-3 text-gray-light">سال 1402</span>
                            <h3 class="body-font fw-bold fs-24 mb-3">8.14k <sub class="text-gray-light fw-normal">بررسی</sub></h3>
                            <div class="d-flex align-items-center">
                                <div class="svg-warning me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star" style="width: 20px; height: 20px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                </div>
                                <p class="fw-semibold"><span class="text-body me-1">4.5</span> <span class="text-primary">%+15.6</span> از دوره قبل</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div id="ratings_chart" style="min-height: 105.7px;"><div id="apexchartsw4zt983m" class="apexcharts-canvas apexchartsw4zt983m apexcharts-theme-light" style="width: 100px; height: 105.7px;"><svg id="SvgjsSvg1938" width="100" height="105.7" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="100" height="105.7"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"></div></foreignObject><g id="SvgjsG1940" class="apexcharts-inner apexcharts-graphical" transform="translate(-0.5, 0)"><defs id="SvgjsDefs1939"><clipPath id="gridRectMaskw4zt983m"><rect id="SvgjsRect1941" width="109" height="127" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskw4zt983m"></clipPath><clipPath id="nonForecastMaskw4zt983m"></clipPath><clipPath id="gridRectMarkerMaskw4zt983m"><rect id="SvgjsRect1942" width="107" height="129" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1943" class="apexcharts-pie"><g id="SvgjsG1944" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle1945" r="30.97073170731708" cx="51.5" cy="51.5" fill="transparent"></circle><g id="SvgjsG1946" class="apexcharts-slices"><g id="SvgjsG1947" class="apexcharts-series apexcharts-pie-series" seriesName="خوب" rel="1" data:realIndex="0"><path id="SvgjsPath1948" d="M 51.5 7.256097560975604 A 44.243902439024396 44.243902439024396 0 0 1 90.27122725852607 72.81466255659784 L 78.63985908096825 66.42026378961849 A 30.97073170731708 30.97073170731708 0 0 0 51.5 20.52926829268292 L 51.5 7.256097560975604 z" fill="rgba(55,48,163,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="118.8" data:startAngle="0" data:strokeWidth="2" data:value="33" data:pathOrig="M 51.5 7.256097560975604 A 44.243902439024396 44.243902439024396 0 0 1 90.27122725852607 72.81466255659784 L 78.63985908096825 66.42026378961849 A 30.97073170731708 30.97073170731708 0 0 0 51.5 20.52926829268292 L 51.5 7.256097560975604 z" stroke="#ffffff"></path></g><g id="SvgjsG1949" class="apexcharts-series apexcharts-pie-series" seriesName="بهتر" rel="2" data:realIndex="1"><path id="SvgjsPath1950" d="M 90.27122725852607 72.81466255659784 A 44.243902439024396 44.243902439024396 0 0 1 14.143637637544984 75.20706844126585 L 25.35054634628149 68.0949479088861 A 30.97073170731708 30.97073170731708 0 0 0 78.63985908096825 66.42026378961849 L 90.27122725852607 72.81466255659784 z" fill="rgba(117,127,239,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="118.8" data:startAngle="118.8" data:strokeWidth="2" data:value="33" data:pathOrig="M 90.27122725852607 72.81466255659784 A 44.243902439024396 44.243902439024396 0 0 1 14.143637637544984 75.20706844126585 L 25.35054634628149 68.0949479088861 A 30.97073170731708 30.97073170731708 0 0 0 78.63985908096825 66.42026378961849 L 90.27122725852607 72.81466255659784 z" stroke="#ffffff"></path></g><g id="SvgjsG1951" class="apexcharts-series apexcharts-pie-series" seriesName="برتر" rel="3" data:realIndex="2"><path id="SvgjsPath1952" d="M 14.143637637544984 75.20706844126585 A 44.243902439024396 44.243902439024396 0 0 1 51.492277982324275 7.256098234848771 L 51.49459458762699 20.52926876439414 A 30.97073170731708 30.97073170731708 0 0 0 25.35054634628149 68.0949479088861 L 14.143637637544984 75.20706844126585 z" fill="rgba(56,189,248,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-2" index="0" j="2" data:angle="122.4" data:startAngle="237.6" data:strokeWidth="2" data:value="34" data:pathOrig="M 14.143637637544984 75.20706844126585 A 44.243902439024396 44.243902439024396 0 0 1 51.492277982324275 7.256098234848771 L 51.49459458762699 20.52926876439414 A 30.97073170731708 30.97073170731708 0 0 0 25.35054634628149 68.0949479088861 L 14.143637637544984 75.20706844126585 z" stroke="#ffffff"></path></g></g></g><g id="SvgjsG1953" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"><text id="SvgjsText1954" font-family="Open Sans" x="51.5" y="59.5" text-anchor="middle" dominant-baseline="auto" font-size="28px" font-weight="700" fill="#260944" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Open Sans&quot;;">100</text></g></g><line id="SvgjsLine1955" x1="0" y1="0" x2="103" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1956" x1="0" y1="0" x2="103" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g></svg><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(55, 48, 163);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(117, 127, 239);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 3;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(56, 189, 248);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                        <h4 class="fw-bold fs-18 mb-0">بازدیدهای زنده از سایت ما</h4>
                        <div class="dropdown action-opt">
                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        امروز
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                        7 روز گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                                        ماه گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        1 سال گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                        همیشه
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        مشاهده
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        حذف
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="live_visits_on_our_site" style="min-height: 251.8px;"><div id="apexchartsttxs17zk" class="apexcharts-canvas apexchartsttxs17zk apexcharts-theme-light" style="width: 454px; height: 251.8px;"><svg id="SvgjsSvg1957" width="454" height="251.79999999999998" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="454" height="251.79999999999998"><div class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom" xmlns="http://www.w3.org/1999/xhtml" style="inset: auto 0px 5px; position: absolute; max-height: 140px;"><div class="apexcharts-legend-series" rel="1" seriesname="داخلیx-x72x" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="1" data:collapsed="false" style="background: rgb(238, 54, 140) !important; color: rgb(238, 54, 140); height: 15px; width: 15px; left: -2px; top: 1px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 5px;"></span><span class="apexcharts-legend-text" rel="1" i="0" data:default-text="%D8%AF%D8%A7%D8%AE%D9%84%DB%8C%20-%2072%25" data:collapsed="false" style="color: rgb(145, 154, 163); font-size: 14px; font-weight: 400; font-family: &quot;Open Sans&quot;;">داخلی - 72%</span></div><div class="apexcharts-legend-series" rel="2" seriesname="بینxالمللیx-x56x" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="2" data:collapsed="false" style="background: rgb(117, 127, 239) !important; color: rgb(117, 127, 239); height: 15px; width: 15px; left: -2px; top: 1px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 5px;"></span><span class="apexcharts-legend-text" rel="2" i="1" data:default-text="%D8%A8%DB%8C%D9%86%20%D8%A7%D9%84%D9%85%D9%84%D9%84%DB%8C%20-%2056%25" data:collapsed="false" style="color: rgb(145, 154, 163); font-size: 14px; font-weight: 400; font-family: &quot;Open Sans&quot;;">بین المللی - 56%</span></div></div><style type="text/css">

                                        .apexcharts-legend {
                                            display: flex;
                                            overflow: auto;
                                            padding: 0 10px;
                                        }
                                        .apexcharts-legend.apx-legend-position-bottom, .apexcharts-legend.apx-legend-position-top {
                                            flex-wrap: wrap
                                        }
                                        .apexcharts-legend.apx-legend-position-right, .apexcharts-legend.apx-legend-position-left {
                                            flex-direction: column;
                                            bottom: 0;
                                        }
                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left, .apexcharts-legend.apx-legend-position-top.apexcharts-align-left, .apexcharts-legend.apx-legend-position-right, .apexcharts-legend.apx-legend-position-left {
                                            justify-content: flex-start;
                                        }
                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center, .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                            justify-content: center;
                                        }
                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right, .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                            justify-content: flex-end;
                                        }
                                        .apexcharts-legend-series {
                                            cursor: pointer;
                                            line-height: normal;
                                        }
                                        .apexcharts-legend.apx-legend-position-bottom .apexcharts-legend-series, .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series{
                                            display: flex;
                                            align-items: center;
                                        }
                                        .apexcharts-legend-text {
                                            position: relative;
                                            font-size: 14px;
                                        }
                                        .apexcharts-legend-text *, .apexcharts-legend-marker * {
                                            pointer-events: none;
                                        }
                                        .apexcharts-legend-marker {
                                            position: relative;
                                            display: inline-block;
                                            cursor: pointer;
                                            margin-right: 3px;
                                            border-style: solid;
                                        }

                                        .apexcharts-legend.apexcharts-align-right .apexcharts-legend-series, .apexcharts-legend.apexcharts-align-left .apexcharts-legend-series{
                                            display: inline-block;
                                        }
                                        .apexcharts-legend-series.apexcharts-no-click {
                                            cursor: auto;
                                        }
                                        .apexcharts-legend .apexcharts-hidden-zero-series, .apexcharts-legend .apexcharts-hidden-null-series {
                                            display: none !important;
                                        }
                                        .apexcharts-inactive-legend {
                                            opacity: 0.45;
                                        }</style></foreignObject><g id="SvgjsG1959" class="apexcharts-inner apexcharts-graphical" transform="translate(12, 0)"><defs id="SvgjsDefs1958"><clipPath id="gridRectMaskttxs17zk"><rect id="SvgjsRect1960" width="436" height="209" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskttxs17zk"></clipPath><clipPath id="nonForecastMaskttxs17zk"></clipPath><clipPath id="gridRectMarkerMaskttxs17zk"><rect id="SvgjsRect1961" width="436" height="213" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1962" class="apexcharts-pie"><g id="SvgjsG1963" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle1964" r="68.56585365853658" cx="216" cy="104.5" fill="transparent"></circle><g id="SvgjsG1965" class="apexcharts-slices"><g id="SvgjsG1966" class="apexcharts-series apexcharts-pie-series" seriesName="داخلیx-x72x" rel="1" data:realIndex="0"><path id="SvgjsPath1967" d="M 216 6.548780487804876 A 97.95121951219512 97.95121951219512 0 1 1 178.5156911127268 194.99512689183726 L 189.76098377890878 167.84658882428607 A 68.56585365853658 68.56585365853658 0 1 0 216 35.93414634146342 L 216 6.548780487804876 z" fill="rgba(238,54,140,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="202.5" data:startAngle="0" data:strokeWidth="0" data:value="72" data:pathOrig="M 216 6.548780487804876 A 97.95121951219512 97.95121951219512 0 1 1 178.5156911127268 194.99512689183726 L 189.76098377890878 167.84658882428607 A 68.56585365853658 68.56585365853658 0 1 0 216 35.93414634146342 L 216 6.548780487804876 z"></path></g><g id="SvgjsG1968" class="apexcharts-series apexcharts-pie-series" seriesName="بینxالمللیx-x56x" rel="2" data:realIndex="1"><path id="SvgjsPath1969" d="M 178.5156911127268 194.99512689183726 A 97.95121951219512 97.95121951219512 0 0 1 215.98290428721847 6.548781979687249 L 215.9880330010529 35.93414738578109 A 68.56585365853658 68.56585365853658 0 0 0 189.76098377890878 167.84658882428607 L 178.5156911127268 194.99512689183726 z" fill="rgba(117,127,239,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="157.5" data:startAngle="202.5" data:strokeWidth="0" data:value="56" data:pathOrig="M 178.5156911127268 194.99512689183726 A 97.95121951219512 97.95121951219512 0 0 1 215.98290428721847 6.548781979687249 L 215.9880330010529 35.93414738578109 A 68.56585365853658 68.56585365853658 0 0 0 189.76098377890878 167.84658882428607 L 178.5156911127268 194.99512689183726 z"></path></g></g></g><g id="SvgjsG1970" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"><text id="SvgjsText1971" font-family="Open Sans" x="216" y="100.5" text-anchor="middle" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#5b5b98" class="apexcharts-text apexcharts-datalabel-label" style="font-family: &quot;Open Sans&quot;;">بازدید زنده</text><text id="SvgjsText1972" font-family="Open Sans" x="216" y="128.5" text-anchor="middle" dominant-baseline="auto" font-size="28px" font-weight="700" fill="#260944" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Open Sans&quot;;">128</text></g></g><line id="SvgjsLine1973" x1="0" y1="0" x2="432" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1974" x1="0" y1="0" x2="432" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g></svg><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(238, 54, 140);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(117, 127, 239);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
                </div>
            </div>
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                        <h4 class="fw-bold fs-18 mb-0">فروش بر اساس مکان</h4>
                        <div class="dropdown action-opt">
                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        امروز
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                        7 روز گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                                        ماه گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        1 سال گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                        همیشه
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        مشاهده
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        حذف
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations mt-4">
                        <li>
                            <span class="fw-semibold d-block mb-2">کانادا</span>
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 75%">
                                    <span class="count fw-semibold text-body">%75</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-semibold d-block mb-2">روسیه</span>
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 55%">
                                    <span class="count fw-semibold text-body">%55</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-semibold d-block mb-2">گرینلند</span>
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 45%">
                                    <span class="count fw-semibold text-body">%45</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-semibold d-block mb-2">آمریکا</span>
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 35%">
                                    <span class="count fw-semibold text-body">%35</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                        <h4 class="fw-bold fs-18 mb-0">مشتریان جدید</h4>
                        <div class="dropdown action-opt">
                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        امروز
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                        7 روز گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                                        ماه گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        1 سال گذشته
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                        همیشه
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        مشاهده
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        حذف
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="ps-0 mb-0 list-unstyled max-h-198" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="left: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
                                            <li class="border-bottom border-color-gray mb-3 pb-3">
                                                <div class="d-sm-flex justify-content-between align-content-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-1.jpg" class="rounded-circle wh-44" alt="user-1">
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <h4 class="fw-semibold fs-16 mb-0">جردن استیونسون</h4>
                                                            <span class="text-gray-light">@jstevenson5c</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2 mt-sm-0">
                                                        <span>1100 تومان</span>
                                                        <span class="bg-opacity-10 bg-primary fs-13 fw-semibold text-primary py-1 px-3 rounded-pill ms-10">15 سفارش</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="border-bottom border-color-gray mb-3 pb-3">
                                                <div class="d-sm-flex justify-content-between align-content-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-2.jpg" class="rounded-circle wh-44" alt="user-2">
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <h4 class="fw-semibold fs-16 mb-0">لیدیا ریس</h4>
                                                            <span class="text-gray-light">@lreese3b</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2 mt-sm-0">
                                                        <span>1100 تومان</span>
                                                        <span class="bg-opacity-10 bg-primary fs-13 fw-semibold text-primary py-1 px-3 rounded-pill ms-10">17 سفارش</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-sm-flex justify-content-between align-content-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="assets/images/user-3.jpg" class="rounded-circle wh-44" alt="user-3">
                                                        </div>
                                                        <div class="flex-grow-1 ms-10">
                                                            <h4 class="fw-semibold fs-16 mb-0">ایسین عرفات</h4>
                                                            <span class="text-gray-light">@jstevenson6c</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2 mt-sm-0">
                                                        <span>1100 تومان</span>
                                                        <span class="bg-opacity-10 bg-primary fs-13 fw-semibold text-primary py-1 px-3 rounded-pill ms-10">19 سفارش</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 198px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-white border-0 rounded-10 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                <h4 class="fw-bold fs-18 mb-0">سفارشات اخیر</h4>
                <div class="dropdown action-opt">
                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                امروز
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                7 روز گذشته
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                                ماه گذشته
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                1 سال گذشته
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                همیشه
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                مشاهده
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                حذف
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="default-table-area recent-orders">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th scope="col" class="text-primary">شناسه سفارش</th>
                            <th scope="col">محصول</th>
                            <th scope="col">مشتری</th>
                            <th scope="col">قیمت</th>
                            <th scope="col">فروشنده</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col">وضعیت</th>
                            <th scope="col">امتیاز</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="fw-semibold">#SK258</td>
                            <td>
                                <a href="product-details.html" class="d-flex align-items-center">
                                    <img src="assets/images/product-1.jpg" class="wh-55 rounded-3" alt="product-1">
                                    <h6>لپ تاپ شماره 1</h6>
                                </a>
                            </td>
                            <td>کالین فریک</td>
                            <td>1100 تومان</td>
                            <td>مد بوتیک</td>
                            <td>1402/10/19</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 fw-semibold">انتظار</span>
                            </td>
                            <td>5.0 (61 رای)</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">#AA257</td>
                            <td>
                                <a href="product-details.html" class="d-flex align-items-center">
                                    <img src="assets/images/product-2.jpg" class="wh-55 rounded-3" alt="product-2">
                                    <h6>دوربین هوشمند</h6>
                                </a>
                            </td>
                            <td>آلینا اسمیت</td>
                            <td>1100 تومان</td>
                            <td>دوربین</td>
                            <td>1402/10/19</td>
                            <td>
                                <span class="badge bg-danger bg-opacity-10 text-danger py-2 px-3 fw-semibold">اتمام موجودی</span>
                            </td>
                            <td>4.9 (55 رای)</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">#BB256</td>
                            <td>
                                <a href="product-details.html" class="d-flex align-items-center">
                                    <img src="assets/images/product-3.jpg" class="wh-55 rounded-3" alt="product-3">
                                    <h6>هدفون بی‌سیم</h6>
                                </a>
                            </td>
                            <td>جیمز اندی</td>
                            <td>1100 تومان</td>
                            <td>بي سيم</td>
                            <td>1402/10/19</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success py-2 px-3 fw-semibold">تحویل داده شده</span>
                            </td>
                            <td>5.0 (61 رای)</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">#CC255</td>
                            <td>
                                <a href="product-details.html" class="d-flex align-items-center">
                                    <img src="assets/images/product-4.jpg" class="wh-55 rounded-3" alt="product-4">
                                    <h6>ساعت هوشمند</h6>
                                </a>
                            </td>
                            <td>سارا تیلور</td>
                            <td>1100 تومان</td>
                            <td>دوربین</td>
                            <td>1402/10/19</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 fw-semibold">انتظار</span>
                            </td>
                            <td>5.0 (196 رای)</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">#DD254</td>
                            <td>
                                <a href="product-details.html" class="d-flex align-items-center">
                                    <img src="assets/images/product-5.jpg" class="wh-55 rounded-3" alt="product-5">
                                    <h6>ساعت هوشمند پرو</h6>
                                </a>
                            </td>
                            <td>دیوید وارنر</td>
                            <td>1100 تومان</td>
                            <td>ساعت</td>
                            <td>1402/10/19</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success py-2 px-3 fw-semibold">تحویل داده شده</span>
                            </td>
                            <td>3.0 (54 رای)</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-sm-flex justify-content-between align-items-center text-center">
                    <span class="fs-14">نمایش 1 تا 5 از 20 ورودی</span>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0 mt-3 mt-sm-0 justify-content-center">
                            <li class="page-item">
                                <a class="page-link icon" href="index.html" aria-label="Previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="index.html">1</a></li>
                            <li class="page-item"><a class="page-link" href="index.html">2</a></li>
                            <li class="page-item"><a class="page-link" href="index.html">3</a></li>
                            <li class="page-item">
                                <a class="page-link icon" href="index.html" aria-label="Next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
