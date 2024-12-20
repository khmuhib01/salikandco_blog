@extends('layouts.frontend.layout')
@section('content')
<div class="main-content content-cat-8 col-sx-12 col-sm-12 col-md-8 col-lg-8">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title">Oops! That page can’t be found.</h1>
        </header><!-- .page-header -->

        <div class="page-content">
            <p>It looks like nothing was found at this location. Maybe try a search?</p>
            <form method="get" class="searchform" action="#">

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search ... " value="" name="s">
                    <span class="input-group-btn">
                        <button class="btn btn-primary"><i class="ti-search"></i></button>
                    </span>
                </div>

            </form>
        </div><!-- .page-content -->
    </section>
</div>
@endsection
