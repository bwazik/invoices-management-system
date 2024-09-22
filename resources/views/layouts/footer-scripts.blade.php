<!-- jquery -->
<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>

<!-- plugins-jquery -->
<script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>

<!-- plugin_path -->
<script type="text/javascript">
    var plugin_path = '{{ asset('assets/js') }}/';
</script>

<!-- chart -->
<script src="{{ URL::asset('assets/js/chart-init.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<!-- charts sparkline -->
<script src="{{ URL::asset('assets/js/sparkline.init.js') }}"></script>

<!-- charts morris -->
<script src="{{ URL::asset('assets/js/morris.init.js') }}"></script>

<!-- datepicker -->
<script src="{{ URL::asset('assets/js/datepicker.js') }}"></script>

<!-- sweetalert2 -->
<script src="{{ URL::asset('assets/js/sweetalert2.js') }}"></script>

<!-- my code -->
@yield('js')

<!-- validation -->
<script src="{{ URL::asset('assets/js/validation.js') }}"></script>

<!-- custom -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script>

@if (App::getLocale() == 'en')
    <!-- Jquery Datatables -->
    <script src="{{ URL::asset('assets/js/bootstrap-datatables/en/jquery.dataTables.min.js') }}"></script>

    <!-- Bootstrab Datatables -->
    <script src="{{ URL::asset('assets/js/bootstrap-datatables/en/dataTables.bootstrap4.min.js') }}"></script>
@else
    <!-- Jquery Datatables -->
    <script src="{{ URL::asset('assets/js/bootstrap-datatables/ar/jquery.dataTables.min.js') }}"></script>

    <!-- Bootstrab Datatables -->
    <script src="{{ URL::asset('assets/js/bootstrap-datatables/ar/dataTables.bootstrap4.min.js') }}"></script>
@endif

{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>

<script type="text/javascript">
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;
        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }

    $(function() {
        $("#delete_all_btn").click(function() {
            var selected = new Array();

            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#delete_selected').modal('show')
                // var removeArrayValue = "on";
                // selected.splice($.inArray(removeArrayValue, selected), 1);
                $('input[id="delete_selected_id"]').val(selected);
            }
        });
    });

    $(function() {
        $("#unarchive_all_btn").click(function() {
            var selected = new Array();

            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#unarchive_selected').modal('show')
                // var removeArrayValue = "on";
                // selected.splice($.inArray(removeArrayValue, selected), 1);
                $('input[id="unarchive_selected_id"]').val(selected);
            }
        });
    });

    $(function() {
        $("#archive_all_btn").click(function() {
            var selected = new Array();

            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#archive_selected').modal('show')
                // var removeArrayValue = "on";
                // selected.splice($.inArray(removeArrayValue, selected), 1);
                $('input[id="archive_selected_id"]').val(selected);
            }
        });
    });
</script>

<script>
    updateList = function() {
        var output1 = document.getElementById('attachments_names');
        output1.innerHTML = '';

        var input = document.getElementById('attachments');
        var output = document.getElementById('attachments_names');

        for (var i = 0; i < input.files.length; ++i) {
            output.innerHTML += input.files.item(i).name + '   -   ';
        }
    }
</script>

<script>
    toastr.options = {
        'closeButton' : true,
        'progressBar' : true,
        // 'preventDuplicates' : true,
    }
</script>
