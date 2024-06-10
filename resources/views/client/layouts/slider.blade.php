<section class="slider_section">
    <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @php
                    $directory = ROOT . 'public/images/slider';
                    $images = scandir($directory);
                    $i = 0;
                @endphp
                @foreach ($images as $image)
                    @if ($image !== '.' && $image !== '..')
                        @php
                            $active = $i === 0 ? 'active' : '';
                        @endphp
                        <div class="carousel-item {{ $active }}">
                            <img src="{{ 'images/slider/' . $image }}" class="d-block w-100 img-fluid" alt="Description of {{ $image }}">
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endif
                @endforeach
            </div>
            <div class="carousel_btn-box">
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <img src="{{ 'images/line.png' }}" alt=""/>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</section>