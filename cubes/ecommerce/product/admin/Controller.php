<?php

namespace cubes\ecommerce\product\admin;

use cubes\ecommerce\product\Product;
use cubes\ecommerce\product\ProductConfig;
use cubes\ecommerce\property\property\PropertyFieldFactory;
use cubes\system\multilang\lang\classes\AbstractMultilangEntity;
use modules\admin\controllers\AbstractEntityController;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\form\AbstractForm;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = ProductConfig::class;

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
        /** @var Product $item */
        if (!$id || !($item = $entityService->findById($id))) {
            $item = $entityService->create();
        }

        $detailFields = $this->detailFieldsProcess($entityConfig->getDetailFields(), $item);

        return $this->responseJsonSuccess([
            'title' => $entityConfig->titleDetail,
            'detailFields' => $detailFields,
            'propertyFields' => $this->getPropertyFieldsData($item),
            'isMultilang' => $item instanceof AbstractMultilangEntity,
            'permissions' => $this->getPermissions(),
        ]);
    }

    /**
     * @param AbstractEntity|Product $item
     * @param AbstractForm $form
     *
     * @return bool
     */
    public function beforeSave(AbstractEntity $item, AbstractForm $form): bool
    {
        $data = (array)($this->request->get('data') ?? []);
        $propertiesData = (array)($data['propertiesData'] ?? []);
        $item->setPropertiesValues($propertiesData);
        return parent::beforeSave($item, $form);
    }

    /**
     * @param Product $product
     *
     * @return array
     * @throws \RuntimeException
     */
    protected function getPropertyFieldsData(Product $product): array
    {
        $result = [];
        $propertyFieldFactory = $this->container->get(PropertyFieldFactory::class);
        foreach ($product->getProperties() as $property) {
            $field = $propertyFieldFactory->createField($property);
            $field->processField();
            $result[] = $field->get();
        }
        return $result;
    }
}
