<!-- Title -->
<title>@yield("mainTitle")</title>

<!-- Favicon -->
<link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon" />

<!-- Fontawesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Font -->
@if (App::getLocale() == 'en')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">
@else
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap" rel="stylesheet">
@endif

<!--- Style css -->
<link href="{{ URL::asset('assets/css/wizard.css') }}" rel="stylesheet">

{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"> --}}

<!--- Style css -->
@yield('css')

@if (App::getLocale() == 'en')
    <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
@else
    <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
@endif

<style>
    #datatable{
        text-align: center !important;
        width: 100% !important;
    }
    .nice-select{
        width : 100% !important;
    }
    .nice-select.open .list{
        width: 100% !important;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }

    select.form-control{
        height: auto !important;
    }

    .float-start{
        float: left !important;
    }

    .floar-end{
        float: right !important;
    }

    .text-end{
        text-align: right !important;
    }

    @media print {
        #print_btn {
            display: none;
        }

        .side-menu-fixed {
            display: none;
        }
    }
</style>
