<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TestHelper\app\Traits\SignIn;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use Tests\TestCase;

class CreatedByTest extends TestCase
{
    use RefreshDatabase, SignIn;

    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
        $this->signIn();
    }

    /** @test */
    public function adds_created_by_when_creating_model()
    {
        $createdTestModel = CreatedByTestModel::create(['name' => $this->faker->word]);

        $this->assertEquals(auth()->user()->fresh(), $createdTestModel->createdBy);
    }

    private function createTestModelsTable()
    {
        Schema::create('created_by_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->unsigned();
            $table->timestamps();
        });
    }
}

class CreatedByTestModel extends Model
{
    use CreatedBy;

    protected $fillable = ['name'];
}
