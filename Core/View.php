<?php

namespace App\Core;

class View
{
    private string $usedLayout = '/layouts/main';
    private const RENDER_FILE_EXTENSION = '.inso.php';
    public ?string $title = null;

    public function renderView($view, $params = []): array|bool|string
    {
        $view = $this->renderOnlyView($view . self::RENDER_FILE_EXTENSION, $params);
        $layout = $this->layout();

        return str_replace('{{content}}', $view, $layout);
    }

    private function layout(): bool|string
    {
        $layout = $this->usedLayout  . self::RENDER_FILE_EXTENSION;
        ob_start();
        include_once rootPath() . '/Resources/views/' . $layout;
        return ob_get_clean();
    }

    private function renderOnlyView($view, $params): bool|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once rootPath() . '/Resources/views/' . $view;
        return ob_get_clean();
    }

    private function renderContent($view): array|bool|string
    {
        $layout = $this->layout($this->usedLayout);

        return str_replace('{{content}}', $view, $layout);
    }


    public function setLayout($layout)
    {
        $this->usedLayout = $layout;
    }
}
