<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

	public function admin()
	{
		return $this->state(fn (array $attributes) => [
			'role_id' => Role::ADMIN,
		]);
	}

	public function tradutor()
	{
		return $this->state(fn (array $attributes) => [
			'role_id' => Role::TRADUTOR,
		]);
	}

	public function cliente()
	{
		return $this->state(fn (array $attributes) => [
			'role_id' => Role::CLIENTE,
		]);
	}

	public function languages()
	{
		// $roles = Role::all()
		// 	->random()
		// 	->take(rand(1, 4))
		// 	->pluck('id')
		// 	->toArray();

		$roles = Role::inRandomOrder()
			->limit(rand(1, 3))
			->pluck('id')
			->toArray();

		return $this->afterCreating(fn(User $user) => $user->languages()->sync($roles));
	}
}
