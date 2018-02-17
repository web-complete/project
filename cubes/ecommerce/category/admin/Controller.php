<?php

namespace cubes\ecommerce\category\admin;

use cubes\ecommerce\category\Category;
use cubes\ecommerce\category\CategoryConfig;
use cubes\ecommerce\property\PropertyService;
use cubes\system\multilang\lang\classes\AbstractMultilangEntity;
use modules\admin\controllers\AbstractEntityController;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\form\AbstractForm;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = CategoryConfig::class;

    /**
     * @param $id
     *
     * @return Response
     * @throws \Exception
     */
    public function actionDetail($id): Response
    {
        $id = (int)$id;
        $entityConfig = $this->getEntityConfig();
        $entityService = $this->getEntityService();
        /** @var Category $item */
        if (!$id || !($item = $entityService->findById($id))) {
            $item = $entityService->create();
        }

        $detailFields = $this->detailFieldsProcess($entityConfig->getDetailFields(), $item);

        return $this->responseJsonSuccess([
            'title' => $entityConfig->titleDetail,
            'detailFields' => $detailFields,
            'isMultilang' => $item instanceof AbstractMultilangEntity,
            'permissions' => $this->getPermissions(),
            'properties' => $item->getPropertyBag()->mapToArray(),
        ]);
    }

    /**
     * @param AbstractEntity $item
     * @param AbstractForm $form
     *
     * @return bool
     */
    public function beforeSave(AbstractEntity $item, AbstractForm $form): bool
    {
        $data = (array)($this->request->get('data') ?? []);
        $properties = (array)($data['properties'] ?? []);
        $this->saveProperties($item, $properties);
        return parent::beforeSave($item, $form);
    }

    /**
     * @param AbstractEntity $item
     * @param array $data
     */
    protected function saveProperties(AbstractEntity $item, array $data)
    {
        $propertyService = $this->container->get(PropertyService::class);
        $propertyBag = $propertyService->createBag($data);

        $sort = 1;
        $enabled = [];
        foreach ($propertyBag->all() as $property) {
            if ($property->enabled) {
                $enabled[] = $property->code;
            }
            if ($property->global) {
                $sort = $property->sort + 1;
                $propertyBag->remove($property->code);
            } else {
                $property->global = false;
                $property->sort = $sort++;
            }
        }
        $propertyBag->sort();
        $item->set('properties', $propertyBag->mapToArray());
        $item->set('properties_enabled', $enabled);
    }
}
