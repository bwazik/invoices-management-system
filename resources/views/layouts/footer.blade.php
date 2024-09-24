<!-- Footer opened -->
<footer class="bg-white p-4">
    <div class="row">
        <div class="col-md-6">
            <div class="text-center text-md-left">
                <p class="mb-0"> &copy; Copyright <span id="copyright">
                        <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>
                    </span>. <a href="https://github.com/bwazik"> Abdullah Mohamed </a> {{ trans('layouts/footer.all_rights_reserved') }}. </p>
            </div>
        </div>
        <div class="col-md-6">
            <ul class="text-center text-md-right">
                <li class="list-inline-item"><a href="#">{{ trans('layouts/footer.terms_conditions') }} </a> </li>
                <li class="list-inline-item"><a href="#">{{ trans('layouts/footer.privacy_policy') }} </a> </li>
            </ul>
        </div>
    </div>
</footer>
<!-- Footer closed -->
