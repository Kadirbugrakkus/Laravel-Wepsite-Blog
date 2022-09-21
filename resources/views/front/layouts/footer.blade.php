<!-- Footer-->
<footer class="footer mt-5">

    <!-- footer-middle -->
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h3>Pages</h3>
                                <ul>
                                    <li><a href="{{route('contact')}}">About Us</a></li>

                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Product</h3>
                                <ul>
                                    <li><a href="index2.html">Features</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Services</h3>
                                <ul>
                                    <li><a href="services.html">Digital Marketing</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Pages</h3>
                                <ul>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">

                    <div class="f-about single-footer">
                        <div class="logo">
                            <a href="{{route('homepage')}}">
                                <img src="{{asset($config->logo)}}" alt="Logo">
                                <label class="text-white">{{$config->title}}</label>
                            </a>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <!-- End footer-middle -->


    <!-- footer-bottom-->
    <div class="footer-bottom">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-12">
                        <div class="left">
                            <ul class="list-inline text-center">
                                @php $socials=['facebook','twitter','github','linkedin','youtube','instagram']; @endphp
                                @foreach($socials as $social)
                                    @if($config->$social != null)
                                        <li class="list-inline-item">
                                            <a href="{{$config->$social}}" target="_blank">
                                                <span class="fa-stack fa-lg">
                                                    <i class="fas fa-circle fa-stack-2x"></i>
                                                    <i class="fab fa-{{$social}} fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <p class="copyright text-dark">Copyright &copy; {{$config->title}} {{date('Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer-bottom-->
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{asset('fronts/js/scripts.js')}}"></script>
</body>
</html>
