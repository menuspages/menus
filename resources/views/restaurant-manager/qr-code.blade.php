@extends('layouts.restaurant-manager-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mt-2">
            <button class="btn btn-primary w-25" id="print-qr">طباعة</button>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-5" id="qr-code">
            {!! $QRCode !!}
        </div>
    </div>
@endsection
@section('body-scripts')
    <script>
        function printContent(el) {
            let restorePage = $('body').html();
            let printDiv = $('#' + el).clone();
            $('body').empty().html(printDiv);
            window.print();
            $('body').html(restorePage);
        }

        $(document).ready(() => {
            $('#print-qr').click(() => {
                printContent('qr-code');
            })
        })
    </script>
@endsection
