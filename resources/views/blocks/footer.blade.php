<footer class="footer">
    <div class="container @yield('custom-container')">
        <div class="nav h-70">
           <div class="nav__logo">
               <img src="{{ asset('img/logo_end.png') }}" alt="logo-site" class="logo__site">
           </div>
           <div class="copyright-footer">
                @ 2020 Broadcasts
            </div>
           <div class="social-media">
                <a href="" class="social-media__item">
                    <img src="{{ asset('img/facebook.png') }}" alt="facebook" class="social-img">
                </a>
                <a href="" class="social-media__item">
                    <img src="{{ asset('img/instagram.png') }}" alt="instagram" class="social-img">
                </a>
                <a href="" class="social-media__item">
                    <img src="{{ asset('/img/twitter.png') }}" alt="twitter" class="social-img">
                </a>

           </div>
        </div>
     </div>
  </footer>
