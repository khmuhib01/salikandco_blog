    <div id="archive-sidebar" class="sidebar sidebar-right  col-sx-12 col-sm-12 col-md-4 col-lg-4 archive-sidebar">
        <div class="content-inner">
            <aside id="text-8" class="widget widget_text">
                <h3 class="widgettitle">Welcome to</h3>
                <div class="textwidget">
                    <h1 class="widgettitle welcome">ChefOnline Food Blog</h1>
                </div>
            </aside>
            <aside id="text-9" class="widget widget_text">
                <h3 class="widgettitle">ChefOnline Service Rating</h3>
                <div class="textwidget">
                    <div class="trustpilot-widget" data-locale="en-GB" data-template-id="53aa8807dec7e10d38f59f32"
                        data-businessunit-id="5ba77b4d28ce1900011616cf" data-style-height="150px"
                        data-style-width="100%" data-theme="light"><a
                            href="https://uk.trustpilot.com/review/www.chefonline.co.uk" target="_blank"
                            rel="noopener">Trustpilot</a></div>
                    <p>
                        <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async>
                        </script>
                    </p>
                </div>
            </aside>
            <aside id="categories-6" class="widget widget_categories">
                <h3 class="widgettitle">Categories</h3>
                <ul>
                    @if (!empty(getSideBarCategories()))
                        @foreach (getSideBarCategories() as $category)
                            <li class="cat-item cat-item-377">
                                <a href="{{ url('category/'.$category->slug) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>

            </aside>
            <aside id="recent-posts-widget-with-thumbnails-2" class="widget recent-posts-widget-with-thumbnails">
                <div id="rpwwt-recent-posts-widget-with-thumbnails-2" class="rpwwt-widget">
                    <h3 class="widgettitle">RECENT POST</h3>
                    <ul>
                        @if (getRecentPosts())
                            @foreach (getRecentPosts() as $recentVal)
                                @php 
                                    $image = url('public/storage/image/on-image-thum.png');
                                    if ($recentVal->image !="") :
                                        $image = url('public/storage/image/post_image/thumbnail/big/'.$recentVal->image);
                                    endif;
                                    $post_date = date('F d, Y',strtotime($recentVal->created_at));
                                @endphp
                                <li><a href="{{ url($recentVal->slug) }}">
                                        <img width="120" height="100" src="{{ $image }}"
                                            class="attachment-120x100 size-120x100 wp-post-image" alt="ChefOnline"
                                            loading="lazy" /><span class="rpwwt-post-title">{{ $recentVal->title }}</span>
                                    </a>
                                    <div class="rpwwt-post-date">{{ $post_date }}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div><!-- .rpwwt-widget -->
            </aside>
            <aside id="weblizar_facebook_likebox-2" class="widget widget_weblizar_facebook_likebox">
                <h3 class="widgettitle">Like Us On Facebook</h3>
                <style>
                    @media (max-width:767px) {
                        .fb_iframe_widget {
                            width: 100%;
                        }

                        .fb_iframe_widget span {
                            width: 100% !important;
                        }

                        .fb_iframe_widget iframe {
                            width: 100% !important;
                        }

                        ._8r {
                            margin-right: 5px;
                            margin-top: -4px !important;
                        }
                    }
                </style>
                <div style="display:block;width:100%;float:left;overflow:hidden;margin-bottom:20px">
                    <div id="fb-root"></div>
                    <script>
                        (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-like-box" style="background-color: auto;" data-small-header="true"
                        data-height="400" data-href="https://www.facebook.com/ChefOnlineUK" data-show-border="true"
                        data-show-faces="true" data-stream="true" data-width="300" data-force-wall="false"></div>

                </div>
            </aside>
        </div>

    </div>
