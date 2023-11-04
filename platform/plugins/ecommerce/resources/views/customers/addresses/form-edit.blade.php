<form
    action="{{ route('customers.addresses.edit.update', $address->id) }}"
    method="POST"
>
    <input
        name="customer_id"
        type="hidden"
        value="{{ $address->customer_id }}"
    >

    @include('plugins/ecommerce::customers.addresses.form', ['address' => $address])
</form>
