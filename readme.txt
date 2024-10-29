Clone this project
Create DB named deversity_assesment
copy .env example rename it to .env
update database variables
run php artisan migrate 
run php artisan serve

{{ route('users.edit', $user->id) }}