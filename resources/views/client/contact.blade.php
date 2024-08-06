@extends('client.layouts.master', ['title' => 'About Us'])

@section('body')
    <div class="hero-area">
        @include('client.layouts.header2')
    </div>
    <!-- contact section -->

    <section class="contact_section layout_padding">
        <div class="container px-0">
            <div class="heading_container heading_center">
                <h2>
                    Contact Us
                </h2>
            </div>
        </div>
        <div class="container container-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 px-0">
                    <div class="map_container">
                        <div class="map-responsive">
                            <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France"
                                    width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                @if(auth()->check())
                    <div class="col-md-6 col-lg-5 px-0">
                        <form action="/contact-us" method="POST">
                            <div class="mb-5">
                                <span>Send message to us :)</span>
                            </div>
                            <div class="mt-5">
                                <input name="comment" type="text" class="message-box" placeholder="Message"/>
                            </div>
                            <div class="d-flex ">
                                <button>
                                    SEND
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="col-md-6 col-lg-5 px-0">
                        <form action="/auth/login">
                            <div>
                                <input type="text" placeholder="Name"/>
                            </div>
                            <div>
                                <input type="email" placeholder="Email"/>
                            </div>
                            <div>
                                <input type="text" placeholder="Phone"/>
                            </div>
                            <div>
                                <input type="text" class="message-box" placeholder="Message"/>
                            </div>
                            <div class="d-flex ">
                                <button>
                                    Login For Send!
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- end contact section -->

    @include('client.layouts.info-section')
@endsection
