<?php

use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelEnso\TrackWho\app\Traits\DeletedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletedByTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->createTestModelsTable()
            ->actingAs(User::first());
    }

    /** @test */
    public function adds_deleted_by_when_deleting_model()
    {
        $testModel = DeletedByTestModel::create();

        $testModel->delete();

        $testModel = DeletedByTestModel::withTrashed()
            ->first();

        $this->assertEquals(
            auth()->user()->fresh()->id,
            $testModel->deleted_by
        );
    }

    private function createTestModelsTable()
    {
        Schema::create('deleted_by_test_models', function ($table) {
            $table->increments('id');
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        return $this;
    }
}

class DeletedByTestModel extends Model
{
    use SoftDeletes, DeletedBy;
}
