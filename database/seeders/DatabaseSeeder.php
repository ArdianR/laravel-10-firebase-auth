<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\QueryException;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(Faker $faker): void
  {
    // Pelanggan::factory(100000)->create();
    ini_set('memory_limit', '1024M');
    $totalStartTime = microtime(true);

    for ($i = 0; $i < 320; $i++) {
      $data = [];
      $startTime = microtime(true);

      echo "Memory usage before unset: " . round(memory_get_usage() / 1048576, 2) . " MB\n";

      for ($v = 0; $v < 50000; $v++) {
        $data[] = [
          'nama' => $faker->name,
          'email' => $faker->unique()->safeEmail,
          'alamat' => $faker->address,
          'no_telp' => $faker->phoneNumber,
        ];
      }

      $chunks = array_chunk($data, 5000);
      foreach ($chunks as $chunk) {
        try {
          Pelanggan::query()->insert($chunk);
        } catch (QueryException $e) {
          if ($e->getCode() == '23000') {
            // Duplicate entry error, skip the record
            continue;
          } else {
            throw $e;
          }
        }
        unset($chunk);
      }
      unset($data);
      $data = [];
      $endTime = microtime(true);
      $insertTime = $endTime - $startTime;
      echo "Seeder " . $insertTime . " seconds." . PHP_EOL;
      $totalMemory = memory_get_peak_usage(true);
      echo "Memory used Seeder: " . round($totalMemory / 1048576, 2) . " MB." . PHP_EOL;
      unset($chunks);
      gc_collect_cycles();

      echo "Memory usage after  unset: " . round(memory_get_usage() / 1048576, 2) . " MB\n";
    }
    $totalEndTime = microtime(true);
    $totalTime = $totalEndTime - $totalStartTime;
    echo "finished in " . $totalTime . " seconds." . PHP_EOL;
    $totalMemoryUsage = memory_get_peak_usage(true);
    echo "Memory used finished: " . round($totalMemoryUsage / 1048576, 2) . " MB." . PHP_EOL;
  }
}
