<?php

namespace cubes\multilang\translation\admin;

use cubes\multilang\translation\Translation;
use cubes\multilang\translation\TranslationService;
use modules\admin\controllers\AbstractController;

class TranslationController extends AbstractController
{

    protected $needAuth = false;

    /**
     * auto create translation (from js)
     *
     * @throws \Exception
     */
    public function actionCreateTranslation()
    {
        $namespace = $this->request->get('namespace', '_');
        $original = $this->request->get('text');
        $service = $this->container->get(TranslationService::class);
        $condition = $service->createCondition(['namespace' => $namespace, 'original' => $original]);
        if (!$service->findOne($condition)) {
            /** @var Translation $item */
            $item = $service->create();
            $item->namespace = $namespace;
            $item->original = $original;
            $service->save($item);
        }

        return $this->responseJsonSuccess();
    }
}
