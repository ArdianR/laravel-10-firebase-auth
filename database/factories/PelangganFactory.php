<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pelanggan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */

  protected $model = Pelanggan::class;

  public function definition(): array
  {
    return [
      'nama' => $this->faker->name,
      'email' => $this->faker->unique()->safeEmail,
      'alamat' => $this->faker->address,
      'no_telp' => $this->faker->phoneNumber,
    ];
  }
}
