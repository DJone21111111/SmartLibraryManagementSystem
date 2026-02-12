<?php
namespace App\Enum;

/**
 * ReservationStatus enum values are string representations stored in the DB.
 * Note: the DB uses the American spelling 'canceled' (single "l"),
 * so the enum value for the cancelled state is 'canceled'.
 */
enum ReservationStatus: string
{
    case PENDING = 'waiting';
    case APPROVED = 'ready';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
    case COMPLETED = 'fulfilled';
}