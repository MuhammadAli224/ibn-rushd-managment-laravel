<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'center'  => $this->center->name ?? null,
            'subject' => $this->subject->name ?? null,
            'teacher' =>  $this->teacher->name ?? null,
            'driver' =>  $this->driver->name ?? null,
            'student' => $this->student->name ?? null,
            'lesson_date' => $this->lesson_date->format('Y-m-d'),
            'lesson_start_time' => $this->combineDateTime($this->lesson_date, $this->lesson_start_time),
            'lesson_end_time' => $this->combineDateTime($this->lesson_date, $this->lesson_end_time),

            'lesson_location' => $this->lesson_location,
            'lesson_notes' => $this->lesson_notes,
            'status' => $this->status->value,
            'lesson_duration' => $this->lesson_duration,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'uber_charge' =>(float)$this->uber_charge,
            'lesson_price' => $this->lesson_price,
            'is_active' => $this->is_active,
            'commission_rate' => $this->commission_rate,
            'created_by' => $this->creator->name ?? null,
            'created_at' => $this->created_at,
        ];
    }

   private function combineDateTime($date, $time)
{
    if (!$date || !$time) {
        return null;
    }

    $dateString = $date instanceof \Carbon\Carbon ? $date->format('Y-m-d') : (string)$date;

    return \Carbon\Carbon::parse($dateString . ' ' . $time)->format('Y-m-d H:i:s A');
}

}
