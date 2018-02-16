<?php

namespace cubes\ecommerce\property\admin;

use cubes\ecommerce\property\PropertyBag;
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
            'properties' => $propertyService->getGlobalProperties()->mapToArray()
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSaveProperties(): Response
    {
        $properties = (array)$this->request->get('properties', []);
        $propertyBag = $this->container->get(PropertyBag::class);
        $propertyBag->mapFromArray($properties);
        $propertyService = $this->container->get(PropertyService::class);
        $propertyService->setGlobalProperties($propertyBag);
        return $this->responseJsonSuccess();
    }
}
