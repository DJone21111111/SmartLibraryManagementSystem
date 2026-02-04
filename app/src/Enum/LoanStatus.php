<?php
namespace App\Enum;

enum  LoanStatus: string
{
    case Active;
    case Returned;
    case Overdue;
}