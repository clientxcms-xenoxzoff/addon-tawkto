<?php

namespace App\Addons\Tawkto;

use App\Addons\Tawkto\Controllers\TawktoAdminController;
use App\Extensions\BaseAddonServiceProvider;
use Illuminate\Support\Facades\View;

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
        $widgetId = setting('tawkto_widget_id');

        if (empty($widgetId)) {
            return;
        }

        View::composer('default::layouts.app', function ($view) use ($widgetId) {
            $view->with('tawkto_widget', $this->widgetScript($widgetId));
        });
    }

    protected function widgetScript(string $widgetId): string
    {
        return <<<HTML
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/{$widgetId}/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
HTML;
    }
}
