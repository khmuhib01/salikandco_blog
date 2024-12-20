@extends('layouts.frontend.layout')
@php
$slug = url('/');
if (Request::segment(1)) :
    $slug = url('/'.Request::segment(1).'/'.Request::segment(2));
endif;
@endphp
@section('slug', $slug)
@section('header_title', 'Salik & Co | Estate Agent | Sales Lettings & Management | East London')
@section('header_description', 'Independent estate agent from East London covering Brick Lane, Shoreditch, Bethnal Green Whitechapel specializing in property sales, lettings management.')
@section('content')
    <div class="main-content content-cat-8 col-sx-12 col-sm-12 col-md-8 col-lg-8">
        <div class="archive-blog  row ct-list">
            <div class="rows">
                <div class="item-post col-item col-xs-12">
                    @if (!empty($records))
                        @forelse ($records as $val)
                            <article
                                class="post-item post-list clearfix post-3832 post type-post status-publish format-standard has-post-thumbnail hentry category-food">
                                <div class="article-image">
                                    <div class="image-item">
                                        @php
                                            $image = url('public/storage/image/on-image-thum.png');
                                            if ($val->image != ''):
                                                $image = url('public/storage/image/post_image/thumbnail/big/' . $val->image);
                                            endif;
                                            $post_date = date('F d, Y', strtotime($val->created_at));
                                        @endphp
                                        <a href="{{ url($val->slug) }}">
                                            <img class="lazy" src="{{ $image }}"
                                                data-original="{{ $image }}" data-lazy="{{ $image }}"
                                                alt="post-image-{{ $val->slug }}" style="display: inline;">
                                        </a>
                                    </div>
                                </div>

                                <div class="article-content ">
                                    <div class="entry-header clearfix">
                                        <span class="post-cat"> <a href="http://localhost/chef_wp_blog/category/food/"
                                                title="">{{ getCategoryName($val->categories_id) }}</a>
                                        </span>
                                        <header class="entry-header-title">
                                            <h2 class="entry-title">
                                                <a href="{{ url($val->slug) }}" rel="bookmark">{{ $val->title }}</a>
                                            </h2>
                                        </header>
                                    </div>
                                    <div class="article-meta clearfix">
                                        <span class="byline"><span class="author vcard"><span
                                                    class="screen-reader-text">
                                                </span><span class="by">By</span><a class="url fn n"
                                                    href="{{ url($val->slug) }}">ChefOnline</a></span></span>
                                        <div class="posted-on post-date"><span class="author-on">on</span><span
                                                class="screen-reader-text"> </span><a href="{{ url($val->slug) }}"
                                                rel="bookmark"><time class="entry-date published"
                                                    datetime="2022-03-14T15:00:22+00:00">{{ $post_date }}</time></a>
                                        </div>
                                        <div class="main-view-like">
                                            <div class="total-view">
                                                <i class="fa fa-eye-slash"></i> {{ $val->views }}
                                            </div>
                                            <!--<span class="comment-text">
                                                <a href="{{ url($val->slug) }}" class="text-comment"><i
                                                        class="fa fa-comment-o" aria-hidden="true"></i> 0</a>
                                            </span>-->
                                        </div>

                                    </div>
                                    <div class="entry-content">
                                        {{ $val->title }}
                                    </div>
                                    <a class="readmore" href="{{ url($val->slug) }}">Continue reading</a>

                                </div>
                            </article><!-- #post-## -->
                        @empty
                        <p>No Post found!</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>

        <nav class="navigation pagination" role="navigation" aria-label="Posts">
            @if ($records->lastPage() > 1)
                <div class="row pagination-row">
                    <ul class="pager">
                        @if ($records->currentPage() != 1 && $records->lastPage() >= 5)
                            <li class="previous">
                                <a href="{{ $records->url($records->url(1)) }}">
                                    << </a>
                            </li>
                        @endif
                        @if ($records->currentPage() != 1)
                            <li class="previous">
                                <a href="{{ $records->url($records->currentPage() - 1) }}">
                                    < </a>
                            </li>
                        @endif

                        @for ($i = max($records->currentPage() - 2, 1); $i <= min(max($records->currentPage() - 2, 1) + 4, $records->lastPage()); $i++)
                            <li class="{{ $records->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $records->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($records->currentPage() != $records->lastPage())
                            <li>
                                <a href="{{ $records->url($records->currentPage() + 1) }}">
                                    >
                                </a>
                            </li>
                        @endif

                        @if ($records->currentPage() != $records->lastPage() && $records->lastPage() >= 5)
                            <li>
                                <a href="{{ $records->url($records->lastPage()) }}">
                                    >>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </nav>
    </div>
    <style>
        .pager .previous>a, .pager .previous>span {
            float: none;
        }
        li.active a {
            background: #EC1A3A;
            color: #fff;
        }
    </style>
@endsection
