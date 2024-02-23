<?php

namespace App\Enums;

enum StatusEnum: string
{
    case IN_MARKET = 'in_market';
    case PURCHASED ='purchased';
    case RENTED = 'rented';

}
