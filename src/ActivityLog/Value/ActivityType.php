<?php
declare(strict_types=1);

namespace App\ActivityLog\Value;

enum ActivityType: string
{
    case OTHER_CARDIO = 'card';
    case RUNNING = 'running';
    case CYCLING = 'cycling';
    case INDOOR_CYCLING = 'indoorCycling';
    case HIKING = 'hiking';
    case WALKING = 'walking';
    case SWIMMING = 'swimming';
    case WEIGHT_LIFTING = 'gym';
}