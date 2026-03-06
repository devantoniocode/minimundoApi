<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "project_id",
        "predecessor_task_id",
        "description",
        "start_date",
        "end_date",
        "status",
    ];

    protected $appends = [
        "start_date",
        "end_date",
        "start_date_br",
        "end_date_br",
    ];

    public function getStartDateAttribute()
    {
        return empty($this->attributes["start_date"]) ? null : date("Y-m-d", strtotime($this->attributes["start_date"]));
    }
    public function getEndDateAttribute()
    {
        return empty($this->attributes["end_date"]) ? null : date("Y-m-d", strtotime($this->attributes["end_date"]));
    }

    public function getStartDateBrAttribute()
    {
        return empty($this->attributes["start_date"]) ? null : date("d/m/Y", strtotime($this->attributes["start_date"]));
    }
    public function getEndDateBrAttribute()
    {
        return empty($this->attributes["end_date"]) ? null : date("d/m/Y", strtotime($this->attributes["end_date"]));
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
