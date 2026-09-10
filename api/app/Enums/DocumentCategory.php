<?php

namespace App\Enums;

enum DocumentCategory: string
{
    case Admission = 'admission';
    case Reglement = 'reglement';
    case Autre = 'autre';
}
