@extends('layouts.frontend.layout')
@section('slug', url('/'.$getPostDetails->slug))
@section('header_title', $getPostDetails->mata_title)
@section('header_description', $getPostDetails->mata_description)

@php
	$image = url('public/storage/image/on-image-thum.png');
	if ($getPostDetails->image != ''):
		$image = url('public/storage/image/post_image/' . $getPostDetails->image);
	endif;
	$post_date = date('F d, Y', strtotime($getPostDetails->created_at));
@endphp
				
@section('header_ogimage', $image)
@section('content')
    <div class="main-content content-sidebar-right col-sx-12 col-sm-12 col-md-8 col-lg-8">
        <div class="content-inner">
            <div class="box box-article single-1">
                
                <article id="post-3815"
                    class="post-3815 post type-post status-publish format-standard has-post-thumbnail hentry category-food">

                    <div class="post-image single-image image-single-1 ">
                        <img width="1280" height="640" src="{{ $image }}"
                            class="attachment-goody-single-post size-goody-single-post wp-post-image"
                            alt="Indian restaurant near me" loading="lazy" sizes="(max-width: 1280px) 100vw, 1280px">
                    </div>

                    <div class="entry-header clearfix">
                        <span class="post-cat"> <a href="https://blog.chefonline.co.uk/category/food/"
                                title="">{{ getCategoryName($getPostDetails->categories_id) }}</a>
                        </span>
                        <header class="entry-header-title">
                            <h1 class="entry-title">{{ $getPostDetails->title }}</h1>
                        </header>
                        <div class="entry-avatar">
                            <span class="byline"><span class="author vcard"><span class="screen-reader-text">
                                    </span><span class="by">By</span><a class="url fn n"
                                        href="{{ url($getPostDetails->slug) }}">ChefOnline</a></span></span>
                            <div class="posted-on post-date"><span class="author-on">on</span><span
                                    class="screen-reader-text"> </span><a href="{{ url($getPostDetails->slug) }}"
                                    rel="bookmark"><time class="entry-date published">{{ $post_date }}</time></a></div>
                            <div class="main-view-like">
                                <div class="total-view">
                                    <i class="fa fa-eye-slash"></i> {{ $getPostDetails->views }}
                                </div>
                                <!--<span class="comment-text">
                                    <a href="https://blog.chefonline.co.uk/reasons-why-you-should-order-indian-takeaway-for-dinner-tonight/#respond"
                                        class="text-comment"><i class="fa fa-comment-o" aria-hidden="true"></i> 0</a>
                                </span>-->
                            </div>

                        </div>
                    </div>
                    <div class="entry-content padding-content-single">
                        {!! $getPostDetails->description !!}
                    </div>

            </div><!-- end commentform -->
        </div><!-- end comments -->
        <div class="archive-blog post-related description-s">
            <h4 class="widgettitle">
                You may also like </h4>
            <div class="row">
                @if (!empty(getRecentRandomPosts()))
                    @foreach (getRecentRandomPosts() as $randomPosts)
                        @php
                            $image = url('public/storage/image/on-image-thum.png');
                            if ($randomPosts->image != ''):
                                $image = url('public/storage/image/post_image/thumbnail/big/' . $randomPosts->image);
                            endif;
                            $post_date = date('F d, Y', strtotime($randomPosts->created_at));
                        @endphp
                        <div class="col-md-6 col-sm-6 col-xs-6 item-related description-hidden">

                            <article
                                class="post-item post-grid clearfix post-3741 post type-post status-publish format-standard has-post-thumbnail hentry category-food">
                                <div class="article-tran">
                                    <div class="image-item">
                                        <a href="{{ url($randomPosts->slug) }}">
                                            <img class="lazy " src="{{ $image }}"
                                                data-original="{{ $image }}" data-lazy="{{ $image }}"
                                                alt="post-image" style="display: inline;">
                                        </a>
                                    </div>
                                    <div class="article-content">
                                        <span class="post-cat"> <a href="https://blog.chefonline.co.uk/category/food/"
                                                title="">{{ getCategoryName($randomPosts->categories_id) }}</a>
                                        </span>
                                        <div class="entry-header clearfix">
                                            <header class="entry-header-title">
                                                <h3 class="entry-title"><a href="{{ url($randomPosts->slug) }}"
                                                        rel="bookmark">{{ $randomPosts->title }}</a></h3>
                                            </header>
                                        </div>
                                        <div class="article-meta clearfix">
                                            <span class="byline"><span class="author vcard"><span
                                                        class="screen-reader-text"> </span><span
                                                        class="by">By</span><a class="url fn n"
                                                        href="{{ url($randomPosts->slug) }}">ChefOnline</a></span></span>
                                            <div class="posted-on post-date"><span class="author-on">on</span><span
                                                    class="screen-reader-text"> </span><a
                                                    href="{{ url($randomPosts->slug) }}"
                                                    rel="bookmark"><time class="entry-date published"
                                                        datetime="2021-12-14T07:05:04+00:00">{{ $post_date }}</time></a>
                                            </div>
                                            <div class="main-view-like">
                                                <div class="total-view">
                                                    <i class="fa fa-eye-slash"></i> {{ $randomPosts->views }}
                                                </div>
                                                <span class="comment-text">
                                                    <a href="{{ url($randomPosts->slug) }}"
                                                        class="text-comment"><i class="fa fa-comment-o"
                                                            aria-hidden="true"></i>
                                                        0</a>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </article><!-- #post-## -->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
