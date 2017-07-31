<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TestHelper\app\Classes\TestHelper;
use LaravelEnso\TrackWho\app\Traits\DeletedBy;

class DeletedByTest extends TestHelper
{
    use DatabaseMigrations;

    protected $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
        $this->signIn();
    }

    /** @test */
    public function adds_deleted_by_when_deleting()
    {
        $createdTestModel = TestModel::create([
            'name' => $this->faker->word
            ]);

        $createdTestModel->delete();

        $this->assertTrue($createdTestModel->trashed());
    }

    private function createTestModelsTable()
    {
        Schema::create('test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}

class TestModel extends Model
{
    use SoftDeletes, DeletedBy;

    protected $fillable = ['name'];
    protected $dates    = ['deleted_at'];
}
