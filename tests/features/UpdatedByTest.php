<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TrackWho\Traits\UpdatedBy;
use Tests\TestCase;

class UpdatedByTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $userModel = Config::get('auth.providers.users.model');

        $this->seed()
            ->createTestModelsTable()
            ->actingAs($userModel::first());
    }

    /** @test */
    public function adds_updated_by_when_updating_model()
    {
        $testModel = UpdatedByTestModel::create(['name' => 'initial']);

        $testModel->update(['name' => 'changed']);

        $this->assertEquals(Auth::id(), $testModel->updated_by);
    }

    private function createTestModelsTable()
    {
        Schema::create('updated_by_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        return $this;
    }
}

class UpdatedByTestModel extends Model
{
    use UpdatedBy;

    protected $fillable = ['name'];
}
