<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container d-flex m-auto row mt-5">

        <div class="col-sm-6">
            <a href="{{ route('products') }}">

                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="text-bold">Product</h2>
                    </div>
                </div>
            </a>
        </div>
        @if (auth()->user()->role->role == 'admin'){
            <div class="col-sm-6">
                <a href="{{ route('users') }}">
                    <div class="card text-center">
                        <div class="card-body">
                            <h2 class="text-bold">User</h2>
                        </div>
                    </div>
                </a>
            </div>
            }
        @endif

    </div>
</x-app-layout>
