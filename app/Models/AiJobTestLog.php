<?php

/**
 * AiJobTestLog
 *
 * This model represents a very simple database table used only
 * for testing and verification purposes.
 *
 * In our system, it is used together with scheduled commands
 * and queued jobs to confirm that background execution works.
 *
 * When a scheduled command or job runs, it writes a row to this
 * table. If the row appears in the database, we know that:
 * - the scheduler is running
 * - the queue/command executed successfully
 *
 * This model is not part of the core business logic.
 * It exists purely as a technical check.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiJobTestLog extends Model
{
    /**
     * These are the fields that are allowed to be mass assigned.
     *
     * In this case, we only store a simple text message,
     * usually containing a timestamp or test information.
     */
    protected $fillable = ['message'];
}
