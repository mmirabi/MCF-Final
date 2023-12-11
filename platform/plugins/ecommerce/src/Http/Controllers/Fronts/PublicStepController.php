<?php

namespace Botble\Ecommerce\Http\Controllers\Fronts;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Facades\Cart;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Facades\OrderHelper;
use Botble\Ecommerce\Http\Requests\CartRequest;
use Botble\Ecommerce\Http\Requests\UpdateCartRequest;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Services\HandleApplyCouponService;
use Botble\Ecommerce\Services\HandleApplyPromotionsService;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Botble\Ecommerce\Http\Controllers\Fronts\PublicCartController;

class PublicStepController extends Controller
    {
        public function delivery()
            {
                if (! EcommerceHelper::isCartEnabled()) {
                    abort(404);
                }

                Theme::asset()
                    ->container('footer')
                    ->add('ecommerce-checkout-js', 'vendor/core/plugins/ecommerce/js/checkout.js', ['jquery']);

                $promotionDiscountAmount = 0;
                $couponDiscountAmount = 0;

                $products = collect();
                $crossSellProducts = collect();

                if (Cart::instance('cart')->count() > 0) {
                    

                    $crossSellProducts = get_cart_cross_sale_products(
                        $products->pluck('original_product.id')->all(),
                        (int)theme_option('number_of_cross_sale_product', 4)
                    ) ?: collect();
                }

                SeoHelper::setTitle(__('Delivery'));

                return Theme::scope(
                    'ecommerce.delivery',
                    compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'),
                    'plugins/ecommerce::themes.delivery'
                )->render();
            }

            // additional gift
            public function additionalgifts()
            {
                if (! EcommerceHelper::isCartEnabled()) {
                    abort(404);
                }

                Theme::asset()
                    ->container('footer')
                    ->add('ecommerce-checkout-js', 'vendor/core/plugins/ecommerce/js/checkout.js', ['jquery']);

                $promotionDiscountAmount = 0;
                $couponDiscountAmount = 0;

                $products = collect();
                $crossSellProducts = collect();

                if (Cart::instance('additionalgifts')->count() > 0) {
                    

                    $crossSellProducts = get_cart_cross_sale_products(
                        $products->pluck('original_product.id')->all(),
                        (int)theme_option('number_of_cross_sale_product', 4)
                    ) ?: collect();
                }

                SeoHelper::setTitle(__('Additional Gifts'));
                    return Theme::scope(
                    'ecommerce.additionalgifts',
                    compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'),
                    'plugins/ecommerce::themes.additionalgifts'
                )->render();
            }


        // message card
        public function messagecard() {


            {
                if (! EcommerceHelper::isCartEnabled()) {
                    abort(404);
                }

                Theme::asset()
                    ->container('footer')
                    ->add('ecommerce-checkout-js', 'vendor/core/plugins/ecommerce/js/checkout.js', ['jquery']);

                $promotionDiscountAmount = 0;
                $couponDiscountAmount = 0;

                $products = collect();
                $crossSellProducts = collect();

                if (Cart::instance('messagecard')->count() > 0) {
                    

                    $crossSellProducts = get_cart_cross_sale_products(
                        $products->pluck('original_product.id')->all(),
                        (int)theme_option('number_of_cross_sale_product', 4)
                    ) ?: collect();
                }

                SeoHelper::setTitle(__('Message Card'));

                return Theme::scope(
                    'ecommerce.messagecard',
                    compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'),
                    'plugins/ecommerce::themes.messagecard'
                )->render();
            }
        }


            // invoice
        public function invoice(){

            {
                if (! EcommerceHelper::isCartEnabled()) {
                    abort(404);
                }

                Theme::asset()
                    ->container('footer')
                    ->add('ecommerce-checkout-js', 'vendor/core/plugins/ecommerce/js/checkout.js', ['jquery']);

                $promotionDiscountAmount = 0;
                $couponDiscountAmount = 0;

                $products = collect();
                $crossSellProducts = collect();

                if (Cart::instance('invoice')->count() > 0) {
                    

                    $crossSellProducts = get_cart_cross_sale_products(
                        $products->pluck('original_product.id')->all(),
                        (int)theme_option('number_of_cross_sale_product', 4)
                    ) ?: collect();
                }

                SeoHelper::setTitle(__('Invoice'));
                return Theme::scope(
                    'ecommerce.invoice',
                    compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'),
                    'plugins/ecommerce::themes.invoice'
                )->render();
            }
        }

        // payment
        public function payment(){
            


            {
                if (! EcommerceHelper::isCartEnabled()) {
                    abort(404);
                }

                Theme::asset()
                    ->container('footer')
                    ->add('ecommerce-checkout-js', 'vendor/core/plugins/ecommerce/js/checkout.js', ['jquery']);

                $promotionDiscountAmount = 0;
                $couponDiscountAmount = 0;

                $products = collect();
                $crossSellProducts = collect();

                if (Cart::instance('payment')->count() > 0) {
                    

                    $crossSellProducts = get_cart_cross_sale_products(
                        $products->pluck('original_product.id')->all(),
                        (int)theme_option('number_of_cross_sale_product', 4)
                    ) ?: collect();
                }

                SeoHelper::setTitle(__('Payment'));
                    return Theme::scope(
                    'ecommerce.payment',
                    compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'),
                    'plugins/ecommerce::themes.payment'
                )->render();
            }
        }
    }