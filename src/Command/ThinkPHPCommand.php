<?php

declare(strict_types=1);

namespace JaguarJack\MigrateGenerator\Command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use JaguarJack\MigrateGenerator\MigrateGenerator;

class ThinkPHPCommand extends Command
{

    protected function configure()
    {
        // 指令配置
        $this->setName('migration:generate')
            ->setDescription('the app\command\generator command');
    }

    protected function execute(Input $input, Output $output)
    {
        $migrateGenerator = (new MigrateGenerator('thinkphp'));


        $tables = $migrateGenerator->getDatabase()->getAllTables();
        foreach ($tables as $key => $table) {
           file_put_contents($this->app->getRootPath() . '/database/migrations/' . $key . date('YmdHis') . '_' . $table->getName(). '.php' ,

               $migrateGenerator->getMigrationContent($table));

           $output->info(sprintf('%s table migration file generated', $table->getName()));
        }
    }
}

