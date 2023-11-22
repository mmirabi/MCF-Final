<div class="footer-link-widget col wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
    <h4 class="widget-title">{{ $config['name'] }}</h4>
    <ul class="footer-list mb-sm-5 mb-md-0">
        {!! Menu::generateMenu([
            'slug' => $config['menu_id'],
            'options' => ['class' => 'footer-list wow fadeIn animated mb-sm-5 mb-md-0'],
        ]) !!}
    </ul>
</div>
