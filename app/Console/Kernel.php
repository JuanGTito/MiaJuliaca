protected function schedule(Schedule $schedule): void
{
    $schedule->command('publicidad:expirar')->hourly();
}