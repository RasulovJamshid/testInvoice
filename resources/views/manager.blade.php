@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
    <div class="card-header">{{ __('Requests') }}</div>

            <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice Id</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>User_id</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Image</th>
                        <th>CreatedTime</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->title }}</td>
                            <td>{{ $invoice->message }}</td>
                            <td>{{ $invoice->user->id }}</td>
                            <td>{{ $invoice->user->email }}</td>
                            <td>{{ $invoice->user->name }}</td>
                            <td><a href={{ $invoice->img_url }}>IMG</a></td>
                            <td>{{ $invoice->created_at }}</td>

                            @if($invoice->checked ==1)
                                <td class="alert alert-success">Checked</td>
                            @else
                                <td class="alert alert-danger">Pending</td>
                            @endif

                            <td>
                            @if($invoice->checked ==0)
                            <a href="{{ url('/invoice/' . $invoice->id . '/edit') }}" class="btn btn-xs btn-info pull-right">CHECK</a>
                            @endif
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $invoices->links() !!}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
