@extends('layouts.app')

@section('content')
<div class="py-24 bg-background min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-4">
        <div class="card">
            <h1 class="text-3xl font-black text-primary mb-2 tracking-tighter text-center">RIDER REGISTRATION</h1>
            <p class="text-text-secondary text-center mb-8">Join the largest boda network in Dodoma.</p>

            <form action="{{ route('rider.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">First Name</label>
                        <input type="text" name="first_name" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Last Name</label>
                        <input type="text" name="last_name" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Phone Number (Tell)</label>
                    <input type="text" name="phone_number" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required placeholder="+255...">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Password</label>
                    <input type="password" name="password" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">License Number</label>
                    <input type="text" name="license_number" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Bike Plate Number</label>
                    <input type="text" name="bike_plate" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Bike Image</label>
                    <input type="file" name="bike_image" class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-primary/20">
                </div>


                <button type="submit" class="btn-primary w-full py-4 text-lg">Submit Application</button>
            </form>
            
            <div class="mt-6 text-center text-sm">
                Already have a rider account? <a href="{{ route('rider.login') }}" class="text-primary font-bold">Login here</a>
            </div>
        </div>
    </div>
</div>
@endsection
