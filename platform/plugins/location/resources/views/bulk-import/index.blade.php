@if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
    @php
        $supportedLocales = Language::getSupportedLocales();
    @endphp
@endif

@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    @push('header')
        <style>
            .dropzone {
                border: 2px dashed #707070;
                border-radius: 5px;
                cursor: pointer;
                min-height: 0;
                background: #f2f2f2;
            }

            .dropzone .dz-message {
                margin: 0.6rem;
            }

            .dropzone h4 {
                margin-bottom: 0.4rem;
            }

            .dropzone.dz-clickable a,
            .dropzone.dz-clickable i {
                cursor: pointer;
            }

            .blockUI img {
                display: none;
            }
        </style>
    @endpush

    <div
        class="row location-import"
        data-upload-url="{{ route('location.upload.process') }}"
        data-validate-url="{{ route('location.upload.validate') }}"
        data-import-url="{{ route('location.import') }}"
    >
        <div class="col-md-6">
            {!! Form::open(['class' => 'form-import-data', 'files' => 'true']) !!}
            <div class="widget meta-boxes mt-0">
                <div class="widget-title pl-2">
                    <h4>{{ trans('plugins/location::bulk-import.menu') }}</h4>
                </div>
                <div class="widget-body">
                    <div class="upload-form">
                        <div class="form-group mb-3 @if ($errors->has('file')) has-error @endif">
                            <label
                                class="form-label required"
                                for="input-group-file"
                            >
                                {{ trans('plugins/location::bulk-import.choose_file') }}
                            </label>
                            <div
                                class="location-dropzone dropzone"
                                data-mimetypes="{{ $mimetypes }}"
                            >
                                <div class="dz-message">
                                    {{ trans('plugins/location::bulk-import.upload_file_placeholder') }}<br>
                                </div>
                            </div>
                            <label
                                class="d-block mt-1 help-block"
                                for="input-group-file"
                            >
                                {{ trans('plugins/location::bulk-import.choose_file_with_mime', ['types' => implode(', ', config('plugins.location.general.bulk-import.mimes', []))]) }}
                            </label>

                            {!! Form::error('file', $errors) !!}
                            <div class="mt-3 text-center p-2 border bg-light">
                                <a
                                    class="download-template"
                                    data-url="{{ route('location.bulk-import.download-template') }}"
                                    data-extension="csv"
                                    data-filename="template_locations_import.csv"
                                    data-downloading="<i class='fas fa-spinner fa-spin'></i> {{ trans('plugins/location::bulk-import.downloading') }}"
                                    href="#"
                                >
                                    <i class="fas fa-file-csv"></i>
                                    {{ trans('plugins/location::bulk-import.download-csv-file') }}
                                </a> &nbsp; | &nbsp;
                                <a
                                    class="download-template"
                                    data-url="{{ route('location.bulk-import.download-template') }}"
                                    data-extension="xlsx"
                                    data-filename="template_locations_import.xlsx"
                                    data-downloading="<i class='fas fa-spinner fa-spin'></i> {{ trans('plugins/location::bulk-import.downloading') }}"
                                    href="#"
                                >
                                    <i class="fas fa-file-excel"></i>
                                    {{ trans('plugins/location::bulk-import.download-excel-file') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 d-grid">
                        <button
                            class="btn btn-info"
                            id="input-group-addon"
                            data-uploading-text="{{ __('plugins/location::bulk-import.uploading') }}"
                            data-validating-text="{{ __('plugins/location::bulk-import.validating') }}"
                            data-importing-text="{{ __('plugins/location::bulk-import.importing') }}"
                            type="submit"
                        >
                            {{ trans('plugins/location::bulk-import.start_import') }}
                        </button>
                    </div>

                    <p
                        class="text-center status-text text-success fw-semibold"
                        style="display: none"
                    ></p>
                </div>
            </div>
            {!! Form::close() !!}
            <div
                class="main-form-message mb-3"
                style="display: none"
            >
                <div
                    class="alert alert-success success-message"
                    style="display: none"
                ></div>
                <div
                    class="show-errors"
                    style="display: none"
                >
                    <h3 class="text-warning text-center">{{ trans('plugins/location::bulk-import.failures') }}</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#_Row</th>
                                <th scope="col">Errors</th>
                            </tr>
                        </thead>
                        <tbody id="imported-listing"></tbody>
                    </table>
                </div>
            </div>
            <div class="widget meta-boxes">
                <div class="widget-title px-3">
                    <h4 class="text-info">{{ trans('plugins/location::bulk-import.template') }}</h4>
                </div>
                <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table text-start table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Abbreviation</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Import Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Order</th>
                                    @if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
                                        @foreach ($supportedLocales as $localeCode => $properties)
                                            @continue($localeCode === Language::getCurrentLocale())

                                            <th scope="col">Name {{ Str::upper($properties['lang_code']) }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Texas</td>
                                    <td></td>
                                    <td>TX</td>
                                    <td></td>
                                    <td>United States</td>
                                    <td>state</td>
                                    <td>published</td>
                                    <td>0</td>
                                    @if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
                                        @foreach ($supportedLocales as $localeCode => $properties)
                                            @continue($localeCode === Language::getCurrentLocale())

                                            <td>Texas {{ Str::upper($properties['lang_code']) }}</td>
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    <td>Washington</td>
                                    <td></td>
                                    <td>WA</td>
                                    <td></td>
                                    <td>United States</td>
                                    <td>state</td>
                                    <td>published</td>
                                    <td>0</td>
                                    @if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
                                        @foreach ($supportedLocales as $localeCode => $properties)
                                            @continue($localeCode === Language::getCurrentLocale())

                                            <td></td>
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    <td>Houston</td>
                                    <td>houston</td>
                                    <td></td>
                                    <td>Texas</td>
                                    <td>United States</td>
                                    <td>city</td>
                                    <td>published</td>
                                    <td>0</td>
                                    @if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
                                        @foreach ($supportedLocales as $localeCode => $properties)
                                            @if ($localeCode != Language::getCurrentLocale())
                                                <td></td>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    <td>San Antonio</td>
                                    <td>san-antonio</td>
                                    <td></td>
                                    <td>Texas</td>
                                    <td>United States</td>
                                    <td>city</td>
                                    <td>published</td>
                                    <td>0</td>
                                    @if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
                                        @foreach ($supportedLocales as $localeCode => $properties)
                                            @continue($localeCode === Language::getCurrentLocale())

                                            <td></td>
                                        @endforeach
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="widget meta-boxes">
                <div class="widget-title px-3">
                    <h4 class="text-info">{{ trans('plugins/location::bulk-import.rules') }}</h4>
                </div>
                <div class="widget-body">
                    <table class="table text-start table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Column</th>
                                <th scope="col">Rules</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td>(required)</td>
                            </tr>
                            <tr>
                                <th scope="row">Slug</th>
                                <td>(nullable)</td>
                            </tr>
                            <tr>
                                <th scope="row">Abbreviation</th>
                                <td>(nullable|max:2)</td>
                            </tr>
                            <tr>
                                <th scope="row">State</th>
                                <td>(nullable|required_if:type,city)</td>
                            </tr>
                            <tr>
                                <th scope="row">Country</th>
                                <td>(nullable|required_if:type,state,city)</td>
                            </tr>
                            <tr>
                                <th scope="row">Import Type</th>
                                <td>(nullable|enum:country,state,city|default:state)</td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>(required|enum:{{ implode(',', Botble\Base\Enums\BaseStatusEnum::values()) }}|default:{{ Botble\Base\Enums\BaseStatusEnum::PUBLISHED }})
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Order</th>
                                <td>(nullable|integer|min:0|max:127|default:0)</td>
                            </tr>
                            <tr>
                                <th scope="row">Nationality</th>
                                <td>(required_if:import_type,country|max:120)</td>
                            </tr>
                            @if (defined('LANGUAGE_MODULE_SCREEN_NAME'))
                                @foreach ($supportedLocales as $localeCode => $properties)
                                    @continue($localeCode === Language::getCurrentLocale())

                                    <tr>
                                        <th scope="row">Name {{ $properties['lang_code'] }}
                                            <i
                                                class="fas fa-info-circle"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="{{ trans('plugins/location::bulk-import.available_enable_multi_language') }}"
                                            ></i>
                                        </th>
                                        <td>(nullable|default:{Name})</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="widget meta-boxes">
                <div class="widget-title px-3">
                    <h4 class="text-info">{{ trans('plugins/location::bulk-import.import_available_data') }}</h4>
                </div>
                <div class="widget-body">
                    <div
                        id="available-remote-locations"
                        data-url="{{ route('location.bulk-import.available-remote-locations') }}"
                    >
                        @include('core/base::elements.loading')
                    </div>
                </div>
            </div>
        </div>

        <script type="text/x-custom-template" id="failure-template">
            <tr>
                <td scope="row">__row__</td>
                <td>__errors__</td>
            </tr>
        </script>
        <script type="text/x-custom-template" id="preview-template">
            <div class="position-relative d-flex gap-3">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 2rem; width: 2rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="fs-6"><span data-dz-name></span></h4>
                    <div class="small">
                        <span class="text-muted" data-dz-size></span>
                        <a href="#" class="ms-1 text-danger cursor-pointer" data-dz-remove>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <div class="text-danger small" data-dz-errormessage></div>
                </div>
            </div>
        </script>
    </div>

    @push('footer')
        <x-core::modal
            class="modal-confirm-import"
            type="info"
            :title="trans('plugins/location::bulk-import.import_available_data_confirmation')"
            button-class="button-confirm-import"
            :button-label="trans('plugins/location::bulk-import.import')"
        >
            <div>{{ trans('plugins/location::bulk-import.import_available_data_confirmation_content') }}</div>
        </x-core::modal>
    @endpush
@endsection
