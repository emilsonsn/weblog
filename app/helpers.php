<?php

function locale()
{
    $locale = app()->getLocale();
    return str_contains($locale, 'pt') ? 'pt' : 'en';
}

function isEn(): bool
{
    return locale() == 'en';
}