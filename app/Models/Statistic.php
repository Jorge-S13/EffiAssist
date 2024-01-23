<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    public $timestamps = false;
    protected $casts = [
        'value' => 'array',
        'collected_at' => 'datetime',
    ];
    protected static $unguarded = true;

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    }

    public static function getStatsForBot(): array
    {
        $date = now();

        $diagramsToday = self::query()
            ->where('category', 'diagram')
            ->whereDate('collected_at', $date->toDateString())
            ->count();

        $diagramsTotal = self::query()
            ->where('category', 'diagram')
            ->count();

        $usersNewToday = Chat::query()
            ->whereDate('created_at', $date->toDateString())
            ->count();

        $usersActiveToday = self::query()
            ->distinct()
            ->whereDate('collected_at', $date->toDateString())
            ->whereNotNull('chat_id')
            ->count('chat_id');

        $usersTotal = Chat::count();

        return [
            'diagramsToday' => number_format($diagramsToday, thousands_separator: '˙'),
            'diagramsTotal' => number_format($diagramsTotal, thousands_separator: '˙'),

            'usersNewToday' => number_format($usersNewToday, thousands_separator: '˙'),
            'usersActiveToday' => number_format($usersActiveToday, thousands_separator: '˙'),
            'usersTotal' => number_format($usersTotal, thousands_separator: '˙'),
            'lastUpdate' => now()->format('Y-m-d H:i:s e'),
        ];
    }
}
