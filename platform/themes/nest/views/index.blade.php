@php Theme::layout('homepage'); @endphp

<div class="container">
    <div style="margin: 40px 0;">
        <h4 style="color: #f00; margin-bottom: 15px;">You need to setup your homepage first!</h4>

        <p><strong>1. Go to Admin -> Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Admin -> Pages and create a page:</strong></p>

        <div style="margin: 20px 0;">
            <div>- Content:</div>
            <div style="border: 1px solid rgba(0,0,0,.1); padding: 10px; margin-top: 10px;direction: ltr;">
                <div>[simple-slider key="home-slider-1" show_newsletter_form="yes"][/simple-slider]</div>
                <div>[featured-product-categories title="Featured Categories"][/featured-product-categories]</div>
                <div>[theme-ads ads_1="IZ6WU8KUALYD" ads_2="ILSFJVYFGCPZ" ads_3="ILSDKVYFGXPH"][/theme-ads]</div>
                <div>[popular-products title="Popular Products"][/popular-products]</div>
                <div>[best-flash-sale title="Daily Best Sells" flash_sale_id="6" ads="IZ6WU8KUALYG"][/best-flash-sale]</div>
                <div>[flash-sale flash_sale_1="2" flash_sale_2="3" flash_sale_3="4" flash_sale_4="5" title="Deals Of The Day" flash_sale_popup_id="1"][/flash-sale]</div>
                <div>[top-products-group][/top-products-group]</div>
            </div>
            <br>
            <div>- Template: <strong>Homepage</strong>.</div>
        </div>

        <p><strong>3. Then go to Admin -> Appearance -> Theme options -> Page to set your homepage.</strong></p>
    </div>
</div>
