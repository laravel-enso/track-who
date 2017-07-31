<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TestHelper\app\Classes\TestHelper;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;

class CreatedByTest extends TestHelper
{
    use DatabaseMigrations;

    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
        $this->signIn();
    }

    /** @test */
    public function adds_created_by_when_creating()
    {
        $createdTestModel = TestModel::create(['name' => $this->faker->word]);

        $this->assertEquals(auth()->user()->fresh(), $createdTestModel->createdBy);
    }

    private function createTestModelsTable()
    {
        Schema::create('test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->unsigned();
            $table->timestamps();
        });
    }
}

class TestModel extends Model
{
    use CreatedBy;

    protected $fillable = ['name'];
}
