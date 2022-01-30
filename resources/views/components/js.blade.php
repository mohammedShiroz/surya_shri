<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>
<!-- Latest jQuery -->
<script src="{{ asset('assets/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<!-- popper min js -->
<script src="{{ asset('assets/js/popper.min.js')}}"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- owl-carousel min js  -->
<script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js')}}"></script>
<!-- magnific-popup min js  -->
<script src="{{ asset('assets/js/magnific-popup.min.js')}}"></script>
<!-- waypoints min js  -->
<script src="{{ asset('assets/js/waypoints.min.js')}}"></script>
<!-- parallax js  -->
<script src="{{ asset('assets/js/parallax.js')}}"></script>
<!-- imagesloaded js -->
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
<!-- isotope min js -->
<script src="{{ asset('assets/js/isotope.min.js')}}"></script>
<!-- jquery.dd.min js -->
<script src="{{ asset('assets/js/jquery.dd.min.js')}}"></script>
<!-- slick js -->
<script src="{{ asset('assets/js/slick.min.js')}}"></script>
<!-- elevatezoom js -->
<script src="{{ asset('assets/js/jquery.elevatezoom.js')}}"></script>
<!-- scripts js -->
<script src="{{ asset('assets/js/scripts.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets/js/page/cart_nav_curd.js') }}"></script>
@stack('js')
<script type="text/javascript">var close = document.getElementsByClassName("msg-closebtn"); for (var i = 0; i < close.length; i++) { close[i].onclick = function(){ var div = this.parentElement; div.style.opacity = "0"; setTimeout(function(){ div.style.display = "none"; }, 600); } } </script>
{{--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>--}}
{{--<script type="text/javascript" src="{{ asset('assets/js/google_translation.js') }}"></script>--}}
@stack('script')
