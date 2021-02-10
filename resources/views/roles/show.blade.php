@extends('layouts.admin')

@section('title', __('View Role Details'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Viewing Role</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/roles">Roles</a></li>
				<li class="breadcrumb-item active">View</li>
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
<script>
    $(function(){
        $('.deleteAction').click(function(e){
            e.preventDefault();
            var form = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                html: "You want to delete this role.<br> If user is attached to this this role, this action will fail!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed){
                    $(form).submit();
                }
            });
        });
    });
</script>
@endpush

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">{{ $entity->name }}</h4>
				<div class="">
					<div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Access</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($entity->permissions as $perm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $perm->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-6"><a href="/roles/{{ $entity->id }}/edit" class="btn btn-warning btn-lg">Edit</a> <a href="" class="deleteAction btn btn-danger btn-lg ml-2" data-target="#delete-role{{$entity->id}}"><span>Remove Role</span></a></div>
                        <form id="delete-role{{$entity->id}}" action="{{ route('roles.destroy', $entity->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection