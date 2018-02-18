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
            'propertyFields' => $this->getPropertyFieldsData($item, $item->category_id),
            'isMultilang' => $item instanceof AbstractMultilangEntity,
            'permissions' => $this->getPermissions(),
        ]);
    }

    /**
     * @param $productId
     * @param $categoryId
     *
     * @return Response
     * @throws \Exception
     */
    public function actionProperties($productId, $categoryId): Response
    {
        $entityService = $this->getEntityService();
        /** @var Product $item */
        if (!$productId || !($item = $entityService->findById($productId))) {
            $item = $entityService->create();
        }

        return $this->responseJsonSuccess([
            'propertyFields' => $this->getPropertyFieldsData($item, $categoryId),
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
        $item->category_id = $form->getValue('category_id');
        $item->setPropertiesValues($propertiesData);
        return parent::beforeSave($item, $form);
    }

    /**
     * @param Product $product
     *
     * @param $categoryId
     *
     * @return array
     */
    protected function getPropertyFieldsData(Product $product, $categoryId): array
    {
        $result = [];
        $propertyFieldFactory = $this->container->get(PropertyFieldFactory::class);
        $product->category_id = $categoryId;
        foreach ($product->getProperties() as $property) {
            $field = $propertyFieldFactory->createField($property);
            $field->processField();
            $result[] = $field->get();
        }
        return $result;
    }
}
