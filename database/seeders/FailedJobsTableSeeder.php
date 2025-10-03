<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FailedJobsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('failed_jobs')->delete();
        
        \DB::table('failed_jobs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => 'ca1cff42-0bf2-4eb9-8fa5-4d7054050420',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"ca1cff42-0bf2-4eb9-8fa5-4d7054050420","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":0:{}"}}',
                'exception' => 'ErrorException: Attempt to read property "start_time" on null in D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php:39
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Bootstrap\\HandleExceptions.php(256): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'Attempt to read...\', \'D:\\\\Apps\\\\laragon...\', 39)
#1 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(39): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->Illuminate\\Foundation\\Bootstrap\\{closure}(2, \'Attempt to read...\', \'D:\\\\Apps\\\\laragon...\', 39)
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#35 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#36 {main}',
                'failed_at' => '2024-09-12 16:10:15',
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => 'a0ebf73d-2a89-4aea-8225-67951b409275',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"a0ebf73d-2a89-4aea-8225-67951b409275","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:14:\\"\\u0000*\\u0000auctionCode\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:18:\\"App\\\\Models\\\\Auction\\";s:2:\\"id\\";s:9:\\"RG2409002\\";s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => '576d6e19-3440-4616-bbc2-cc0c77266c47',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"576d6e19-3440-4616-bbc2-cc0c77266c47","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:14:\\"\\u0000*\\u0000auctionCode\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:18:\\"App\\\\Models\\\\Auction\\";s:2:\\"id\\";s:9:\\"RG2409002\\";s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => 'cf1aba91-d6f1-48a9-8534-f2a28c406352',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"cf1aba91-d6f1-48a9-8534-f2a28c406352","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:18:\\"App\\\\Models\\\\Auction\\";s:2:\\"id\\";s:9:\\"RG2409002\\";s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            4 => 
            array (
                'id' => 5,
                'uuid' => '3b0487d1-207e-42d9-a18e-c2b293c4bf85',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"3b0487d1-207e-42d9-a18e-c2b293c4bf85","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409001\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            5 => 
            array (
                'id' => 6,
                'uuid' => 'e5228fa5-3ff1-48dd-87ee-53ab5c1fdba6',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"e5228fa5-3ff1-48dd-87ee-53ab5c1fdba6","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            6 => 
            array (
                'id' => 7,
                'uuid' => '44085f54-9d23-403a-932d-43c0ac4da0e8',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"44085f54-9d23-403a-932d-43c0ac4da0e8","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409001\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            7 => 
            array (
                'id' => 8,
                'uuid' => '4bfa8336-eeef-4983-82ce-e9ea0fe0a3b4',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"4bfa8336-eeef-4983-82ce-e9ea0fe0a3b4","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            8 => 
            array (
                'id' => 9,
                'uuid' => '090b0685-5454-4c79-a2a9-61f76c639601',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"090b0685-5454-4c79-a2a9-61f76c639601","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409001\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            9 => 
            array (
                'id' => 10,
                'uuid' => 'b508a24c-5dfa-46a6-9aba-cc091c2cd513',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"b508a24c-5dfa-46a6-9aba-cc091c2cd513","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            10 => 
            array (
                'id' => 11,
                'uuid' => 'aff278a8-372f-4357-9f69-4f8f0e94582c',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"aff278a8-372f-4357-9f69-4f8f0e94582c","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:14:\\"\\u0000*\\u0000auctionCode\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:18:\\"App\\\\Models\\\\Auction\\";s:2:\\"id\\";s:9:\\"RG2409002\\";s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            11 => 
            array (
                'id' => 12,
                'uuid' => '9b68258a-16e4-442f-b68e-df62e77bf73b',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"9b68258a-16e4-442f-b68e-df62e77bf73b","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409001\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            12 => 
            array (
                'id' => 13,
                'uuid' => '9a11c09f-5319-4996-a1fd-14d8ea1143c0',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"9a11c09f-5319-4996-a1fd-14d8ea1143c0","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            13 => 
            array (
                'id' => 14,
                'uuid' => '53010a02-dec0-4b3e-b24e-47afe0c09492',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"53010a02-dec0-4b3e-b24e-47afe0c09492","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409001\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            14 => 
            array (
                'id' => 15,
                'uuid' => '1cc4c5ab-4820-4777-a4d6-2764d4a0d7c4',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"1cc4c5ab-4820-4777-a4d6-2764d4a0d7c4","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            15 => 
            array (
                'id' => 16,
                'uuid' => 'e95e9788-ae59-433e-bd2d-74b8500b37c2',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"e95e9788-ae59-433e-bd2d-74b8500b37c2","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409001\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            16 => 
            array (
                'id' => 17,
                'uuid' => '6a910361-83ec-45f3-ba79-ede808757272',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"6a910361-83ec-45f3-ba79-ede808757272","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:12:\\"\\u0000*\\u0000auctionId\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Auction]. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:637
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\app\\Jobs\\UpdateAuctionStatus.php(37): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\UpdateAuctionStatus->handle()
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\UpdateAuctionStatus), false)
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\UpdateAuctionStatus))
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\UpdateAuctionStatus))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#21 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#22 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#23 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#24 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#25 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#26 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#27 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#28 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#29 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#30 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#31 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#32 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#33 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#34 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#35 {main}',
                'failed_at' => '2024-09-12 16:39:59',
            ),
            17 => 
            array (
                'id' => 18,
                'uuid' => '096b0206-dbff-4ddc-9310-709eb2628234',
                'connection' => 'database',
                'queue' => 'default',
                'payload' => '{"uuid":"096b0206-dbff-4ddc-9310-709eb2628234","displayName":"App\\\\Jobs\\\\UpdateAuctionStatus","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\UpdateAuctionStatus","command":"O:28:\\"App\\\\Jobs\\\\UpdateAuctionStatus\\":1:{s:14:\\"\\u0000*\\u0000auctionCode\\";s:9:\\"RG2409002\\";}"}}',
                'exception' => 'Illuminate\\Queue\\MaxAttemptsExceededException: App\\Jobs\\UpdateAuctionStatus has been attempted too many times. in D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\MaxAttemptsExceededException.php:24
Stack trace:
#0 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(785): Illuminate\\Queue\\MaxAttemptsExceededException::forJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob))
#1 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(519): Illuminate\\Queue\\Worker->maxAttemptsExceededException(Object(Illuminate\\Queue\\Jobs\\DatabaseJob))
#2 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), 1)
#3 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))
#4 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(333): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))
#5 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->runNextJob(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))
#6 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')
#7 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()
#8 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()
#9 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))
#10 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))
#11 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)
#12 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)
#13 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#14 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))
#15 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#16 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#17 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#18 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#19 D:\\Apps\\laragon\\www\\yuki_koi\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))
#20 D:\\Apps\\laragon\\www\\yuki_koi\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))
#21 {main}',
                'failed_at' => '2024-09-12 16:41:29',
            ),
        ));
        
        
    }
}