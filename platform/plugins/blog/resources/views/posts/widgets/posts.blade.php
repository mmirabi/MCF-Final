@if ($posts->isNotEmpty())
    <div class="scroller">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('core/base::tables.name') }}</th>
                    <th>{{ trans('core/base::tables.created_at') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            @if ($post->slug)
                                <a
                                    href="{{ $post->url }}"
                                    target="_blank"
                                >{{ Str::limit($post->name, 80) }}</a>
                            @else
                                <strong>{{ Str::limit($post->name, 80) }}</strong>
                            @endif
                        </td>
                        <td>{{ BaseHelper::formatDate($post->created_at) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    @include('core/dashboard::partials.no-data', [
        'message' => trans('plugins/blog::posts.no_new_post_now'),
    ])
@endif
