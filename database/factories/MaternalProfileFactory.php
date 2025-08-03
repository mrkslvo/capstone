<?php

namespace Database\Factories;

use App\Models\Maternal_profiles;
use App\Models\Maternal_records;
use App\Models\MaternalProfiles;
use App\Models\MaternalRecords;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MaternalProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = MaternalProfiles::class;
    public function definition(): array
    {
        return [
            'user_id' => 1, // or use another factory to create user if needed
            'name' => fake()->name(),
            'spouse_name' => fake()->name(),
            'birthdate' => fake()->date('Y-m-d'), // a real date
            'age' => fake()->numberBetween(18, 45), // a realistic age
            'address' => fake()->address(),
            'contact_number' => fake()->phoneNumber(),
            'civil_status' => fake()->randomElement(['Single', 'Married', 'Widowed']),
            'philhealth_no' => 'PH' . fake()->randomNumber(8, true),
            'family_serial_no' => 'FSN' . fake()->unique()->randomNumber(4, true),
            'nhts_status' => fake()->randomElement(['NHTS', 'Non-NHTS']),
            'blood_type' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
        ];
    }
}
