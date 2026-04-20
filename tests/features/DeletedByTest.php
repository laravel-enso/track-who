<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TrackWho\Traits\DeletedBy;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeletedByTest extends TestCase
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

    #[Test]
    public function adds_deleted_by_when_deleting_model()
    {
        DeletedByTestModel::create()
            ->delete();

        $testModel = DeletedByTestModel::withTrashed()->first();

        $this->assertEquals(Auth::id(), $testModel->deleted_by);
    }

    #[Test]
    public function does_not_set_deleted_by_for_guests()
    {
        auth()->forgetGuards();

        $testModel = DeletedByTestModel::create();
        $testModel->delete();

        $this->assertNull($testModel->fresh()?->deleted_by);

        $trashed = DeletedByTestModel::withTrashed()->first();

        $this->assertNull($trashed->deleted_by);
    }

    #[Test]
    public function exposes_deleted_by_relation()
    {
        DeletedByTestModel::create()->delete();

        $testModel = DeletedByTestModel::withTrashed()->first();

        $this->assertTrue($testModel->deletedBy->is(Auth::user()));
    }

    #[Test]
    public function restores_event_dispatcher_after_setting_deleted_by()
    {
        $events = DeletedByTestModel::getEventDispatcher();

        DeletedByTestModel::create()->delete();

        $this->assertSame($events, DeletedByTestModel::getEventDispatcher());
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
    use SoftDeletes;
    use DeletedBy;
}
