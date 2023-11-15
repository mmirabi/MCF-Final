<?php

namespace Botble\Base\Supports;

use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class Editor
{
    public function registerAssets(): self
    {
        Assets::addScriptsDirectly(config('core.base.general.editor.' . BaseHelper::getRichEditor() . '.js'))
            ->addScriptsDirectly('vendor/core/core/base/js/editor.js');

        $locale = App::getLocale();

        if (BaseHelper::getRichEditor() == 'ckeditor' && $locale != 'en') {
            Assets::addScriptsDirectly(
                sprintf('https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/translations/%s.js', $locale)
            );
        }

        return $this;
    }

    public function render(string $name, $value = null, bool $withShortcode = false, array $attributes = []): string
    {
        $attributes['class'] = Arr::get($attributes, 'class', '') . ' editor-' . BaseHelper::getRichEditor();

        $attributes['id'] = Arr::has($attributes, 'id') ? $attributes['id'] : $name;
        $attributes['with-short-code'] = $withShortcode;
        $attributes['rows'] = Arr::get($attributes, 'rows', 4);

        return view('core/base::forms.partials.editor', compact('name', 'value', 'attributes'))
            ->render();
    }
}
