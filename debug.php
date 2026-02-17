<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

/** @var App\Filament\Resources\Items\Pages\ListItems $page */
$page = app(App\Filament\Resources\Items\Pages\ListItems::class);

\Filament\Facades\Filament::setServingPanel(
    \Filament\Panel::make('app')
);

$page->mount();
$page->bootedInteractsWithTable();

$table = $page->getTable();

$records = $page->getTableRecords();

$record = $records[0] ?? null;

if (! $record) {
    echo "no record\n";
    return;
}

echo "Record: " . $record->id . "\n";

foreach ($table->getColumns() as $column) {
    $state = $column->getStateFromRecord($record);
    echo $column->getName() . ' => ' . var_export($state, true) . "\n";
}
