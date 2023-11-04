<nav aria-label="Progress">
    <ol
        class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0"
        role="list"
    >
        @include('packages/installer::partials.step-1')
        @include('packages/installer::partials.step-2')
        @include('packages/installer::partials.step-3')
        @include('packages/installer::partials.step-4')
        @include('packages/installer::partials.step-5')
    </ol>
</nav>
