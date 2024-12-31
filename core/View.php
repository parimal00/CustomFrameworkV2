<?php

namespace app\core;

class View
{
    public function renderView($view, string $layout= 'main', $params = [])
    {
        foreach($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include Application::$root."/views/$view.php"; // Include the view
        $content = ob_get_clean();

        return str_replace("{{content}}", $content,  $this->getLayout($layout));
    }

    private function getLayout(string $layout)
    {
        return file_get_contents(Application::$root."/views/layouts/$layout.php");
    }
}
