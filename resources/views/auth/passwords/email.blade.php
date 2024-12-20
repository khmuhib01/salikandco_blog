@extends('layouts.frontend.layout')

@section('content')
    <div class="col-sm-offset-3 col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Reset Password') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3 m-b-10">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0 m-b-10">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        input {
            height: 14px;
            -webkit-appearance: auto;
            appearance: auto;
            padding-left: 10px;
            border: 1px solid #e9e9e9;
        }
        .card {
            padding: 14px;
            border: 1px solid #efe7e7;
        }
        .card-header {
            margin-bottom: 22px;
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 6px;
            border-bottom: 1px solid #ccc;
        }
        .m-b-10 {
            margin-bottom: 10px;
        }
        </style>
@endsection
