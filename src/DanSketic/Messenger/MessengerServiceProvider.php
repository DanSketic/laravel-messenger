<?php

namespace DanSketic\Messenger;

use DanSketic\Messenger\Models\Message;
use DanSketic\Messenger\Models\Models;
use DanSketic\Messenger\Models\Participant;
use DanSketic\Messenger\Models\Thread;
use Illuminate\Support\ServiceProvider;

class MessengerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('vendor/dansketic/messenger/src/config/config.php') => config_path('messenger.php'),
            ], 'config');

            $this->publishes([
                base_path('vendor/dansketic/messenger/src/migrations') => base_path('database/migrations'),
            ], 'migrations');
        }

        $this->setMessengerModels();
        $this->setUserModel();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            base_path('vendor/dansketic/messenger/src/config/config.php'), 'messenger'
        );
    }

    private function setMessengerModels()
    {
        $config = $this->app->make('config');

        Models::setMessageModel($config->get('messenger.message_model', Message::class));
        Models::setThreadModel($config->get('messenger.thread_model', Thread::class));
        Models::setParticipantModel($config->get('messenger.participant_model', Participant::class));

        Models::setTables([
            'messages' => $config->get('messenger.messages_table', Models::message()->getTable()),
            'participants' => $config->get('messenger.participants_table', Models::participant()->getTable()),
            'threads' => $config->get('messenger.threads_table', Models::thread()->getTable()),
        ]);
    }

    private function setUserModel()
    {
        $config = $this->app->make('config');

        $model = $config->get('auth.providers.users.model', function () use ($config) {
            return $config->get('auth.model', $config->get('messenger.user_model'));
        });

        Models::setUserModel($model);

        Models::setTables([
            'users' => (new $model)->getTable(),
        ]);
    }
}
