<a
    class="btn btn-success my-2"
    href="{{ route('ecommerce.invoice.generate-invoice', ['invoice' => $invoice, 'type' => 'print']) }}"
    target="_blank"
>
    {{ trans('plugins/ecommerce::invoice.print') }}
</a>

<a
    class="btn btn-danger my-2"
    href="{{ route('ecommerce.invoice.generate-invoice', ['invoice' => $invoice, 'type' => 'download']) }}"
    target="_blank"
>
    {{ trans('plugins/ecommerce::invoice.download') }}
</a>
