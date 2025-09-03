@extends('main')
@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.2/css/buttons.dataTables.min.css">

@endsection
@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4">Seminar Registrations</h2>
        <table id="seminarRegistrationsTable" class="table-auto w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Diseases</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Comment</th>
                    <th>Trx ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    @endsection

@section('scripts')
    
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#seminarRegistrationsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_seminar_registrations') }}",
                dom: 'Bfrtip', // Display the buttons
                buttons: [
                    'print',
                    'excelHtml5'
                ],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'diseases', name: 'diseases' },
                    { data: 'address', name: 'address' },
                    { data: 'age', name: 'age' },
                    { data: 'comment', name: 'comment' },
                    { data: 'trx_id', name: 'trx_id' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endsection

