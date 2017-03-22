<footer>
    <div class="footer-top">
        <div class="container footer-top">
            <div class="row">
                <div class="col-md-6 footer-col text-center">
                    <h4 class="text-danger">GitHub <a href="https://github.com/bhutanio/imagehost" title="imagehost GitHub Repo" target="_blank">Repo</a></h4>
                    <p>Copyright &copy; {{ env('SITE_NAME') }}</p>
                </div>
                <div class="col-md-6 footer-col text-center">
                    <h4 class="text-danger"><a href="{{ url('about') }}">About</a> {{ env('SITE_NAME') }}</h4>
                    <p>{{ env('SITE_NAME') }} is a free to use, open source Image Hosting service, <br>created by
                        <a href="http://bhutan.io" title="Bhutan.io">bhutan.io</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>