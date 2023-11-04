@extends(EcommerceHelper::viewPath('customers.master'))

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="customer-page-title">{{ __('Account information') }}</h2>
        </div>

        <div class="panel-body">
            <div class="well customer-help">
                <i class="fa fa-user"></i> {{ __('Name') }}: {{ $customer->name }}
            </div>

            @if ($customer->dob)
                <div class="well customer-help">
                    <i class="fa fa-calendar"></i> {{ __('Date of birth') }}: {{ $customer->dob }}
                </div>
            @endif

            <div class="well customer-help">
                <i class="fa fa-envelope"></i> {{ __('Email') }}: {{ $customer->email }}
            </div>

            @if ($customer->phone)
                <div class="well customer-help">
                    <i class="fa fa-phone"></i> {{ __('Phone') }}: {{ $customer->phone }}
                </div>
            @endif
        </div>
    </div>
@endsection
