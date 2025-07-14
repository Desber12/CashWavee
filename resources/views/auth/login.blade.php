@extends('layouts.guest')

@section('content')
<div class="flex justify-center bg-white py-20">
    <div class="w-full max-w-md rounded-lg shadow-lg bg-white">
        <div class="h-[3px] bg-[#f93c39] w-full mx-auto"></div>

        <div class="p-8">
            <h2 class="font-semibold text-[#f93c39] text-[32px] font-['Lexend_Deca'] text-left mb-8">
                Login
            </h2>

            @if(session('status'))
                <div class="mb-4 text-sm text-red-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <input type="email" name="email" required autofocus
                        placeholder="Email"
                        class="w-full h-12 bg-[#fefeff] border-2 border-[#edeffd] rounded px-4 text-black text-base font-['Exo_2']">
                </div>

                <div>
                    <input type="password" name="password" required
                        placeholder="Password"
                        class="w-full h-12 bg-[#fefeff] border-2 border-[#edeffd] rounded px-4 text-black text-base font-['Exo']">
                </div>

                <button type="submit"
                    class="w-full h-12 mt-6 bg-[#f93c39] hover:bg-[#e03532] rounded text-white text-xl font-semibold font-['Lexend_Deca']">
                    Login
                </button>
            </form>
        </div>

        <div class="text-center py-4 font-semibold text-black text-sm font-['Inter']">
            Copyright ©CashWave
        </div>
    </div>
</div>
@endsection
