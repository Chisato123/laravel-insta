<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
  private $category;

  public function __construct(Category $category)
  {
    $this->category = $category;
  }
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    //add to categories table
    $categories = [
      [
        'name' => 'Theater',
        'created_at' => NOW(),
        'updated_at' => NOW()
      ],
      [
        'name' => 'Literature',
        'created_at' => NOW(),
        'updated_at' => NOW()
      ],
      [
        'name' => 'Gardening',
        'created_at' => NOW(),
        'updated_at' => NOW()
      ]
    ];

    $this->category->insert($categories);
  }
}
