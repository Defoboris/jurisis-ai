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
            'name' => 'Basic',
            'price_cents' => 9900,
            'currency' => 'USD',
            'interval' => 'monthly',
            'features' => ['Chatbot limited', 'Contact 1 lawyer'],
        ]);

        SubscriptionPlan::create([
            'name' => 'Pro',
            'price_cents' => 19900,
            'currency' => 'USD',
            'interval' => 'monthly',
            'features' => ['Full chatbot', 'Unlimited lawyers', 'Appointments'],
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
