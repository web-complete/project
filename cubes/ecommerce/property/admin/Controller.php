<?php

namespace cubes\ecommerce\property\admin;

use cubes\ecommerce\property\PropertyService;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractController
{
    /**
     * @return Response
     * @throws \Exception
     */
    public function actionGetProperties(): Response
    {
        $propertyService = $this->container->get(PropertyService::class);
        return $this->responseJsonSuccess([
            'properties' => $propertyService->getGlobalProperties()
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSaveProperties(): Response
    {
        $properties = (array)$this->request->get('properties', []);
        $propertyService = $this->container->get(PropertyService::class);
        $propertyService->setGlobalProperties($properties);
        return $this->responseJsonSuccess();
    }
}
