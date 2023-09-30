@extends('frontend.layouts.app');
@section('title', 'Scan QR');

@section('content')
    <div class="scan-qr p-3">
        <div class="card mt-3 mb-3 shadow">
            <div class="card-body">
                <div class="text-center img">
                    <img src="{{asset('images/scanpay.png')}}" alt="">
                </div>
                <p class="text-center">Click "Scan" button, put QR code in the frame and pay</p>

                <!-- Button trigger modal -->
                <button class="scan" data-bs-toggle="modal" data-bs-target="#qrScanner">
                    <img src="{{asset('images/scanner.png')}}" alt="">
                    <span>Scan</span>
                </button>

                <div class="modal fade" style="z-index: 999999;" id="qrScanner" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content" style="border-radius: 10px;">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="qrScannerLabel">Scan & Pay</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <video id="scanner" width="100%" height=300px"></video>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{asset('frontend/js/qr-scanner.umd.min.js')}}"></script>
    <script>
            $(document).ready(function() {
                let scanner = document.getElementById('scanner');
                let qrModal = document.getElementById('qrScanner');
                const qrScanner = new QrScanner(
                    scanner,
                    result => {
                        if(result) {
                            qrScanner.stop();
                            $('#qrScanner').modal('hide');

                            let scanned_phone = result;
                            window.location.replace(`scan-and-pay-form?scanned_phone=${scanned_phone}`);
                        }
                    },
                );

                qrModal.addEventListener('show.bs.modal', event => {
                    qrScanner.start();
                })

                qrModal.addEventListener('hidden.bs.modal', event => {
                    qrScanner.stop();
                })
            })
    </script>
@endsection
