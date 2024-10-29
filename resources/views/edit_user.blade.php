<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="container" >
        
        <form style="background-color: white" action="{{ route('users.update', $user->id) }}" method="POST" class="mt-4 p-5" style="width: 600px !important">
            @csrf
            @method('PUT')
    
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role_id" required>
                    <option value="">Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                            {{ $role->role }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                   {{ $user->permission->contains('id', $permission->id) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $permission->permission }} <!-- Adjust this according to the actual attribute name for permission display -->
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            
    
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</x-app-layout>
