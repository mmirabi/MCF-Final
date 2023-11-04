@extends('packages/installer::master')

@section('template_title', trans('packages/installer::installer.environment.wizard.templateTitle'))

@section('container')
    <form
        method="post"
        action="{{ route('installers.environment.save') }}"
    >
        @csrf
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="app_name"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.app_name_label') }}
                </label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input
                        id="app_name"
                        name="app_name"
                        type="text"
                        value="{{ old('app_name', config('app.name')) }}"
                        aria-invalid="true"
                        aria-describedby="email-error"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2',
                            'ring-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 ' => $errors->has(
                                'app_name'),
                            'ring-gray-300' => !$errors->has('app_name'),
                        ])
                    >
                    @if ($errors->has('app_name'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                </div>
                @error('app_name')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="app_url"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.app_url_label') }}
                </label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input
                        id="app_url"
                        name="app_url"
                        type="text"
                        value="{{ old('app_url', url('')) }}"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10m:text-sm sm:leading-6 ring-1 ring-inset focus:ring-2',
                            'ring-red-300 focus:ring-red-500' => $errors->has('app_url'),
                            'ring-gray-300' => !$errors->has('app_url'),
                        ])
                    >
                    @if ($errors->has('app_url'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                </div>
                @error('app_url')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="database_connection"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.db_connection_label') }}
                </label>
                <div class="relative mt-2 rounded-md">
                    <select
                        class="mt-2 w-full rounded-md border-0 py-2 ps-3 pe-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        id="database_connection"
                        name="database_connection"
                    >
                        <option value="mysql"@selected(old('database_connection', DB::getDefaultConnection()) === 'mysql')>
                            {{ trans('packages/installer::installer.environment.wizard.form.db_connection_label_mysql') }}
                        </option>
                        <option value="sqlite"@selected(old('database_connection', DB::getDefaultConnection()) === 'sqlite')>
                            {{ trans('packages/installer::installer.environment.wizard.form.db_connection_label_sqlite') }}
                        </option>
                        <option value="pgsql"@selected(old('database_connection', DB::getDefaultConnection()) === 'pgsql')>
                            {{ trans('packages/installer::installer.environment.wizard.form.db_connection_label_pgsql') }}
                        </option>
                    </select>
                </div>
                @error('database_connection')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="database_hostname"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.db_host_label') }}
                </label>
                <div class="relative mt-2 rounded-md">
                    <input
                        id="database_hostname"
                        name="database_hostname"
                        type="text"
                        value="{{ old('database_hostname', DB::connection('mysql')->getConfig()['host']) }}"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10 sm:text-sm sm:leading-6 ring-1 ring-inset focus:ring-2',
                            ' ring-red-300 focus:ring-red-500' => $errors->has('database_hostname'),
                            'ring-gray-300' => !$errors->has('database_hostname'),
                        ])
                        placeholder="{{ trans('packages/installer::installer.environment.wizard.form.db_host_placeholder') }}"
                    >
                    @if ($errors->has('database_hostname'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                    <span class="inline-flex items-center ps-1 mt-2 text-xs text-blue-800 font-medium">
                        {{ trans('packages/installer::installer.environment.wizard.form.db_host_helper') }}
                    </span>
                </div>
                @error('database_hostname')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="database_port"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.db_port_label') }}
                </label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input
                        id="database_port"
                        name="database_port"
                        type="text"
                        value="{{ old('database_port', DB::connection('mysql')->getConfig()['port']) }}"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2',
                            'ring-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 ' => $errors->has(
                                'database_port'),
                            'ring-gray-300' => !$errors->has('database_port'),
                        ])
                        placeholder="{{ trans('packages/installer::installer.environment.wizard.form.db_port_placeholder') }}"
                    >
                    @if ($errors->has('database_port'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                </div>
                @error('database_port')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="database_name"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.db_name_label') }}
                </label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input
                        id="database_name"
                        name="database_name"
                        type="text"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2',
                            'ring-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 ' => $errors->has(
                                'database_name'),
                            'ring-gray-300' => !$errors->has('database_name'),
                        ])value="{{ old('database_name') }}"
                        placeholder="{{ trans('packages/installer::installer.environment.wizard.form.db_name_placeholder') }}"
                    >
                    @if ($errors->has('database_name'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                </div>
                @error('database_name')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="database_username"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.db_username_label') }}
                </label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input
                        id="database_username"
                        name="database_username"
                        type="text"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2',
                            'ring-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 ' => $errors->has(
                                'database_username'),
                            'ring-gray-300' => !$errors->has('database_username'),
                        ])value="{{ old('database_username') }}"
                        placeholder="{{ trans('packages/installer::installer.environment.wizard.form.db_username_placeholder') }}"
                    >
                    @if ($errors->has('database_username'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                </div>
                @error('database_username')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label
                    class="text-sm font-medium leading-6 text-gray-900"
                    for="database_password"
                >
                    {{ trans('packages/installer::installer.environment.wizard.form.db_password_label') }}
                </label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input
                        id="database_password"
                        name="database_password"
                        type="text"
                        @class([
                            'w-full rounded-md border-0 py-2 px-3 pe-10 ring-1 ring-inset sm:text-sm sm:leading-6 focus:ring-2',
                            'ring-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 ' => $errors->has(
                                'database_password'),
                            'ring-gray-300' => !$errors->has('database_password'),
                        ])value="{{ old('database_password') }}"
                        placeholder="{{ trans('packages/installer::installer.environment.wizard.form.db_password_placeholder') }}"
                    >
                    @if ($errors->has('database_password'))
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pe-3">
                            <svg
                                class="h-5 w-5 text-red-500"
                                aria-hidden="true"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    @endif
                </div>
                @error('database_password')
                    <p
                        class="mt-2 text-sm text-red-600"
                        id="email-error"
                    >{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="text-center mt-10">
            <button
                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl hover:text-white hover:shadow-2xl focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                type="submit"
            >
                {{ trans('packages/installer::installer.environment.wizard.form.buttons.install') }}
                <i
                    class="fa fa-angle-right fa-fw"
                    aria-hidden="true"
                ></i>
            </button>
        </div>
    </form>
@endsection
