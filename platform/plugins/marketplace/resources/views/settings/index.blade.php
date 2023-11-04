@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    {!! Form::open([
        'route' => 'marketplace.settings',
        'class' => 'main-setting-form',
        'id' => 'marketplace-settings-form',
    ]) !!}
    <div class="max-width-1200">
        <x-core-setting::section
            :title="trans('plugins/marketplace::marketplace.settings.title')"
            :description="trans('plugins/marketplace::marketplace.settings.description')"
        >
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="{{ MarketplaceHelper::getSettingKey('fee_per_order') }}"
                >{{ trans('plugins/marketplace::marketplace.settings.default_commission_fee') }}</label>
                <input
                    class="next-input"
                    id="{{ MarketplaceHelper::getSettingKey('fee_per_order') }}"
                    name="{{ MarketplaceHelper::getSettingKey('fee_per_order') }}"
                    type="number"
                    value="{{ MarketplaceHelper::getSetting('fee_per_order', 0) }}"
                    min="0"
                    max="100"
                >
            </div>

            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="enable_commission_fee_for_each_category"
                >{{ trans('plugins/marketplace::marketplace.settings.enable_commission_fee_for_each_category') }}
                </label>
                <label class="me-2">
                    <input
                        class="setting-selection-option"
                        name="{{ MarketplaceHelper::getSettingKey('enable_commission_fee_for_each_category') }}"
                        data-target="#category-commission-fee-settings"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::isCommissionCategoryFeeBasedEnabled()) checked @endif
                    >
                    {{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        class="setting-selection-option"
                        name="{{ MarketplaceHelper::getSettingKey('enable_commission_fee_for_each_category') }}"
                        data-target="#category-commission-fee-settings"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::isCommissionCategoryFeeBasedEnabled()) checked @endif
                    >
                    {{ trans('core/setting::setting.general.no') }}
                </label>
            </div>

            <div
                class="mb-4 border rounded-top rounded-bottom p-3 bg-light @if (!MarketplaceHelper::isCommissionCategoryFeeBasedEnabled()) d-none @endif"
                id="category-commission-fee-settings"
            >
                <div class="form-group mb-3 commission-setting-item-wrapper">
                    @if (!empty($commissionEachCategory))
                        @foreach ($commissionEachCategory as $fee => $commission)
                            <div
                                class="row commission-setting-item mb-4"
                                id="commission-setting-item-{{ $loop->index }}"
                            >
                                <div class="col-3">
                                    <label
                                        class="text-title-field"
                                        for="commission_fee_for_each_category"
                                    >{{ trans('plugins/marketplace::marketplace.settings.commission_fee') }}</label>
                                    <input
                                        class="commission_fee form-control"
                                        name="commission_by_category[{{ $loop->index }}][commission_fee]"
                                        type="number"
                                        value="{{ $fee }}"
                                        min="1"
                                        max="100"
                                    />
                                </div>
                                <div class="col-9">
                                    <label
                                        class="text-title-field"
                                        for="commission_fee_for_each_category"
                                    >{{ trans('plugins/marketplace::marketplace.settings.categories') }}</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <textarea
                                                class="next-input tagify-commission-setting categories"
                                                name="commission_by_category[{{ $loop->index }}][categories]"
                                                rows="3"
                                                placeholder="{{ trans('plugins/marketplace::marketplace.settings.select_categories') }}"
                                            >{!! json_encode($commission['categories'], true) !!}</textarea>
                                        </div>
                                        <div class="col-2">
                                            @if ($loop->index > 0)
                                                <button
                                                    class="btn btn-danger remove-commission-setting"
                                                    data-index="{{ $loop->index }}"
                                                    type="button"
                                                ><i class="fa fa-trash"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="row commission-setting-item mb-4"
                            id="commission-setting-item-0"
                        >
                            <div class="col-3">
                                <label
                                    class="text-title-field"
                                    for="commission_fee_for_each_category"
                                >{{ trans('plugins/marketplace::marketplace.settings.commission_fee') }}</label>
                                <input
                                    class="form-control"
                                    name="commission_by_category[0][commission_fee]"
                                    type="number"
                                    min="1"
                                    max="100"
                                />
                            </div>
                            <div class="col-9">
                                <label
                                    class="text-title-field"
                                    for="commission_fee_for_each_category"
                                >{{ trans('plugins/marketplace::marketplace.settings.categories') }}</label>
                                <div class="row">
                                    <div class="col-10">
                                        <textarea
                                            class="next-input tagify-commission-setting"
                                            name="commission_by_category[0][categories]"
                                            rows="3"
                                            placeholder="{{ trans('plugins/marketplace::marketplace.settings.select_categories') }}"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <button
                        class="btn btn-primary"
                        id="add-new-commission-setting-category"
                        type="button"
                    >{{ trans('plugins/marketplace::marketplace.settings.add_new') }}</button>
                </div>
            </div>

            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="{{ MarketplaceHelper::getSettingKey('fee_withdrawal') }}"
                >{{ trans('plugins/marketplace::marketplace.settings.fee_withdrawal') }}</label>
                <input
                    class="next-input"
                    id="{{ MarketplaceHelper::getSettingKey('fee_withdrawal') }}"
                    name="{{ MarketplaceHelper::getSettingKey('fee_withdrawal') }}"
                    type="number"
                    value="{{ MarketplaceHelper::getSetting('fee_withdrawal', 0) }}"
                >
            </div>
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="check_valid_signature"
                >{{ trans('plugins/marketplace::marketplace.settings.check_valid_signature') }}
                </label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('check_valid_signature') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::getSetting('check_valid_signature', 1)) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('check_valid_signature') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::getSetting('check_valid_signature', 1)) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="verify_vendor"
                >{{ trans('plugins/marketplace::marketplace.settings.verify_vendor') }}
                </label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('verify_vendor') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::getSetting('verify_vendor', 1)) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('verify_vendor') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::getSetting('verify_vendor', 1)) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="enable_product_approval"
                >{{ trans('plugins/marketplace::marketplace.settings.enable_product_approval') }}
                </label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('enable_product_approval') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::getSetting('enable_product_approval', 1)) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('enable_product_approval') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::getSetting('enable_product_approval', 1)) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>

            <x-core-setting::text-input
                :name="MarketplaceHelper::getSettingKey('max_filesize_upload_by_vendor')"
                type="number"
                :label="trans('plugins/marketplace::marketplace.settings.max_upload_filesize')"
                :value="MarketplaceHelper::maxFilesizeUploadByVendor()"
                step="1"
                :placeholder="trans('plugins/marketplace::marketplace.settings.max_upload_filesize_placeholder', [
                    'size' => ($maxSize = MarketplaceHelper::maxFilesizeUploadByVendor()),
                ])"
            />

            <x-core-setting::text-input
                :name="MarketplaceHelper::getSettingKey('max_product_images_upload_by_vendor')"
                type="number"
                :label="trans('plugins/marketplace::marketplace.settings.max_product_images_upload_by_vendor')"
                :value="MarketplaceHelper::maxProductImagesUploadByVendor()"
                step="1"
            />
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="hide_store_phone_number"
                >{{ trans('plugins/marketplace::marketplace.settings.hide_store_phone_number') }}
                </label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('hide_store_phone_number') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::hideStorePhoneNumber()) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('hide_store_phone_number') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::hideStorePhoneNumber()) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="hide_store_email"
                >{{ trans('plugins/marketplace::marketplace.settings.hide_store_email') }}
                </label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('hide_store_email') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::hideStoreEmail()) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('hide_store_email') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::hideStoreEmail()) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="hide_store_email"
                >{{ trans('plugins/marketplace::marketplace.settings.hide_store_social_links') }}
                </label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('hide_store_social_links') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::hideStoreSocialLinks()) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('hide_store_social_links') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::hideStoreSocialLinks()) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>
            <div class="form-group mb-3">
                <label
                    class="text-title-field"
                    for="allow_vendor_manage_shipping"
                >{{ trans('plugins/marketplace::marketplace.settings.allow_vendor_manage_shipping') }}</label>
                <label class="me-2">
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('allow_vendor_manage_shipping') }}"
                        type="radio"
                        value="1"
                        @if (MarketplaceHelper::allowVendorManageShipping()) checked @endif
                    >{{ trans('core/setting::setting.general.yes') }}
                </label>
                <label>
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('allow_vendor_manage_shipping') }}"
                        type="radio"
                        value="0"
                        @if (!MarketplaceHelper::allowVendorManageShipping()) checked @endif
                    >{{ trans('core/setting::setting.general.no') }}
                </label>
            </div>

            <div class="form-group mb-3">
                <label
                    class="text-title-field required"
                    for="payout_methods"
                >{{ trans('plugins/marketplace::marketplace.settings.payout_methods') }}</label>
                @foreach (\Botble\Marketplace\Enums\PayoutPaymentMethodsEnum::labels() as $key => $item)
                    <input
                        name="{{ MarketplaceHelper::getSettingKey('payout_methods') }}[{{ $key }}]"
                        type="hidden"
                        value="0"
                        checked
                    >
                    <label
                        class="me-2"
                        for="payout_method_{{ $key }}"
                    >
                        <input
                            id="payout_method_{{ $key }}"
                            name="{{ MarketplaceHelper::getSettingKey('payout_methods') }}[{{ $key }}]"
                            type="checkbox"
                            value="1"
                            @checked(Arr::get(old(MarketplaceHelper::getSettingKey('payout_methods'), MarketplaceHelper::getSetting('payout_methods')),
                                    $key,
                                    1))
                        >{{ $item }}
                    </label>
                @endforeach
            </div>
        </x-core-setting::section>

        <div
            class="flexbox-annotated-section"
            style="border: none"
        >
            <div class="flexbox-annotated-section-annotation">
                &nbsp;
            </div>
            <div class="flexbox-annotated-section-content">
                <button
                    class="btn btn-info"
                    type="submit"
                >{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('footer')
    <script type="text/x-custom-template" id="commission-setting-item-template">
        <div class="row commission-setting-item mb-4" id="commission-setting-item-__index__">
            <div class="col-3">
                <label class="text-title-field" for="commission_fee_for_each_category">{{ trans('plugins/marketplace::marketplace.settings.commission_fee') }}</label>
                <input type="number" min="1" max="100" name="commission_by_category[__index__][commission_fee]" class="form-control" />
            </div>
            <div class="col-9">
                <label class="text-title-field" for="commission_fee_for_each_category">{{ trans('plugins/marketplace::marketplace.settings.categories') }}</label>
                <div class="row">
                    <div class="col-10">
                        <textarea class="next-input tagify-commission-setting" name="commission_by_category[__index__][categories]" rows="3" placeholder="{{ trans('plugins/marketplace::marketplace.settings.select_categories') }}"></textarea>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-danger remove-commission-setting" data-index="__index__" type="button"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script>
        window.tagifyWhitelist = {!! Js::from($productCategories) !!}
    </script>
    {!! $jsValidation->selector('#marketplace-settings-form') !!}
@endpush
