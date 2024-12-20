<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">


    <title>@yield('header_title')</title>
    <meta name="description" content="@yield('header_description')" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}" media="all" />    
    <script async src="{{ asset('assets/js/all.js') }}"></script>
</head>

<body class="home blog">

    <div class="hidden" itemscope itemtype="http://schema.org/Organization">
        <span itemprop="name">Salik & Co Blog</span>
        <span itemprop="company">Salik & Co</span>
        <span itemprop="tel">+44 (0) 207 729 5447</span>
    </div>
    <div id="page" class="wrapper site">
        <div class="canvas-overlay"></div>

        <header id="masthead" class="site-header header-left">
            <div id="goody-header">
                <div class="header-content-logo container">
                    <div class="site-logo" id="logo">
                        <a href="https://www.salikandco.com/blog/" rel="home">
                            <img src="{{ asset('assets/images/frontend/logo.png') }}"
                                alt="Salik &amp; Co Blog | Reviews, Recipes, And Everything Foody" />
                        </a>
                    </div>

                    <div class="header-middle">
                        <div id="information_widget-6" class="widget first information_widget">
                            <div class="goody-image-content">
                                <a class="clearfix" href="https://www.salikandco.com/blog/" target="_blank">
                                    <img class="goody-image"
                                        src="{{ asset('assets/images/frontend/Web-blog-final-1.jpg') }}" alt="img" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="header-content header-fixed">
                    <div class="goody-header-content container">
                        <!-- Menu-->
                        <div id="na-menu-primary" class="nav-menu clearfix">
                            <nav class="text-center na-menu-primary clearfix">
                                <ul id="menu-primary-navigation" class="nav navbar-nav na-menu mega-menu">
                                    <li id="menu-item-2485"
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2485">
                                        <a href="https://www.salikandco.com/blog/">Home</a>
                                    </li>
                                    @if (!empty(getCategories()))
                                        @foreach (getCategories() as $category)
                                            <li id="menu-item-2485"
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2485">
                                                <a href="{{ url('category/'.$category->slug) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        <!--Seacrch & Cart-->
                        {{-- <div class="header-content-right">

                            <div class="header-social">
                                <div id="goody_social-4" class="widget first goody_social">
                                    <div class="goody-social-icon clearfix"><a
                                            href="https://www.facebook.com/ChefOnlineUK" title="ion-social-facebook"
                                            class="ion-social-facebook"><i class="fa fa-facebook"></i></a><a
                                            href="https://twitter.com/chefonlineuk" title="ion-social-twitter"
                                            class="ion-social-twitter"><i class="fa fa-twitter"></i></a><a
                                            href="https://www.instagram.com/chefonlineuk" title="ion-social-instagram"
                                            class="ion-social-instagram"><i class="fa fa-instagram"></i></a><a
                                            href="https://www.pinterest.com/chefonlineuk" title="ion-social-pinterest"
                                            class="ion-social-pinterest"><i class="fa fa-pinterest"></i></a><a
                                            href="https://www.youtube.com/channel/UCiuWjkTLdvJQ6EJECQa-7Zw"
                                            title="ion-social-youtube" class="ion-social-youtube"><i
                                                class="fa fa-youtube"></i></a><a
                                            href="https://www.linkedin.com/company/chef-online"
                                            title="ion-social-linkedin" class="ion-social-linkedin"><i
                                                class="fa fa-linkedin"></i></a></div>
                                </div>
                            </div>

                        </div> --}}
                    </div>
                </div>
            </div>
        </header><!-- .site-header -->

        <div id="content" class="site-content">
            <div class="wrap-content container" role="main">
                @if (Request::segment(1) == 'login' || Request::segment(2) == 'reset')
                    <div class="row content-category">
                        @yield('content')
                    </div><!-- .content-area -->
                @else
                    <div class="row content-category">
                        @yield('content')
                        @include('layouts/frontend/sidebar')
                    </div><!-- .content-area -->
                @endif
            </div>
        </div><!-- .site-content -->

        <footer id="footer">
            <!--Footer box starts Here -->
            <div class="footer clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="our-address">
                                <h5>ABOUT SALIK & CO</h5>
                                <div class="quick-list">
                                    <ul>
                                        <li>
                                            <a href="https://www.salikandco.com/about">About</a>
                                        </li>                            <li>
                                            <a href="https://www.salikandco.com/selling">Selling</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/buying">Buying</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/property-management">Property Management</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/landlords">Landlords</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/tenants">Tenants</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/inventory">Inventory</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="our-address">
                                <h5>SERVING AREAS</h5>
                                <div class="quick-list">
                                    <ul>
                                        <li>
                                            <a href="https://www.salikandco.com/sales">Sales</a>
                                        </li>
                                        <li>
                                            <a
                                                href="https://www.salikandco.com/lettings">Letting</a>
                                        </li>
                                        <li>
                                            <a
                                                href="https://www.salikandco.com/valuation">Valuation</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/howtorent">How to Rent</a>
                                        </li>
                                        
                                        <li>
                                            <b><a href="https://www.salikandco.com/fees-and-charges">Fees and Charges</a></b>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="our-address">
                                <h5>COMPANY</h5>                          
                                <div class="quick-list">
                                    <ul>
                                        <li>
                                            <a href="https://www.salikandco.com/privacy">Privacy Policy</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/terms">Terms & Conditions</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/cookies">Cookies Policy</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/complaint-procedure">Complaints Procedure</a>
                                        </li>
                                        <li>
                                            <a href="https://www.salikandco.com/client-money-protection">Client Money Protection</a>
                                        </li>
                                        <li>
                                            <b><a href="https://www.salikandco.com/faq">Faq</a></b>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="our-address">
                                <h5>SOCIAL MEDIA</h5>
                                <p>FOLLOW US ON</p>
                                <div class="quick-list">
                                    <ul class="social">
                                        <li>
                                            <a href="https://www.facebook.com/salikandcobricklane/">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.x.com/salikandco">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a href="https://www.instagram.com/chefonlineuk">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.pinterest.com/chefonlineuk">
                                                <i class="fa fa-pinterest"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.youtube.com/channel/UCiuWjkTLdvJQ6EJECQa-7Zw">
                                                <i class="fa fa-youtube" aria-hidden="true"></i>

                                            </a>
                                        </li> --}}
                                        <li>
                                            <a href="https://www.linkedin.com/company/salik-and-co">
                                                <i class="fa fa-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Footer box ends Here -->
            </div>
        </footer>

        <div class="copyright text-center">
            <div class="container">
                <div class="col-xs-12 col-sm-12 copyright-content">
                    Copyright © {{ date('Y') }} <a href="https://www.salikandco.com">Salik & Co</a>. All rights reserved.
                </div>
            </div>
        </div>

        <script async src="js/custome.js"></script>

        <style>
            footer#footer .footer {
                background-color: #fff;
                border-color: #e9eaee;
                padding-bottom: 15px;
                padding-top: 45px;
                border-top: 1px solid #f7f7f7;
            }

            footer#footer .footer .our-address {
                margin-bottom: 25px;
                overflow: hidden;
            }


            footer#footer .footer h5 {
                color: #000;
                font-size: 16px;
                font-weight: 600;
                margin: 0 0 14px;
                padding-bottom: 15px;
                position: relative;
                text-transform: uppercase;
                letter-spacing: 0.35px;
            }

            footer#footer .footer h5::after {
                background: #ed193a;
                bottom: 0;
                content: "";
                display: block;
                height: 2px;
                left: 0;
                position: absolute;
                width: 20px;
                transition: all 0.3s ease;
            }

            footer#footer .footer h5:hover::after {
                width: 45px;
            }

            footer#footer .quick-list {
                float: left;
            }

            footer#footer .quick-list ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            footer#footer .quick-list ul li {
                border-bottom: 1px solid #ececec;
            }

            footer#footer .quick-list ul li:last-child {
                border: none;
            }

            footer#footer .quick-list li a {
                color: #000;
                display: block;
                padding: 10px 0;
                font-size: 13px;
                -webkit-transition: all .25s ease-in-out;
                -moz-transition: all .25s ease-in-out;
                -ms-transition: all .25s ease-in-out;
                -o-transition: all .25s ease-in-out;
                transition: all .25s ease-in-out;
            }

            footer#footer .quick-list li a:hover {
                color: #ed193a;
            }

            footer#footer p {
                color: #000;
                font-size: 13px;
            }

            footer#footer .quick-list {
                float: left;
            }

            footer#footer .quick-list ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            footer#footer .social {
                padding: 0;
                margin: 0;
                list-style-type: none;
                display: inline-block;
            }

            footer#footer .quick-list .social li {
                border: medium none;
                display: inline-block;
                float: left;
                margin-right: 3px;
                text-align: center;
                vertical-align: top;
            }

            footer#footer .quick-list li a {
                color: #000;
                display: block;
                padding: 10px 0;
                -webkit-transition: all .25s ease-in-out;
                -moz-transition: all .25s ease-in-out;
                -ms-transition: all .25s ease-in-out;
                -o-transition: all .25s ease-in-out;
                transition: all .25s ease-in-out;
            }

            footer#footer .social li a .fa {
                border-radius: 0;
                color: #ffffff;
                font-size: 13px;
                height: 30px;
                line-height: 30px;
                text-align: center;
                transition: all 0.9s ease 0s;
                width: 30px;
            }

            footer#footer .social li a .fa.fa-linkedin {
                background: #0B74B1;
            }

            footer#footer .social li a .fa.fa-facebook {
                background: #3b5998;
            }

            footer#footer .social li a .fa.fa-twitter {
                background: #00bdec;
            }

            footer#footer .social li a .fa.fa-pinterest {
                background: #BD081C;
            }

            footer#footer .social li a .fa.fa-instagram {
                background: #D22D8F;
            }

            footer#footer .social li a .fa.fa-youtube {
                background: #FE0002 none repeat scroll 0 0;
            }

            footer#footer .quick-list .social li a {
                padding: 0;
            }

            .copyright {
                background-color: #000;
                border-top: 1px solid #4b4c4d;
                color: #fff;
                display: table;
                padding-bottom: 20px;
                padding-top: 20px;
                width: 100%;
            }

            .copyright-content {
                display: table-cell;
                line-height: 22px;
                vertical-align: middle;
                font-size: 11px;
            }

            .copyright-content a {
                color: #ed193a;
                -webkit-transition: all .25s ease-in-out;
                -moz-transition: all .25s ease-in-out;
                -ms-transition: all .25s ease-in-out;
                -o-transition: all .25s ease-in-out;
                transition: all .25s ease-in-out;
            }

        </style>
</body>

</html>

<script type="text/javascript">
    WebFontConfig = {
        google: {
            families: ['Roboto:300,300i,400,400i,500,700,900']
        }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>