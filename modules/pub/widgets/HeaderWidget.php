<?php

namespace modules\pub\widgets;

use WebComplete\mvc\widget\AbstractWidget;

class HeaderWidget extends AbstractWidget
{

    /**
     * @param array $params
     *
     * @return string
     * @throws \Exception
     */
    public function run(array $params = []): string
    {
        return $this->render(__DIR__ . '/views/HeaderWidget/template.php', $params);
    }
}
