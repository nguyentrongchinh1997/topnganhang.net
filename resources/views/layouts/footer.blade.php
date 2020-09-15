<!--=================================
  Footer-->
  <footer class="footer bg-light">

    <div class="footer-bottom bg-dark mt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-6 ">
            <div class="d-flex justify-content-md-start justify-content-center">
              <ul class="list-unstyled d-flex mb-0">
                <li><a href="#">Chính sách</a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Liên hệ</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 text-center text-md-right mt-4 mt-md-0">
            <p class="mb-0"> &copy;Copyright <span id="copyright"> <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script></span> <a href="{{asset('')}}"> Topnganhang.net </a> </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
<!--=================================
  Footer-->

<!--=================================
  Back To Top-->
  <div id="back-to-top" class="back-to-top">
   <i class="fas fa-angle-up"></i>
 </div>
<!--=================================
  Back To Top-->

<!--=================================
  Javascript -->

  <!-- JS Global Compulsory (Do not remove)-->
  <script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('assets/js/popper/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>

  <!-- Page JS Implementing Plugins (Remove the plugin script here if site does not use that feature)-->
  <script src="{{asset('assets/js/jquery.appear.js')}}"></script>
  <script src="{{asset('assets/js/counter/jquery.countTo.js')}}"></script>
  <script src="{{asset('assets/js/owl-carousel/owl-carousel.min.js')}}"></script>

  <!-- Template Scripts (Do not remove)-->
  <script src="{{asset('assets/js/custom.js')}}"></script>
  <script src="{{asset('assets/js/select2/select2.full.js')}}"></script>
  @yield('js')
</body>
</html>
