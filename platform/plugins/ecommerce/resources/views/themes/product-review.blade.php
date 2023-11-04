<div class="page-content-wraper">
    {!! Theme::breadcrumb()->render() !!}

    @include('plugins/ecommerce::themes.customers.product-reviews.icons')

    <section class="content-page product-reviews-page">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-12">
                <div class="my-5">
                    @include('plugins/ecommerce::themes.customers.product-reviews.form')
                </div>
                <div class="my-5">
                    <a
                        class="btn btn-secondary px-5"
                        href="{{ route('public.index') }}"
                    >{{ __('Go back home') }}</a>
                </div>
            </div>
        </div>
    </section>
</div>
