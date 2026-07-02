<?php

namespace App\Addons\Tawkto;

use App\Addons\Tawkto\Controllers\TawktoAdminController;
use App\Core\Menu\AdminMenuItem;
use App\Extensions\BaseAddonServiceProvider;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Event;

class TawktoServiceProvider extends BaseAddonServiceProvider
{
    protected string $uuid = 'tawkto';

    public function register()
    {
    }

    public function boot()
    {
        try {
            if (!is_installed()) {
                return;
            }

            $this->loadViews();
            $this->loadTranslations();
            $this->loadMigrations();

            $this->app['settings']->addCard(
                'tawkto',
                'tawkto::messages.admin.title',
                'tawkto::messages.admin.subheading',
                4,
                null,
                true,
                1
            );

            $this->app['settings']->addCardItem(
                'tawkto',
                'tawkto',
                'tawkto::messages.admin.settings.title',
                'tawkto::messages.admin.settings.description',
                'bi bi-chat-dots',
                [TawktoAdminController::class, 'showSettings'],
                'admin.tawkto'
            );

            $this->app['extension']->addAdminMenuItem(
                new AdminMenuItem(
                    'tawkto',
                    'tawkto.admin',
                    'bi bi-chat-dots',
                    'tawkto::messages.admin.menu_title',
                    30,
                    'admin.tawkto'
                )
            );

            \Route::middleware(['web', 'admin'])
                ->prefix(admin_prefix())
                ->name($this->uuid . '.')
                ->group(function () {
                    require addon_path($this->uuid, 'routes/admin.php');
                });

            $this->injectWidget();
        } catch (\Throwable $e) {
        }
    }

    protected function injectWidget()
    {
        $code = setting('tawkto_widget_code');

        if (empty($code)) {
            return;
        }

        Event::listen(RequestHandled::class, function (RequestHandled $event) use ($code) {
            $request = $event->request;
            $response = $event->response;

            if ($request->is(admin_prefix() . '/*')) {
                return;
            }

            if (!$response instanceof \Illuminate\Http\Response) {
                return;
            }

            $content = $response->getContent();

            if (empty($content)) {
                return;
            }

            $content = str_replace('</body>', $code . "\n</body>", $content);
            $response->setContent($content);
        });
    }
}
