<?php

namespace OptimistDigital\NovaNotesField;

use Illuminate\Support\Collection;

class Types
{
    public static function get(): Collection
    {
        return collect(config('nova-notes-field.types'));
    }

    public static function default(): ?string
    {
        return config('nova-notes-field.default_type');
    }
}
