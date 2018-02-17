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
            'properties' => $propertyService->getGlobalPropertyBag()->mapToArray()
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSaveProperties(): Response
    {
        $data = (array)$this->request->get('properties', []);
        $propertyService = $this->container->get(PropertyService::class);
        $propertyBag = $propertyService->createBag($data);

        $sort = 1000;
        foreach ($propertyBag->all() as $property) {
            $property->global = true;
            $property->sort = $sort;
            $sort += 1000;
        }
        $propertyBag->sort();

        $propertyService = $this->container->get(PropertyService::class);
        $propertyService->setGlobalProperties($propertyBag);
        return $this->responseJsonSuccess();
    }
}
