<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed UserTypes
        $userTypes = ['Administrateur', 'Archiviste', 'Chercheur'];
        foreach ($userTypes as $type) {
            DB::table('user_types')->insert([
                'name' => $type,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed Users
        DB::table('users')->insert([
            [
                'name' => 'Admin Archives',
                'email' => 'admin@archives.gov',
                'password' => Hash::make('password'),
                'user_types_id' => 1, // Administrateur
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chercheur Dupont',
                'email' => 'chercheur@universite.edu',
                'password' => Hash::make('password'),
                'user_types_id' => 3, // Chercheur
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed Priority
        $priorities = ['Basse', 'Moyenne', 'Haute', 'Urgente'];
        foreach ($priorities as $priority) {
            DB::table('priority')->insert([
                'name' => $priority,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed Category
        $categories = ['Documents historiques', 'Registres civils', 'Documents gouvernementaux', 'Archives médiatiques'];
        foreach ($categories as $category) {
            DB::table('category')->insert([
                'name' => $category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed ConsultationRequests
        DB::table('consultation_requests')->insert([
            [
                'description' => 'Demande d\'accès aux registres de naissance de 1900 à 1910',
                'date_start' => Carbon::now(),
                'date_end' => Carbon::now()->addDays(14),
                'status' => 'pending',
                'user_id' => 2, // Chercheur
                'priority_id' => 2, // Moyenne
                'category_id' => 2, // Registres civils
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'description' => 'Consultation des documents relatifs à la construction du Parlement',
                'date_start' => Carbon::now(),
                'date_end' => Carbon::now()->addDays(30),
                'status' => 'accepted',
                'user_id' => 2, // Chercheur
                'priority_id' => 3, // Haute
                'category_id' => 3, // Documents gouvernementaux
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seed ConsultationAnswers
        DB::table('consultation_answers')->insert([
            [
                'description' => 'Votre demande a été acceptée. Les documents seront disponibles en salle de lecture à partir du [date]. Veuillez vous présenter avec une pièce d\'identité.',
                'consultation_request_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 1, // Admin Archives
            ],
        ]);
    }
}
