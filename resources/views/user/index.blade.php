@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <a class="btn btn-success mb-3"
                        href="{{ route('admin.user.create', app()->getLocale()) }}">{{ __('Add User') }}</a>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.user.edit', ['user' => $user, 'locale' => app()->getLocale()]) }}"
                                                class="btn btn-sm btn-primary mr-2">{{ __('Edit') }}</a>
                                            <form method="POST"
                                                action="{{ route('admin.user.destroy', ['user' => $user, 'locale' => app()->getLocale()]) }}"
                                                class="" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </form>
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
    </div>
</div>
@endsection
