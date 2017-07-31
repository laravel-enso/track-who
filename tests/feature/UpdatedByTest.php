<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TestHelper\app\Classes\TestHelper;
use LaravelEnso\TrackWho\app\Traits\UpdatedBy;

class UpdatedByTest extends TestHelper
{
    use DatabaseMigrations;

    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
    }

    /** @test */
    public function adds_updated_by_when_creating()
    {
        $this->signIn();

        $createdTestModel = TestModel::create(['name' => $this->faker->word]);

        $this->assertEquals(auth()->user()->fresh(), $createdTestModel->updatedBy);
    }

    /** @test */
    public function adds_updated_by_when_updating()
    {
        auth()->logout();
        $this->signIn(factory('App\User')->create());
        $createdTestModel = TestModel::create(['name' => $this->faker->word]);

        $createdTestModel->name = 'Updated';
        $createdTestModel->save();

        $this->assertEquals(auth()->user()->fresh(), $createdTestModel->fresh()->updatedBy);
    }

    private function createTestModelsTable()
    {
        Schema::create('test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
        });
    }
}

class TestModel extends Model
{
    use UpdatedBy;

    protected $fillable = ['name'];
}
