<?php

namespace App\Enums;

enum LessonStatusEnum:string
{
    
    case SCHEDULED = 'scheduled';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case IN_PROGRESS = 'in_progress';
   
}
