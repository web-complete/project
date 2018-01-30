<?php

namespace cubes\notification\template;

use cubes\multilang\lang\classes\AbstractMultilangEntity;
use cubes\system\logger\Log;

/**
 *
 * @property $code
 * @property $subject
 * @property $html
 * @property $text
*/
class Template extends AbstractMultilangEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return TemplateConfig::getFieldTypes();
    }

    /**
     * @param array $vars
     *
     * @return string
     */
    public function renderSubject(array $vars = []): string
    {
        return $this->render($this->subject, $vars);
    }

    /**
     * @param array $vars
     *
     * @return string
     */
    public function renderHtml(array $vars = []): string
    {
        return $this->render($this->html, $vars);
    }

    /**
     * @param array $vars
     *
     * @return string
     */
    public function renderText(array $vars = []): string
    {
        return $this->render($this->text, $vars);
    }

    /**
     * @param string $content
     * @param array $vars
     *
     * @return string
     */
    protected function render(string $content, array $vars): string
    {
        $result = '';
        try {
            $loader = new \Twig_Loader_Array(['template' => $content]);
            $twig = new \Twig_Environment($loader);
            $result = $twig->render('template', $vars);
        } catch (\Exception $e) {
            Log::exception($e);
        }
        return $result;
    }
}
