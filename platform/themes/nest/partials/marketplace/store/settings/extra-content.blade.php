<div class="tab-pane" id="tab_extra_data">
    @if (theme_option('vendor_page_detail_layout') == 'list')
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cover_image">{{ __('Cover Image') }}</label>
                    @if(is_in_admin(true))
                        {!! Form::mediaImage('cover_image', old('cover_image', $model->getMetaData('cover_image', true))) !!}
                    @else
                        {!! Form::customImage('cover_image', old('cover_image', $model->getMetaData('cover_image', true))) !!}
                    @endif
                    {!! Form::error('cover_image', $errors) !!}
                </div>
            </div>
        </div>
    @endif
    @if ($storeSocialLinks = get_store_social_links())
        <div class="row">
            <div class="col-12">
                <h5 class="fw-bold">{{ __('Social networks') }}</h5>
            </div>
            @foreach ($storeSocialLinks as $key => $item)
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="social_links_{{ $key }}">{{ $item['title'] }}</label>
                        <div class="input-group mb-3">
                            @if (Arr::get($item, 'domain'))
                                <span class="input-group-text px-2">{{ Arr::get($item, 'domain') }}</span>
                            @endif
                            {!! Form::text('social_links[' . $key . ']', Arr::get($model->getMetaData('social_links', true) ?: [], $key, ''), [
                                'class'       => 'form-control',
                                'placeholder' => Arr::get($item, 'placeholder', '{username}'),
                                'id'          => 'social_links_' . $key,
                            ]) !!}
                            <span class="input-group-text">
                                <img src="{{ Theme::asset()->url(Arr::get($item, 'logo')) }}" alt="{{ Arr::get($item, 'title') }}" />
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
