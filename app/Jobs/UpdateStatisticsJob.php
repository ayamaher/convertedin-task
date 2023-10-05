<?php

namespace App\Jobs;

use App\Models\Statistics;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected int $assignedToUserId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $assignedToUserId)
    {
        $this->assignedToUserId = $assignedToUserId;
    }

    /**
     * @return int
     */
    public function getAssignedToUserId(): int
    {
        return $this->assignedToUserId;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $task = Statistics::firstOrNew(['user_id' => $this->assignedToUserId]);
            $task->task_count++;
            $task->save();

            Log::info('Tasks count updated for user ' . $this->assignedToUserId);
        } catch (\Exception $e) {
            Log::error('Error updating tasks count: ' . $e->getMessage());
        }
    }
}
