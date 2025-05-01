<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Admin user ID
        $user = User::where('username', 'admin')->first();


        if ($user) {
            // Insert 15 example records into the contacts table
            DB::table('contacts')->insert([
                [
                    'first_name' => 'Carlos',
                    'last_name_1' => 'Garcia',
                    'last_name_2' => 'Martinez',
                    'mobile' => '600123457',
                    'landline' => '910123457',
                    'email' => 'garcia@email.com',
                    'city' => 'Madrid',
                    'province' => 'Madrid',
                    'country' => 'Spain',
                    'notes' => 'Esta es la nota de Carlos.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Ana',
                    'last_name_1' => 'Fernandez',
                    'last_name_2' => 'Lopez',
                    'mobile' => '600234568',
                    'landline' => '910234568',
                    'email' => 'fernandez@email.com',
                    'city' => 'Barcelona',
                    'province' => 'Barcelona',
                    'country' => 'Spain',
                    'notes' => 'Nota de Ana sobre el trabajo.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Luis',
                    'last_name_1' => 'Perez',
                    'last_name_2' => 'Sanchez',
                    'mobile' => '600345679',
                    'landline' => '910345679',
                    'email' => 'perez@email.com',
                    'city' => 'Valencia',
                    'province' => 'Valencia',
                    'country' => 'Spain',
                    'notes' => 'A Luis le encanta el fútbol.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Marta',
                    'last_name_1' => 'Gomez',
                    'last_name_2' => 'Diaz',
                    'mobile' => '600456780',
                    'landline' => '910456780',
                    'email' => 'gomez@email.com',
                    'city' => 'Sevilla',
                    'province' => 'Sevilla',
                    'country' => 'Spain',
                    'notes' => 'Marta es una excelente cocinera.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Juan',
                    'last_name_1' => 'Rodriguez',
                    'last_name_2' => 'Garcia',
                    'mobile' => '600567891',
                    'landline' => '910567891',
                    'email' => 'rodriguez@email.com',
                    'city' => 'Madrid',
                    'province' => 'Madrid',
                    'country' => 'Spain',
                    'notes' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Maria',
                    'last_name_1' => 'Lopez',
                    'last_name_2' => 'Gonzalez',
                    'mobile' => '600678902',
                    'landline' => '910678902',
                    'email' => 'lopez@email.com',
                    'city' => 'Bilbao',
                    'province' => 'Vizcaya',
                    'country' => 'Spain',
                    'notes' => 'A Maria le gusta pintar.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Pedro',
                    'last_name_1' => 'Martinez',
                    'last_name_2' => 'Alvarez',
                    'mobile' => '600789013',
                    'landline' => '910789013',
                    'email' => 'martinez@email.com',
                    'city' => 'Granada',
                    'province' => 'Granada',
                    'country' => 'Spain',
                    'notes' => 'Pedro es un gran cantante.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Elena',
                    'last_name_1' => 'Torres',
                    'last_name_2' => 'Paredes',
                    'mobile' => '600890124',
                    'landline' => null,
                    'email' => 'torres@email.com',
                    'city' => 'Zaragoza',
                    'province' => 'Zaragoza',
                    'country' => 'Spain',
                    'notes' => 'A Elena le encanta viajar.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'Marc',
                    'last_name_1' => 'Dupont',
                    'last_name_2' => null,
                    'mobile' => '601234568',
                    'landline' => null,
                    'email' => 'dupont@email.com',
                    'city' => 'Paris',
                    'province' => null,
                    'country' => 'France',
                    'notes' => 'Marc enjoys cycling.',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ],
                [
                    'first_name' => 'John',
                    'last_name_1' => 'Doe',
                    'last_name_2' => null,
                    'mobile' => '601234569',
                    'landline' => null,
                    'email' => 'doe@email.com',
                    'city' => 'London',
                    'province' => null,
                    'country' => 'United Kingdom',
                    'notes' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $user->id
                ]
            ]);
        }

    }
}
