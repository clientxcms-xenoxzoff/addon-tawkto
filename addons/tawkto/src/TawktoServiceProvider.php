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

            $this->app['settings']->addCard(
                'tawkto',
                'Tawkto',
                'Configure your Tawk.to live chat',
                4,
                null,
                true,
                2
            );

            $this->app['settings']->addCardItem(
                'tawkto',
                'tawkto',
                'Tawk.to Configuration',
                'Enter your Tawk.to direct chat link',
                'bi bi-chat-dots',
                [TawktoAdminController::class, 'showSettings'],
                null
            );

            $this->app['extension']->addAdminMenuItem(
                new AdminMenuItem(
                    'tawkto',
                    'tawkto.admin',
                    'bi bi-chat-dots',
                'Tawk.to Chat',
                30,
                'admin.all'
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
        try {
            $url = setting('tawkto_chat_url');
        } catch (\Throwable $e) {
            return;
        }

        if (empty($url)) {
            return;
        }

        $script = $this->generateScript($url);

        if (empty($script)) {
            return;
        }

        Event::listen(RequestHandled::class, function (RequestHandled $event) use ($script) {
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

            $content = str_replace('</body>', $script . "\n</body>", $content);
            $response->setContent($content);
        });
    }

    protected function generateScript(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if ($path === null || !preg_match('#^/chat/([a-z0-9]+)/([a-z0-9]+)$#i', $path, $matches)) {
            return null;
        }

        $propertyId = $matches[1];
        $widgetId = $matches[2];

        return <<<HTML
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/{$propertyId}/{$widgetId}';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
HTML;
    }
}
