<?php

namespace cubes\ecommerce\property\admin;

use cubes\system\storage\Storage;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractController
{
    const TODO_MOVE_KEY = 'ecommerce:properties'; // TODO

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionGetProperties(): Response
    {
        $storage = $this->container->get(Storage::class);
        return $this->responseJsonSuccess([
            'properties' => (array)$storage->get(self::TODO_MOVE_KEY, [])
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSaveProperties(): Response
    {
        $properties = (array)$this->request->get('properties', []);
        $storage = $this->container->get(Storage::class);
        $storage->set(self::TODO_MOVE_KEY, $properties);
        return $this->responseJsonSuccess();
    }
}
