@extends(EcommerceHelper::viewPath('customers.master'))

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="customer-page-title">{{ __('Change avatar') }}</h2>
        </div>
        <div class="panel-body">

            {!! Form::open(['route' => 'customer.change-avatar', 'files' => true]) !!}

            <label class="btn-bs-file btn btn-lg btn-primary">
                {{ __('Select file') }}
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                />
            </label>

            {!! Form::error('avatar', $errors) !!}

            <div class="form-group col s12 text-center">
                <button
                    class="btn btn-primary btn-sm"
                    id="change-avatar-btn"
                    type="submit"
                >{{ __('Update') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
