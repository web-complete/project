<?php

namespace modules\pub\widgets;

use WebComplete\mvc\widget\AbstractWidget;

class FooterWidget extends AbstractWidget
{

    /**
     * @param array $params
     *
     * @return string
     * @throws \Exception
     */
    public function run(array $params = []): string
    {
        return $this->render(__DIR__ . '/views/FooterWidget/template.php', $params);
    }
}
