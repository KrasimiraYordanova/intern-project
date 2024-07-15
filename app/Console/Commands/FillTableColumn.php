<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Property;
use Illuminate\Console\Command;

class FillTableColumn extends Command
{
    // private $allModels;
    private $models;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:column {model} {column} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Table Column';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $model = $this->arguments()['model'];
        $column = $this->arguments()['column'];
        $value = $this->arguments()['value'];

        if ($model === "Car") {
            $this->models = Car::all();
        } elseif ($model === "Properties") {
            $this->models = Property::all();
        }
        
        foreach ($this->models as $model) {
            $model->$column = $value;
            $model->save();
        }
        
        return Command::SUCCESS;
    }
}
