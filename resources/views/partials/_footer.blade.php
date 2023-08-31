<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                {{date('Y')}} &copy; {{config('app.name')}}.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Powered by: <a href="">{{env('POWERED_BY')}}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
