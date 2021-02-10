@extends('layouts.user')

@section('title', __('Farms'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Farms</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Farms</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@push('more-styles')
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('more-scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/pages/datatables.init.js') }}"></script>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Farms</h4>
                <p class="sub-title../plugins">
                </p>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Cover Image</th>
                            <th>Start date</th>
                            <th>Close date</th>
                            <th>Duration</th>
                            <th>ROI</th>
                            <th>Status</th>
                            <th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entities as $entity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $entity->name }}</td>
                            <td><img src="{{ $entity->cover_image }}" width="120px"></td>
                            <td>{{ date('d M, Y h:i A', strtotime($entity->start_date)) }}</td>
                            <td>{{ date('d M, Y h:i A', strtotime($entity->close_date)) }}</td>
                            <td>{{ $entity->duration }} {{ $entity->duration_type }}</td>
                            <td>{{ $entity->roi }}%</td>
                            <td>{!! $entity->status() !!}</td>
                            <td>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="/farms/{{ $entity->slug }}"><span> View Farm</span></a></li>
                                        @if($entity->status == 'opened')
                                        <li class="dropdown-item"><a href="/farms/{{ $entity->slug }}/invest"><span>Invest</span></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection