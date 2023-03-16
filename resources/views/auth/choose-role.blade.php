@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Anda akan melanjutkan sebagai?') }}</div>

                <div class="card-body">
                    <form method="POST" id="formRole" action="{{ route('store.role') }}">
                        @csrf

                        <div class="container">
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" onclick="chooseRole('Admin')">
                                            {{ __('Admin Toko') }}
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="chooseRole('User')">
                                            {{ __('Customer') }}
                                        </button>
                                        <input type="hidden" id="role" name="role">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function chooseRole(role) {
        document.getElementById('role').value = role;
        document.getElementById('formRole').submit();
    }
</script>

@endsection
