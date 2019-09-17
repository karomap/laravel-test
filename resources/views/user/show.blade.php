@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Detail</h4>

                    <div class="card-text">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <dl>
                            <dt>Name</dt>
                            <dd>{{ $user->name }}</dd>
                            <dt>Email</dt>
                            <dd>{{ $user->email }}</dd>
                            <dt>Role</dt>
                            <dd>{{ strtoupper($user->role) }}</dd>
                            <dt>Created</dt>
                            <dd>{{ $user->created_at->format('d F Y | H:i:s') }}</dd>
                            <dt>Updated</dt>
                            <dd>{{ $user->updated_at->format('d F Y | H:i:s') }}</dd>
                        </dl>
                    </div>

                    <div class="d-flex">
                        <a href="{{ route('user.edit', app()->getLocale()) }}" class="btn btn-primary mr-2">{{ __('Edit') }}</a>
                        <form method="POST" action="{{ route('user.destroy', app()->getLocale()) }}" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
