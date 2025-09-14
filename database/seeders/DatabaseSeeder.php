<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Lawyer;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@jurist.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Subscription plans
        SubscriptionPlan::create([
            'name' => 'Découverte',
            'price_cents' => 10,
            'currency' => 'USD',
            'interval' => 'monthly',
            'description' => 'Pour découvrir notre plateforme',
            'badge' => 'Découverte',
            'features' => ["Consulter la liste des juristes", "Accès limité au bot Jurisis", "Analyse simple de documents", "Accès à tous nos experts"],
            'buttonText' => 'Parler à Jurisis',
            'buttonVariant' => 'outline',
            'is_popular' => true,
            'is_active' => true,
        ]);

        SubscriptionPlan::create([
            'name' => "Soutenir l'initiative",
            'price_cents' => 30,
            'currency' => 'USD',
            'interval' => 'monthly',
            'description' => 'Pour des indépendants, PME',
            'badge' => 'Soutenir l\'initiative',
            'features' => ["Dialogue avec les juristes", "Accès à tous nos experts", "Génération automatique (IA)", "Participation au développement de l'IA"],
            'buttonText' => 'Soutenir Jurisis',
            'buttonVariant' => 'default',
            'is_popular' => true,
            'is_active' => true,
        ]);

        SubscriptionPlan::create([
            'name' => "Plan Business",
            'price_cents' => 100,
            'currency' => 'USD',
            'interval' => 'monthly',
            'description' => 'Pour les professionnels du droit',
            'badge' => null,
            'features' => ["Un chatbot avec vos données", "Votre expertise dans un produit", "Formation aux outils IA", "Participation au développement de l'IA"],
            'buttonText' => 'Nous contacter',
            'buttonVariant' => 'outline',
            'is_popular' => true,
            'is_active' => true,
        ]);

        // Sample Lawyer
        $lawyerUser = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'lawyer@jurist.test',
            'password' => bcrypt('password'),
            'role' => 'lawyer',
        ]);

        Lawyer::create([
            'user_id' => $lawyerUser->id,
            'specialty' => 'Business Law',
            'firm_name' => 'Doe & Partners',
            'slug' => 'john-doe',
            'headline' => 'Expert in business law',
            'bio' => '15 years experience in international business law...',
            'is_published' => true,
            'moderation_state' => 'approved',
        ]);
    }
}
