<?php

namespace Botble\Ecommerce\Services\MessageCards;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Events\ProductQuantityUpdatedEvent;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Option;
use Botble\Ecommerce\Models\OptionValue;
use Botble\Ecommerce\Models\Product;
use Botble\Media\Models\MediaFile;
use Botble\Media\Services\UploadsManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StoreProductService
{
    public function execute(Request $request, Product $product, bool $forceUpdateAll = false): Product
    {
        $data = $request->input();

        $product->fill($data);

        $product->save();

        $product->categories()->sync($request->input('categories', []));

        return $product;
    }
}
