<li>{{ $tax->company_name }}</li>

<li>{{ $tax->company_tax_code }}</li>

<li>
    <a href="mailto:{{ $tax->company_email }}">
        <span><i class="fa fa-envelope cursor-pointer mr5"></i></span>
        <span dir="ltr">{{ $tax->company_email }}</span>
    </a>
</li>

<li>
    <div>{{ $tax->company_address }}</div>

    <div>
        <a
            class="hover-underline"
            href="https://maps.google.com/?q={{ $tax->company_address }}"
            target="_blank"
        >{{ trans('plugins/ecommerce::order.see_on_maps') }}</a>
    </div>
</li>
