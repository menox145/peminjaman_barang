@extends('layouts.MainClear')

@section('container')
<div class="row justify-content-center">
    <div class="col-md-5">
        <main class="form-registration">
            <form action="/register" method="POST">
                @csrf
                <img class="mb-5" src="{{asset('img/logorspj.png')}}" alt="" width="72" height="72">
                <h1 class="h3 mb-3 fw-normal">Registration Form Inventory</h1>
                
                <div class="form-floating">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Please entry your name" required value="{{ old('name') }}">
                    <label for="name">Name</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Please entry your Username" required value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                    <label for="email">Email address</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <select class="form-control selectpicker @error('unit_bagian') is-invalid @enderror" name="unit_bagian" id="unit_bagian" title="Pilih Unit Bagian" required>
                        <option value="">Pilih Unit Bagian</option>
                        <option value="dokter" {{ old('unit_bagian') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="perawat" {{ old('unit_bagian') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                        <option value="it" {{ old('unit_bagian') == 'it' ? 'selected' : '' }}>IT</option>
                    </select>
                    <label for="unit_bagian">Unit Bagian</label>
                    @error('unit_bagian')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button class="w-100 btn btn-lg btn-primary mt-5" type="submit">Sign in</button>
            </form>
            <small class="d-block text-center mt-3">Already registered?!, <a href="/login">Go to Login</a></small>
        </main>
    </div>
    <p class="mt-5 mb-3 text-muted">&copy; Devlope by MuSt</p>
</div>
@endsection