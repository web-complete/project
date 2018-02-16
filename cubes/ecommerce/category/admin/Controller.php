<?php

namespace cubes\ecommerce\category\admin;

use cubes\ecommerce\category\Category;
use cubes\ecommerce\category\CategoryConfig;
use cubes\system\multilang\lang\classes\AbstractMultilangEntity;
use modules\admin\controllers\AbstractEntityController;
use Symfony\Component\HttpFoundation\Response;

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
            'properties' => $item->getProperties(),
        ]);
    }
}
