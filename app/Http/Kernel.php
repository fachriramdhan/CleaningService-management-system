protected $middlewareAliases = [
'role' => \App\Http\Middleware\CheckRole::class,
'shift.request.period' => \App\Http\Middleware\CheckShiftRequestPeriod::class,
];
