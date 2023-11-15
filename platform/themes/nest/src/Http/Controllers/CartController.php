<?php

namespace Theme\Nest\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Http\Controllers\Fronts\PublicCartController;
use Botble\Ecommerce\Http\Requests\CartRequest;
use Botble\Ecommerce\Http\Requests\UpdateCartRequest;
use Botble\Theme\Facades\Theme;

class CartController extends PublicCartController
{
    public function store(CartRequest $request, BaseHttpResponse $response)
    {
        $response = parent::store($request, $response);

        $response->setAdditional([
            'html' => Theme::partial('cart-panel'),
        ]);

        return $response;
    }

    public function update(UpdateCartRequest $request, BaseHttpResponse $response)
    {
        $response = parent::update($request, $response);

        [$products, $promotionDiscountAmount, $couponDiscountAmount] = $this->getCartData();

        $crossSellProducts = collect();

        $response->setAdditional([
            'html' => Theme::partial('cart-panel'),
            'cart_content' => view(Theme::getThemeNamespace('views.ecommerce.cart'), compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'))->render(),
        ]);

        return $response;
    }

    public function destroy(string $id, BaseHttpResponse $response)
    {
        $response = parent::destroy($id, $response);

        [$products, $promotionDiscountAmount, $couponDiscountAmount] = $this->getCartData();

        $crossSellProducts = collect();

        $response->setAdditional([
            'html' => Theme::partial('cart-panel'),
            'cart_content' => view(Theme::getThemeNamespace('views.ecommerce.cart'), compact('promotionDiscountAmount', 'couponDiscountAmount', 'products', 'crossSellProducts'))->render(),
        ]);

        return $response;
    }
}
